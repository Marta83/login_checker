<?php

namespace Tests\TrovitUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserFunctionalTest extends WebTestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = static::createClient();
    }

    public function testGetCheckLoginRoute()
    {
        $this->client->request('GET','/check-login?username=orugrita&pass=54FgtWrs67');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

}
