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

    public function testUserMustExist()
    {
        $this->client->request('GET','/check-login?username=nonexisteduser&pass=54FgtWrs68');

        $data = $this->client->getResponse()->getContent();
        $this->assertJsonStringEqualsJsonString(json_encode(array('success' => false, 'message' => "User does not exist." )), $data);

    }

    public function testUserAndPasswordMustMatch()
    {
        $this->client->request('GET','/check-login?username=orugrita&pass=tWrs68');

        $data = $this->client->getResponse()->getContent();
        $this->assertJsonStringEqualsJsonString(json_encode(array('success' => false, 'message' => "User and Password do not match." )), $data);

    }

    public function testUserAndPasswordMatch()
    {
        $this->client->request('GET','/check-login?username=orugrita&pass=1234');

        $data = $this->client->getResponse()->getContent();
        $this->assertJsonStringEqualsJsonString(json_encode(array('success' => true, 'message' => "User and Password match." )), $data);

    }


}
