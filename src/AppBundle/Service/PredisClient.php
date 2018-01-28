<?php

namespace AppBundle\Service;

class PredisClient implements RedisClient
{
    private $client;

    public function __construct(string $host, int $port, int $num_database)
    {
        $this->client = new \Predis\Client("tcp://$host:$port?database=$num_database");
    }


    public function getClient(): \Predis\Client
    {
        return $this->client;
    }

}

