<?php

namespace Tests\TrovitUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Trovit\Bundle\UserBundle\Entity\Repository\RedisUserRepository;
use Trovit\Bundle\UserBundle\Entity\User;
use AppBundle\Factory\RedisUserFactory;

class UserCheckLoginFunctionalTest extends WebTestCase
{
    private $client;
    private $redis;
    private $user;

    protected function setUp()
    {
        $this->client = static::createClient();
        $this->populateData();

    }

    private function populateData()
    {

        $this->redis = $this->client->getContainer()->get('AppBundle\Service\PredisClient');
        $user_factory = new RedisUserFactory($this->redis);
        $this->user = $user_factory->create(array('username' => 'orugrita', 'password' => 'orugritapass'));

    }

    protected function tearDown()
    {
        $this->redis->getClient()->flushdb();
    }


    public function testGetCheckLoginRoute()
    {
        $this->setCheckLoginRequest($this->user->getUsername(), $this->user->getPassword());

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testUserMustExist()
    {
        $this->setCheckLoginRequest('orugrita1', 'asdasdasdas');

        $data = $this->client->getResponse()->getContent();
        $this->assertJsonStringEqualsJsonString(json_encode(array('success' => false, 'message' => "User does not exist." )), $data);

    }

    public function testUserAndPasswordMustMatch()
    {
        $this->setCheckLoginRequest('orugrita', 'asdasdasdas');

        $data = $this->client->getResponse()->getContent();
        $this->assertJsonStringEqualsJsonString(json_encode(array('success' => false, 'message' => "User and Password do not match." )), $data);

    }

    public function testUserAndPasswordMatch()
    {
        $this->setCheckLoginRequest($this->user->getUsername(), $this->user->getPassword());

        $data = $this->client->getResponse()->getContent();
        $this->assertJsonStringEqualsJsonString(json_encode(array('success' => true, 'message' => "User and Password match." )), $data);

    }

    private function setCheckLoginRequest (string $username, string $password)
    {
        $this->client->request('GET',"/check-login?username=$username&pass=$password");
    }

}
