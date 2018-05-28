<?php

namespace ArnoBirchler\Curl;


class Builder {


    /**
     * @var array
     */
    protected $curlDatas = [
        'URL' => '',
        'DATAS' => [],
        'METHOD' => 'GET',
        'JSON' => false,
    ];

    /**
     * @param mixed $curlDatas
     * @param string $key
     */

    protected function setCurlDatas($curlDatas, string $key)
    {
        $this->curlDatas[$key] = $curlDatas;
    }

    /**
     * @return mixed
     */
    public function getCurlDatas()
    {
        return $this->curlDatas;
    }


    /**
     * Set the URL to which the request is to be sent
     *
     * @param $url string   The URL to which the request is to be sent
     * @return Builder
     */

    public function to(String $url){
        $this->setCurlDatas($url, 'URL');
        return $this;
    }


    public function json(){
        $this->setCurlDatas(true,'JSON');
    }

    public function get(){
        $this->method = 'get';
        return $this->send();
    }

    public function post(){
        $this->method = 'post';
        return $this->send();
    }



    protected function send(){
        $curl = new \Ixudra\Curl\CurlService();
        $response = $curl->to($this->curlDatas['URL'])
            ->returnResponseObject()
            ->withData( $this->curlDatas['DATAS'] )
            ->get();
        /*
        $response = \Ixudra\Curl\Facades\Curl::to($this->curlDatas['URL'])
            ->returnResponseObject()
            ->withData( $this->curlDatas['DATAS'] )
            ->get();*/

        if($response->status != 200){
            if(isset($response->error)){
                $message = $response->error;
            }else{
                $message = $response->content;
            }
            throw new \Exception('Error from distance site : ' . $message, 400);
        }
        if($response->content === "0" OR $response->content != false) {
            if($this->curlDatas['JSON']) {
                $value = $this->safe_json_decode($response->content);
                if (is_string($value)) {
                    throw new \Exception('JSON Error : ' . $value);
                } else {
                    return $value;
                }
            }else{
                return $response;
            }
        }
        else{
            throw new \Exception('Error from distante site : unkown error');
        }
    }

    public function withDatas($data){
        return $this->setCurlDatas($data, 'DATAS');
    }

    protected function safe_json_decode($value, $options = 0, $depth = 512){
        $encoded = json_decode($value, $options, $depth);
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return $encoded;
            case JSON_ERROR_DEPTH:
                return 'Maximum stack depth exceeded'; // or trigger_error() or throw new Exception()
            case JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch'; // or trigger_error() or throw new Exception()
            case JSON_ERROR_CTRL_CHAR:
                return 'Unexpected control character found';
            case JSON_ERROR_SYNTAX:
                return 'Syntax error, malformed JSON'; // or trigger_error() or throw new Exception()
            case JSON_ERROR_UTF8:
                $clean = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($value));
                return $this->safe_json_decode($clean, $options, $depth);
            default:
                return 'Unknown error'; // or trigger_error() or throw new Exception()

        }
    }
}





