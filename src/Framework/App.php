<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    /**
     * List of modules
     * @var array
     */
    private $modules= [];

    /**
     * Router
     * @var Router
     */
    private $router= null;

    /**
     * App constructor
     * @param string[] $modules si the list of the modules to be loaded
     */
    public function __construct(array $modules = [])
    {
        $this->router= new Router();
        foreach ($modules as $module) {
            $this->modules[]= new $module($this->router);
        }
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && $uri[-1] === "/") {
            $response = new Response();
            $response = $response->withStatus(301);
            $response = $response->withHeader('Location', substr($uri, 0, -1));
            return $response;
        }

        $route= $this->router->match($request);

        if (is_null($route)) {
            return new Response(404, [], "<h1>404 error.</h1>");
        }
        $response= call_user_func_array($route->getCallable(), [$request]);
        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception("The response is nor a string nor an instance of ResponseInterface.");
        }
    }
}
