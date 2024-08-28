<?php
namespace Framework;

use Framework\Router\Route;
use Psr\Http\Message\ServerRequestInterface;
use Framework\MqbakaFastRouteRouter;
use Zend\Expressive\Router\Route as ZendRoute;

/**
 * Class Router
 * Registers and matches routes
 */
class Router
{
    /**
     * @var MqbakaFastRouteRouter
     */
    private $router;

    public function __construct()
    {
        // $this->router = new FastRouteRouter();
        $this->router = new MqbakaFastRouteRouter();
    }

    /**
     * @param string $path
     * @param callable $callable
     * @param string $name
     */
    public function get(string $path, callable $callable, string $name)
    {
        $new_route= new ZendRoute($path, $callable, ['GET'], $name);
        // var_dump(($new_route->getName()));
        $this->router->addRoute($new_route);
    }

    /**
     * @param ServerRequestInterface $request
     * @return Route|null
     */
    public function match(ServerRequestInterface $request): ?Route
    {
        $result = $this->router->match($request);
        // var_dump($result);
        if ($result->isSuccess()) {
            return new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedMiddleware(),
                $result->getMatchedParams()
            );
        }
        return null;
    }
}
