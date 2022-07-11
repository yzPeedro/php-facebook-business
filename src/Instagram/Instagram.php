<?php

namespace Meta\InstagramSDK;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Meta\InstagramSDK\Exception\InstagramException;

class Instagram
{
    private const IG_BASE_URI = "https://api.instagram.com";

    /**
     * @var InstagramHelper
     */
    public InstagramHelper $helper;

    /**
     * @var string
     */
    private string $access_token;

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

    /**
     * @param string $access_token
     * @return $this
     */
    public function setAccessToken(string $access_token): static
    {
        $this->access_token = $access_token;
        return $this;
    }

    /**
     * @param string|int $user_id
     * @param array|string[] $fields
     * @return mixed
     * @throws GuzzleException
     * @throws InstagramException
     */
    public function getUser(string|int $user_id, array $fields = ['account_type', 'id', 'media_count', 'username']): mixed
    {
        $data = [ 'access_token' => $this->getAccessToken(), 'fields' => implode(',', $fields) ];

        try {
            $client = new Client(['base_uri' => self::IG_BASE_URI]);
            $response = $client->request('GET', "/$user_id?".http_build_query($data));

            return json_decode($response->getBody());
        } catch (ClientException $exception) {
            throw new InstagramException($exception->getResponse()->getBody(), $exception->getCode());
        }
    }

    /**
     * @param string $user_id
     * @param array $options
     * @return mixed
     * @throws GuzzleException
     * @throws InstagramException
     */
    public function getMedia(string $user_id, array $options = []): mixed
    {
        $data = [ 'access_token' => $this->getAccessToken() ];

        foreach ($options as $index => $option) {
            if (is_array($option)) {
                $options[$index] = implode(',', $option);
            }
            $data[$index] = $options[$index];
        }

        try {
            $client = new Client(['base_uri' => self::IG_BASE_URI]);
            $response = $client->request('GET', "/$user_id/media?".http_build_query($data));

            return json_decode($response->getBody());
        } catch (ClientException $exception) {
            throw new InstagramException($exception->getResponse()->getBody(), $exception->getCode());
        }
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->access_token;
    }
}