<?php

namespace Sloth\SyrveApi;

class Syrve
{
    private $method;

    public function __construct($credentials)
    {
        HttpClient::init($credentials);
    }

    public function __destruct()
    {
        HttpClient::logout();
    }

    public function __get($name) {
        return $this->getMethod($name);
    }

    public function getMethod($name)
    {
        $this->method = new \Sloth\SyrveApi\Method($this);
        return $this->method->getMethod($name);
    }
}