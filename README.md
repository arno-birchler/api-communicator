# Curl

## Dev
[![pipeline status](https://gitlab.com/arno.birchler/curl/badges/dev/pipeline.svg)](https://gitlab.com/arno.birchler/curl/commits/dev)
[![coverage report](https://gitlab.com/arno.birchler/curl/badges/dev/coverage.svg)](https://gitlab.com/arno.birchler/curl/commits/dev)

## Master

[![pipeline status](https://gitlab.com/arno.birchler/curl/badges/master/pipeline.svg)](https://gitlab.com/arno.birchler/curl/commits/master)
[![coverage report](https://gitlab.com/arno.birchler/curl/badges/master/coverage.svg)](https://gitlab.com/arno.birchler/curl/commits/master)


High level Requester based on Ixudra/curl 

# Usage for laravel 

```
use Arnobirchler\Curl\CurlService;
<--- ... --->
$curl = new CurlService();
$response = $curl->to('https://google.com')->withDatas(['foo' => 'bar'])->get();
```