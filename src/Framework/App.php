<?php
namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App {
    public function run(ServerRequestInterface $request): ResponseInterface {
        // $uri= $_SERVER['REQUEST_URI'];
        $uri= $request->getUri()->getPath();
        if(!empty($uri) && $uri[-1] === "/"){
            $response= new Response();
            $response= $response->withStatus(301);
            $response= $response->withHeader('Location', substr($uri, 0, -1));
            return $response;

            // header('Location: ' . substr($uri, 0, -1));
            // header('HTTP/1.1 301 Moved Permanently');
            // exit();
        }
        if($uri=== '/blog'){
            return (new Response(200, [], 'Hello.'));
        }
        $response= new Response(404, [], "404 error.");
        // $response->getBody()->write("404 error.");
        return $response;
    }
}