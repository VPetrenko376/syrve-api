<?php

namespace Sloth\SyrveApi;

class Method
{
    private $client;

    private $method;

    private static $classMap = [
        'employees' => Api\Employees::class,
        'entities' => Api\Entities::class,
    ];

    public function __construct($client)
    {
        $this->client = $client;
        $this->method = [];
    }

    public function __get($name)
    {
        return $this->getMethod($name);
    }

    public function getApiClass($name)
    {
        return array_key_exists($name, self::$classMap) ? self::$classMap[$name] : null;
    }

    public function getMethod($name)
    {
        $apiClass = $this->getApiClass($name);
        if (null !== $apiClass) {
            if (!array_key_exists($name, $this->method)) {
                $this->method[$name] = new $apiClass($this->client);
            }

            return $this->method[$name];
        }

        trigger_error('Undefined property: ' . static::class . '::$' . $name);

        return null;
    }
}