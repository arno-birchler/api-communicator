<?php

class CurlServiceProviderTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $provider;
    
    protected function _before()
    {
        require_once __DIR__ . '/../../src/CurlServiceProvider.php';
        $app = new \Codeception\Application(
            realpath(__DIR__.'/../')
        );
        $this->provider = new \ArnoBirchler\Curl\CurlServiceProvider($app);
    }

    protected function _after()
    {
    }



    public function testProvides(){
        $this->assertEquals( array('Curl'), $this->provider->provides());
    }
}