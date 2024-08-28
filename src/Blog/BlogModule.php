<?php
namespace App\Blog;

use Framework\Router;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogModule
{
    public function __construct(Router $router)
    {
        $router->get('/blog', [$this, 'index'], 'blog.index');
        $router->get('/blog/{slug:[a-z\-]+}', [$this, 'show'], 'blog.show');
    }

    public function index(Request $request): string
    {
        return '<h1>Welcome.</h1>';
    }

    public function show(Request $request): string
    {
        // $slug= $request->getAttribute('slug');
        // $slug= $request->getAttributes();
        // var_dump($slug);
        return "<h1>Post {$request->getAttribute('slug')}.</h1>";
    }
}
