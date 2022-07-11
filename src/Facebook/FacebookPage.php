<?php

namespace Meta\FacebookSDK;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Meta\FacebookSDK\Exception\FacebookException;
use Meta\InstagramSDK\InstagramBusinessAccount;
use stdClass;

class FacebookPage
{
    private const FB_BASE_URI = "https://graph.facebook.com/";

    private string $access_token;

    private string $category;

    private array $category_list = [];

    private string $name;

    private string|int $id;

    private array $tasks;

    public function __construct(StdClass $page)
    {
        $this->access_token = $page->access_token;
        $this->category = $page->category;
        $this->category_list = $page->category_list;
        $this->name = $page->name;
        $this->id = $page->id;
        $this->tasks = $page->tasks;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->access_token;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return array
     */
    public function getCategoryList(): array
    {
        return $this->category_list;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int|string
     */
    public function getId(): int|string
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }

    /**
     * @param array $fields
     * @return mixed
     * @throws FacebookException
     * @throws GuzzleException
     */
    public function me(array $fields = []): mixed
    {
        try {
            foreach ($fields as $index => $field) {
                if (is_array($field)) {
                    $fields[$index] = implode(',', $field);
                }
            }
            $fields[] = 'name';

            $data = [
                'access_token' => $this->access_token,
                'fields' => implode(',', $fields)
            ];

            $client = new Client(['base_uri' => self::FB_BASE_URI]);
            $response = $client->request('GET', "/$this->id?".http_build_query($data), [
               'Accept' => 'application/json'
            ]);

            return json_decode($response->getBody());
        } catch (ClientException $exception) {
            throw new FacebookException($exception->getResponse()->getBody(), $exception->getCode());
        }
    }

    /**
     * @return InstagramBusinessAccount
     * @throws FacebookException
     * @throws GuzzleException
     * @throws \Meta\InstagramSDK\Exception\InstagramException
     */
    public function getInstagramBusinessAccount(): InstagramBusinessAccount
    {
        try {
            $data = [
                'access_token' => $this->access_token,
                'fields' => 'instagram_business_account'
            ];

            $client = new Client(['base_uri' => self::FB_BASE_URI]);
            $response = $client->request('GET', "/$this->id?".http_build_query($data), [
                'Accept' => 'application/json'
            ]);

            $response = json_decode($response->getBody());
            return new InstagramBusinessAccount(
                $response->instagram_business_account->id,
                $this->getAccessToken());

        } catch (ClientException $exception) {
            throw new FacebookException($exception->getResponse()->getBody(), $exception->getCode());
        }
    }
}