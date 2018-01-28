<?php

namespace AppBundle\Service;

class PredisClient implements RedisClient
{
    private $client;

    public function __construct($host, $port, $num_database)
    {
        $this->client = new \Predis\Client("tcp://$host:$port?database=$num_database");
    }


    public function getClient()
    {
        return $this->client;
    }

}

