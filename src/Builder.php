<?php

namespace ArnoBirchler\Curl;


class Builder {

    /**
     * Set the URL to which the request is to be sent
     *
     * @param $url string   The URL to which the request is to be sent
     * @return Builder
     */

    protected $url = '';
    protected $data;
    protected $method = 'get';
    protected $json = false;

    protected function to(String $url){
        return $this->url = $url;
    }

    protected function json(){
        $this->json = true;
    }

    protected function get(){
        $this->method = 'get';
        $this->send();
    }

    protected function post(){
        $this->method = 'post';
        $this->send();
    }

    protected function send(){
        $response = \Ixudra\Curl\Facades\Curl::to($this->url)
            ->returnResponseObject()
            ->withData( $this->url )
            ->get();

        if($response->status != 200){
            if(isset($response->error)){
                $message = $response->error;
            }else{
                $message = $response->content;
            }
            throw new \Exception('Error from distance site : ' . $message, 400);
        }
        if($response->content === "0" OR $response->content != false) {
            if($this->json) {
                $value = $this->safe_json_decode($response->content);
                if (is_string($value)) {
                    throw new \Exception('JSON Error : ' . $value);
                } else {
                    return $value;
                }
            }else{
                return $response->content;
            }
        }
        else{
            throw new \Exception('Error from distante site : unkown error');
        }
    }

    protected function withData($data){
        return $this->data = $data;
    }

    private function safe_json_decode($value, $options = 0, $depth = 512){
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





