<?php

namespace Src\Infrastructure\Api\BlogServices;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Src\Infrastructure\Api\BlogApiServiceInterface;

class HerokuBlogApiService implements BlogApiServiceInterface
{
    /**
     * @return array|mixed
     */
    public function articles()
    {
        $client = new Client();

        try {

            $response = $client->get('https://sq1-api-test.herokuapp.com/posts');

            return json_decode($response->getBody(), true)['data'];

        } catch (ClientException $clientException) {

            $response = $clientException->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();

            \Log::error($responseBodyAsString);

        } catch (GuzzleException $guzzleException) {

            \Log::error($guzzleException->getMessage());
        }

        return [];
    }
}
