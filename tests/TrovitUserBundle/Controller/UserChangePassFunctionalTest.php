<?php

namespace Tests\TrovitUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Trovit\Bundle\UserBundle\Entity\Repository\RedisUserRepository;
use Trovit\Bundle\UserBundle\Entity\User;
use AppBundle\Factory\RedisUserFactory;

class UserChangePassFunctionalTest extends WebTestCase
{
    private $client;
    private $redis;
    private $user;
    private $user_not_updated;
    private $user_repository;

    protected function setUp()
    {
        $this->client = static::createClient();
        $this->populateData();

    }

    private function populateData()
    {

        $this->redis = $this->client->getContainer()->get('AppBundle\Service\PredisClient');
        $this->user_repository = new RedisUserRepository($this->redis);
        $user_factory = new RedisUserFactory($this->redis);

        $this->user = $user_factory->create(array('username' => 'orugrita', 'password' => 'orugritapass'));
        $this->user_not_updated = $user_factory->create(array('username' => 'homer', 'password' => 'homerpass'));

    }

    protected function tearDown()
    {
        $this->redis->getClient()->flushdb();
    }


    public function testGetCheckLoginRoute()
    {
        $this->setChangePassRequest($this->user->getUsername(), $this->user->getPassword(), "newpass");

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testUserAndPasswordMustMatch()
    {
        $this->setChangePassRequest('orugrita', 'pass', "newpass");

        $data = $this->client->getResponse()->getContent();

        $this->assertJsonStringEqualsJsonString(json_encode(array('success' => false, 'message' => "User and Password do not match." )), $data);

    }

    public function testChangePassword()
    {
        $this->setChangePassRequest($this->user->getUsername(), $this->user->getPassword(), "newpass");

        $data = $this->client->getResponse()->getContent();

        $this->assertJsonStringEqualsJsonString(json_encode(array('success' => true, 'message' => "User updated password successfuly." )), $data);

        $user_updated = $this->user_repository->loadUserByUsername($this->user->getUsername());

        $this->assertEquals($user_updated->getPassword(), "newpass");
    }

    public function testOnlyCurrentUserChangePassword()
    {
        $this->setChangePassRequest($this->user->getUsername(), $this->user->getPassword(), "newpass");


        $user_updated = $this->user_repository->loadUserByUsername($this->user->getUsername());
        $user_not_updated = $this->user_repository->loadUserByUsername($this->user_not_updated->getUsername());

        $this->assertEquals($user_updated->getPassword(), "newpass");
        $this->assertEquals($user_not_updated->getPassword(), $user_not_updated->getPassword());
    }


    private function setChangePassRequest (string $username, string $password, string $new_pass)
    {
        $this->client->request('GET',"/change-pass?username=$username&pass=$password&newpass=$new_pass");
    }

}
