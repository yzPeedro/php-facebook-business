<?php

namespace Meta\FacebookSDK;

class Facebook
{
    public FacebookHelper $helper;

    public function __construct(string $app_id = '')
    {
        $this->setHelper(new FacebookHelper($app_id));
    }

    /**
     * @param FacebookHelper $helper
     */
    private function setHelper(FacebookHelper $helper): void
    {
        $this->helper = $helper;
    }

    public function user(string $access_token): FacebookUser
    {
        return new FacebookUser($access_token);
    }
}