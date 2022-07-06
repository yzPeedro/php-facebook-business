<?php

namespace Meta\InstagramSDK;

use GuzzleHttp\Client;

class Instagram
{
    public InstagramHelper $helper;

    public function __construct(
        private string|int $app_id,
        private string|int $app_secret,
        private string $redirect_uri)
    {
        $this->helper = new InstagramHelper($app_id, $app_secret, $redirect_uri);
    }

    /**
     * @return int|string
     */
    public function getAppId(): int|string
    {
        return $this->app_id;
    }

    /**
     * @return int|string
     */
    public function getAppSecret(): int|string
    {
        return $this->app_secret;
    }

    /**
     * @return string
     */
    public function getRedirectUri(): string
    {
        return $this->redirect_uri;
    }
}