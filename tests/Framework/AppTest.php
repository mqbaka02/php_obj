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
        $this->assertEquals('/demoslash', $response->getHeader('Location'));
        $this->assertEquals(301, $response->getStatus());
    }
}