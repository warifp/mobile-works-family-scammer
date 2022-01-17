<?php

require __DIR__ . '/vendor/autoload.php';

use Curl\Curl;

class MobileWorksScam
{
    function __construct()
    {
        $this->curl = new Curl();
    }

    public function register($url, $name)
    {
        $pregName = preg_split('/(?=[A-Z])/', $name);

        $this->curl = new Curl();
        $this->curl->setHeader('Host', $url);
        $this->curl->setHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        $this->curl->post('https://' . $url . '/api.php?act=register', 'fullname=' . $pregName[1] . ' ' . $pregName[2] . '&username=' . strtolower($name) . '&email=' . strtolower($name) . '@gmail.com&password=' . strtolower($name) . rand(111, 999));

        if ($this->curl->error) {
            // echo 'Error: ' . $this->curl->errorCode . ': ' . $this->curl->errorMessage . "\n";
            echo '[x] Error ' . $this->curl->errorCode . ': ' . $this->curl->errorMessage . "\n";
        } else {
            return $this->curl->response;
        }
    }

    public function getName()
    {
        $this->curl->get('https://api.warifp.co/v1/name-generator');

        if ($this->curl->error) {
            echo '[-] Error: Get Name - ' . $this->curl->errorCode . ': ' . $this->curl->errorMessage . "\n\n";
        } else {
            return $this->curl->response->data->name;
        }
    }
}

$scammer = new MobileWorksScam;

while (-1) {
    $file = file_get_contents('domain.txt');
    $domains = explode("\r\n", $file);

    foreach ($domains as $key => $domain) {
        $name = $scammer->getName() . $scammer->getName();
        $register = $scammer->register($domain, $name);
        $pregName = preg_split('/(?=[A-Z])/', $name);

        if ($register) {
            if ($register->code === '1') {
                echo '[+] Host: ' . $domain . ' | Name: ' . $pregName[1] . ' ' . $pregName[2] . " | Message: " . $register->message ?? null;
                echo "\n";
            }
        }
    }
}
