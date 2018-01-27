<?php

namespace AppBundle\Service;

class PredisClient implements RedisClient
{
    private $client;

    public function __construct($host, $port)
    {
        $this->client = new \Predis\Client("tcp://$host:$port");
    }


    public function getClient()
    {
        return $this->client;
    }
}

