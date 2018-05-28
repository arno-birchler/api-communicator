<?php

class CurlServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        require_once __DIR__ . '/../../src/CurlService.php';
    }

    protected function _after()
    {
    }

    // tests
    public function testTo()
    {
        $curl = new \ArnoBirchler\Curl\CurlService();
        $this->assertTrue($curl->to('www.google.com') instanceof \ArnoBirchler\Curl\Builder);
    }
}