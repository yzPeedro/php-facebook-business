<?php

namespace Meta\InstagramSDK;

class InstagramHelper
{
    private const IG_BASE_URI = "https://api.instagram.com";

    public function __construct(private string|int $app_id, private string|int $app_secret, private string $redirect_uri){}

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

    public function getLink(array $scope = ['user_profile', 'user_media']): string
    {
        $params = [
            'client_id' => $this->getAppId(),
            'redirect_uri' => $this->getRedirectUri(),
            'scope' => implode(',', $scope),
            'response_type' => 'code',
        ];

        return self::IG_BASE_URI."/oauth/authorize/?" . http_build_query($params);
    }
}