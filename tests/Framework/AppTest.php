<?php
namespace Tests\Framework;

use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase {
    public function testRedirectTrainningSlash(){
        $app= new App();
        $request= new ServerRequest('GET', '/demoslash/');
        $response= $app->run($request);
        $this->assertContains('/demoslash', $response->getHeader('Location'));
        $this->assertEquals(301, $response->getStatusCode());
    }

    public function testBlog() {
        $app= new App();
        $request= new ServerRequest('GET', '/blog');
        $response= $app->run($request);
        $this->assertContains('Hello.', [(string)($response->getBody())]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testError404() {
        $app= new App();
        $request= new ServerRequest('GET', '/azaza');
        $response= $app->run($request);
        $this->assertContains('404 error.', [(string)($response->getBody())]);
        $this->assertEquals(404, $response->getStatusCode());
    }
}