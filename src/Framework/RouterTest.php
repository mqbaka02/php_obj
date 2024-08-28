<?php

namespace Tests\Framework;

use Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @var Router
     */
    private $router;

    public function setUp(): void
    {
        $this->router= new Router();
    }

    public function testGetMethod()
    {
        $request= new ServerRequest('GET', '/blog');
        $this->router->get('/blog', function () {
            return 'hello';
        }, 'blog');

        $route= $this->router->match($request);
        // var_dump($route->getName());
        $this->assertEquals('blog', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallable(), [$request]));
    }

    public function testGetMethodIfURLDoesNotExist()
    {
        $request= new ServerRequest('GET', '/blog');
        // $request= new ServerRequest('GET', '/blog');
        $this->router->get('/blogaze', function () {
            return 'hello';
        }, 'blog');
        $route= $this->router->match($request);
        $this->assertEquals(null, $route);
    }

    public function testGetMethodWithParameters()
    {
        $request= new ServerRequest('GET', '/blog/my-slug-8');
        // $request= new ServerRequest('GET', '/blog/my-slug-8');
        $this->router->get('/blog', function () {
            return 'azaz';
        }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {
            return 'hello';
        }, 'post.show');

        $route= $this->router->match($request);
        $this->assertEquals('post.show', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallable(), [$request]));
        $this->assertEquals(['slug'=> 'my-slug', 'id'=> '8'], $route->getParams());

        //Invalid URL test
        $route= $this->router->match(new ServerRequest('GET', '/blog/my_slug-8'));
        var_dump($route);
        $this->assertEquals(null, $route);
    }

    public function testGenerateUri()
    {
        $this->router->get('/blog', function () {
            return 'azaz';
        }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {
            return 'hello';
        }, 'post.show');
        $uri= $this->router->generateUri('post.show', ['slug'=> 'my-post', 'id'=> 18]);
        $this->assertEquals('/blog/my-post-18', $uri);
    }
}
