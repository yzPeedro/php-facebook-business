<?php

namespace Meta\InstagramSDK;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Meta\InstagramSDK\Exception\InstagramException;

class InstagramHelper
{
    private const IG_BASE_URI = "https://api.instagram.com";

    private const IG_GRAPH_URI = "https://graph.instagram.com";

    /**
     * @param string|int $app_id
     * @param string|int $app_secret
     * @param string $redirect_uri
     */
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

    /**
     * @param array|string[] $scope
     * @return string
     */
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

    /**
     * @param string $code
     * @return mixed
     * @throws InstagramException
     * @throws GuzzleException
     */
    public function getAccessToken(string $code): mixed
    {
        try {
            $data = [
                'client_id' => $this->getAppId(),
                'client_secret' => $this->getAppSecret(),
                'grant_type' => 'authorization_code',
                'redirect_uri' => $this->getRedirectUri(),
                'code' => $code
            ];

            $client = new Client(['base_uri' => self::IG_BASE_URI]);
            $response = $client->request('GET', '/oauth/access_token?'.http_build_query($data));

            return json_decode($response->getBody());
        } catch (ClientException $exception) {
            throw new InstagramException($exception->getResponse()->getBody(), $exception->getCode());
        }
    }

    /**
     * @param string $token
     * @return mixed
     * @throws GuzzleException
     * @throws InstagramException
     */
    public function getLoginLivedToken(string $token): mixed
    {
        try {
            $data = [
                'client_secret' => $this->getAppSecret(),
                'grant_type' => 'ig_exchange_token',
                'access_token' => $token
            ];

            $client = new Client(['base_uri' => self::IG_GRAPH_URI]);
            $response = $client->request('GET', '/access_token?'.http_build_query($data));

            return json_decode($response->getBody());
        } catch (ClientException $exception) {
            throw new InstagramException($exception->getResponse()->getBody(), $exception->getCode());
        }
    }

    /**
     * @param string $token
     * @return mixed
     * @throws GuzzleException
     * @throws InstagramException
     */
    public function refreshAccessToken(string $token): mixed
    {
        try {
            $data = [
                'grant_type' => 'ig_refresh_token',
                'access_token' => $token
            ];

            $client = new Client(['base_uri' => self::IG_GRAPH_URI]);
            $response = $client->request('GET', '/refresh_access_token?'.http_build_query($data));

            return json_decode($response->getBody());
        } catch (ClientException $exception) {
            throw new InstagramException($exception->getResponse()->getBody(), $exception->getCode());
        }
    }
}