<?php

use PHPUnit\Framework\TestCase;
use Meta\FacebookSDK\Facebook;

class FacebookHelperTest extends TestCase
{
    public function testJavascriptHelper()
    {
        $facebook = new Facebook();
        $javascript = $facebook->helper->javascriptSDK('pt_BR', false);

        $this->assertIsString($javascript);
    }

    public function testJavascriptLogin()
    {
        $facebook = new Facebook();
        $javascript = $facebook->helper->javascriptLogin();

        $this->assertIsString($javascript);
    }

    public function testJavascriptLogout()
    {
        $facebook = new Facebook();
        $javascript = $facebook->helper->javascriptLogout();

        $this->assertIsString($javascript);
    }
}