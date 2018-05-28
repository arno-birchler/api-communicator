<?php



class BuilderTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $builder;
    protected $curl;
    protected $url = 'www.google.com';
    
    protected function _before()
    {
        require_once __DIR__ . '/../../vendor/autoload.php';
        \Codeception\Util\Autoload::addNamespace('Arnobirchler', 'src');
        \Codeception\Util\Autoload::load(\ArnoBirchler\Curl\Builder::class);
        require_once __DIR__ . '/../../src/CurlService.php';
        require_once __DIR__ . '/../../src/Builder.php';
        $this->builder = new \ArnoBirchler\Curl\Builder();
        $this->curl = new \ArnoBirchler\Curl\CurlService();
    }

    protected function _after()
    {

    }

    // tests
    public function testJson()
    {
        $this->assertFalse($this->builder->getCurlDatas()['JSON']);
        $this->builder->json();
        $this->assertTrue($this->builder->getCurlDatas()['JSON']);
    }

    public function testTo(){
       $this->assertEquals('', $this->builder->getCurlDatas()['URL']);
       $this->builder->to($this->url);
       $this->assertEquals($this->url, $this->builder->getCurlDatas()['URL']);
    }

    public function testWithDatas(){
        $this->assertEmpty($this->builder->getCurlDatas()['DATAS']);
        $this->builder->withDatas(['test' => 'test']);
        $this->assertArrayHasKey('test', $this->builder->getCurlDatas()['DATAS']);
    }

    public function testGet(){
        $response = $this->builder->to($this->url)->get();
        $this->assertEquals(200, $response->status);
    }
    public function testPost(){
        $response = $this->builder->to($this->url)->post();
        $this->assertEquals(200, $response->status);
    }
}