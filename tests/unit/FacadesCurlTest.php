<?php


class FacadesCurlTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        require_once __DIR__ . '/../../src/Facades/Curl.php';
    }

    protected function _after()
    {
    }


}