<?php

namespace Meta\FacebookSDK;

use PHPUnit\Framework\TestCase;

class FacebookTest extends TestCase
{
    public function testUserMethodMustReturnUserInstance()
    {
        $facebook = new Facebook('...');
        $user = $facebook->user('...');

        $this->assertInstanceOf(FacebookUser::class, $user);
    }
}
