<?php

namespace Meta\InstagramSDK;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Meta\InstagramSDK\Exception\InstagramException;
use stdClass;

class InstagramBusinessAccount
{
    private const FB_BASE_URI = "https://graph.facebook.com";

    /**
     * @var string
     */
    private string $username;

    /**
     * @var string
     */
    private string $biography;

    /**
     * @var string
     */
    private string $followers_count;

    /**
     * @var string
     */
    private string $follows_count;

    /**
     * @var string
     */
    private string $ig_id;

    /**
     * @var string
     */
    private string $media_count;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $profile_picture_url;

    /**
     * @var stdClass
     */
    private StdClass $media;

    /**
     * @param string|int $id
     * @param string $page_access_token
     */
    public function __construct(private string|int $id, private string $page_access_token)
    {
        try {
            $data = [
                'access_token' => $this->getPageAccessToken(),
                'fields' => [
                    'username',
                    'biography',
                    'followers_count',
                    'follows_count',
                    'ig_id',
                    'media_count',
                    'name',
                    'profile_picture_url',
                    'media',
                    'id'
                ]
            ];

            $data['fields'] = implode(',', $data['fields']);

            $client = new Client(['base_uri' => self::FB_BASE_URI]);
            $response = $client->request('GET', "/$id?".http_build_query($data), [
                'Accept' => 'application/json'
            ]);

            $instagramBusinessAccount = json_decode($response->getBody());

            $this->username = $instagramBusinessAccount->username;
            $this->biography = $instagramBusinessAccount->biography;
            $this->followers_count = $instagramBusinessAccount->followers_count;
            $this->follows_count = $instagramBusinessAccount->follows_count;
            $this->ig_id = $instagramBusinessAccount->ig_id;
            $this->media_count = $instagramBusinessAccount->media_count;
            $this->name = $instagramBusinessAccount->name;
            $this->profile_picture_url = $instagramBusinessAccount->profile_picture_url;
            $this->media = $instagramBusinessAccount->media;

        } catch (GuzzleException $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getBiography(): string
    {
        return $this->biography;
    }

    /**
     * @return string
     */
    public function getFollowersCount(): string
    {
        return $this->followers_count;
    }

    /**
     * @return string
     */
    public function getFollowsCount(): string
    {
        return $this->follows_count;
    }

    /**
     * @return string
     */
    public function getIgId(): string
    {
        return $this->ig_id;
    }

    /**
     * @return string
     */
    public function getMediaCount(): string
    {
        return $this->media_count;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getProfilePictureUrl(): string
    {
        return $this->profile_picture_url;
    }

    /**
     * @return StdClass
     */
    public function getMedia(): StdClass
    {
        return $this->media;
    }

    /**
     * @return string
     */
    public function getPageAccessToken(): string
    {
        return $this->page_access_token;
    }

    /**
     * @return int|string
     */
    public function getId(): int|string
    {
        return $this->id;
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws InstagramException
     */
    public function getInsights(array $parameters = []): mixed
    {
        try {
            $data = ['access_token' => $this->getPageAccessToken() ];

            if (empty($parameters)) {
                $data['period'] = 'day';
                $data['metric'] = 'impressions';
            }

            $client = new Client(['base_uri' => self::FB_BASE_URI]);
            $response = $client->request('GET', "/$this->id/insights?".http_build_query($data));

            return json_decode($response->getBody());
        } catch (GuzzleException $exception) {
            throw new InstagramException($exception->getMessage(), $exception->getCode());
        }
    }
}