<?php
namespace Tests\Framework;

use App\Blog\BlogModule;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Tests\Framework\Modules\ErroredModule;

class AppTest extends TestCase {
    public function testRedirectTrainningSlash(){
        $app= new App();
        $request= new ServerRequest('GET', '/demoslash/');
        $response= $app->run($request);
        $this->assertContains('/demoslash', $response->getHeader('Location'));
        $this->assertEquals(301, $response->getStatusCode());
    }

    public function testBlog() {
        $app= new App([
            BlogModule::class
        ]);
        $request= new ServerRequest('GET', '/blog');
        $response= $app->run($request);
        $this->assertContains('<h1>Welcome.</h1>', [(string)($response->getBody())]);
        $this->assertEquals(200, $response->getStatusCode());
        
        $requestSingle= new ServerRequest('GET', '/blog/test-article');
        $responseSingle= $app->run($requestSingle);
        // var_dump(($requestSingle->getAttributes()));
        $this->assertContains("<h1>Post test-article.</h1>", [(string)($responseSingle->getBody())]);
    }

    public function testError404() {
        $app= new App();
        $request= new ServerRequest('GET', '/azaza');
        $response= $app->run($request);
        $this->assertContains('404 error.', [(string)($response->getBody())]);
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testThrowExceptionIfNoResponseSent ()
    {
        $app= new App([
            ErroredModule::class
        ]);
        $request= new ServerRequest('GET', '/demo');
        $this->expectException(\Exception::class);
        $app->run($request);
    }
}