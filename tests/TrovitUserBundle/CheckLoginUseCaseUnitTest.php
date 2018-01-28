<?php

namespace Tests\TrovitUserBundle;

use PHPUnit\Framework\TestCase;
use AppBundle\Service\PredisClient;
use Trovit\Bundle\UserBundle\Entity\User;
use Trovit\Bundle\UserBundle\Utils\CheckLoginResponse;

class CheckLoginUseCaseUnitTest extends TestCase
{

    public function testUserDoesNotExist()
    {
        $user = null;
        $expected = array('success' => false,
                     'message' => "User does not exist.");

        $check_login_response = new CheckLoginResponse();
        $response = $check_login_response->getResponse($user, "fakepass");

        $this->assertJsonStringEqualsJsonString(json_encode($expected), json_encode($response));
    }

    public function testUserPassDoNotMatch()
    {
        $user = new User("user", "pass");
        $expected = array('success' => false,
                          'message' => "User and Password do not match.");

        $check_login_response = new CheckLoginResponse();
        $response = $check_login_response->getResponse($user, "fakepass");

        $this->assertJsonStringEqualsJsonString(json_encode($expected), json_encode($response));
    }


    public function testUserPassMatch()
    {
        $user = new User("user", "pass");
        $expected = array('success' => true,
                          'message' => "User and Password match.");

        $check_login_response = new CheckLoginResponse();
        $response = $check_login_response->getResponse($user, "pass");

        $this->assertJsonStringEqualsJsonString(json_encode($expected), json_encode($response));
    }


}


