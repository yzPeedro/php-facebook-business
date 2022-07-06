<?php

namespace Meta\FacebookSDK;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Meta\FacebookSDK\Exception\FacebookException;

class FacebookUser
{
    const FB_BASE_URI = "https://graph.facebook.com";

    public function __construct(private string $access_token){}

    /**
     * @param string $access_token
     * @return FacebookUser
     */
    public function setAccessToken(string $access_token): FacebookUser
    {
        $this->access_token = $access_token;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->access_token;
    }

    /**
     * @throws FacebookException
     */
    public function me(array $fields = [])
    {
        try {
            if(! empty($fields)) {
                foreach ($fields as $index => $field) {
                    if (is_array($field)) {
                        $fields[$index] = implode(',', $field);
                    }
                }
            }

            $data = [
                'access_token' => $this->getAccessToken(),
                'fields' => implode(',', $fields)
            ];
            $client = new Client(['base_uri' => self::FB_BASE_URI]);

            $response = $client->request('GET', '/me?'.http_build_query($data), [
                'Accept' => 'application/json'
            ]);

            return json_decode($response->getBody());
        } catch (GuzzleException $exception) {
            throw new FacebookException($exception->getMessage());
        }
    }
}