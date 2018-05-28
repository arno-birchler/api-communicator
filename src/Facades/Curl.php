<?php
namespace ArnoBirchler\Curl\Facades;

use Illuminate\Support\Facades\Facades;

class Curl extends Facade {

	/**
	* @return string
	*/
	protected static function getFacadeAccessor(){
		return 'Curl';
	}
}
