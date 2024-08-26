<?php
namespace Tests\Framework;

use PHPUnit\Framework\TestCase;
use Framework\App;

class AppTest extends TestCase {
    public function testRedirectTrainningSlash(){
        $app= new App();
        $request= new Request('/azazazaz/');
        $response= $app->run($request);
        $this->assertEquals('/azazazaz', $response->getHearer('Location'));
        $this->assertEquals(301, $response->getStatus());
    }
}