<?php
/**
 * Created by PhpStorm.
 * User: toarga
 * Date: 2020. 09. 25.
 * Time: 16:15
 */

namespace MedevSlim\Core\Integration;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\StreamInterface;

abstract class RestClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * RestClient constructor.
     * @param string $schema
     * @param string $host
     * @param string $port
     * @param string $baseUri
     */
    public function __construct($schema, $host, $port, $baseUri)
    {
        $this->client = new Client([
            'base_uri' => $schema . "://" . $host . ":" . $port . $baseUri,
        ]);
    }


    /**
     * @param string $path
     * @param string[] $headers
     * @param string[] $params
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function doGet($path, $headers, $params = [])
    {
        return $this->doRequest("GET", $path, $headers, $params);
    }

    /**
     * @param string $path
     * @param string[] headers
     * @param string|string[]|StreamInterface $body
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function doPost($path, $headers, $body = "")
    {
        return $this->doRequest("POST", $path, $headers, [], $body);
    }

    /**
     * @param $path
     * @param $headers
     * @param string|string[]|StreamInterface $body
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function doDelete($path, $headers, $body = "")
    {
        return $this->doRequest("DELETE", $path, $headers, [], $body);
    }

    /**
     * @param string $path
     * @param string[] $headers
     * @param string|string[]|StreamInterface $body
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function doPut($path, $headers, $body = "")
    {
        return $this->doRequest("PUT", $path, $headers, [], $body);
    }

    /**
     * @param string $path
     * @param string[] $headers
     * @param string[] $params
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function doOptions($path, $headers, $params = [])
    {
        return $this->doRequest("OPTIONS", $path, $headers, $params);
    }

    /**
     * @param string $path
     * @param string[] $headers
     * @param string[] $params
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function doHead($path, $headers, $params = [])
    {
        return $this->doRequest("HEAD", $path, $headers, $params);
    }

    /**
     * @param string $method
     * @param string $path
     * @param string[] $headers
     * @param string[] $params
     * @param string|string[]|StreamInterface $body
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function doRequest($method, $path, $headers, $params, $body = "")
    {
        $options = [
            RequestOptions::HEADERS => $headers,
        ];

        if (!empty($params)) $options[RequestOptions::QUERY] = $params;
        if ($body != "") $options[RequestOptions::BODY] = $body;

        return $this->client->request($method, $path, $options);
    }
}