<?php

namespace Phpsa\LaravelYourlsPlugin;

use GuzzleHttp\Client;
use Phpsa\LaravelYourlsPlugin\Response;

class LaravelYourlsPlugin
{
    /**
     * Athentication params.
     *
     * @var array
     */
    protected $authParam;

    /**
     * Request Client.
     *
     * @var Client::class
     */
    protected $client;

    /**
     * Available file formats to comunicate with Yourls API.
     *
     * @var string
     */
    private $formats = ['json', 'xml', 'simple'];

    /**
     * Available filters for statistics.
     *
     * @var string
     */
    private $filters = ['top', 'bottom', 'rand', 'last'];

    /**
     * Response format.
     *
     * @var string
     */
    public $format = 'json';
    /**
     * Response filter for stats.
     *
     * @var string
     */
    public $filter = 'top';

    /**
     * Last request.
     *
     * @var \stdClass
     */
    protected $lastResponse;

    /**
     * Construct our instance.
     *
     * @param array $configs
     */
    public function __construct(array $configs)
    {
        $this->format = $configs['format'];
        $this->authParam = $this->getRequestAuthentication($configs);
        $this->client = new Client(['base_uri' => $configs['url']]);
    }

    /**
     * setup our authentication params.
     *
     * @param array $config
     *
     * @return array array for authentication
     */
    protected function getRequestAuthentication(array $config)
    {
        if ($config['signature']) {
            return ['signature' => $config['signature']];
        } else {
            return [
                'username' => $config['username'],
                'password' => $config['password'],
            ];
        }
    }

    /**
     * Get short URL for a link.
     *
     * @param string $url to shorten
     * @param string $title title for url
     * @param string $keyword [optional] for custom short URLs
     * @param string $format [optional] either "json" or "xml"
     * @return string
     */
    public function shorturl(string $url, string $title = null, string $keyword = null, string $format = null)
    {
        $params = [
            'action' => 'shorturl',
            'url' => $url,
            'format' => $this->setFormat($format),
        ];
        if ($title) {
            $params['title'] = $title;
        }
        if ($keyword) {
            $params['keyword'] = $keyword;
        }
        $body = $this->process($params);
        return $body->shorturl;
    }

    /**
     * Get long URL of a shorturl.
     *
     * @param string $shorturl to expand (can be either 'abc' or 'http://site/abc')
     * @param string $format [optional] either "json" or "xml"
     * @return Response
     */
    public function expand(string $shorturl, string $format = null)
    {
        $params = [
            'action' => 'expand',
            'shorturl' => $shorturl,
            'format' => $this->setFormat($format),
        ];

        return $this->process($params);
    }

    /**
     * Get stats about one short URL.
     *
     * @param string $shorturl for which to get stats (can be either 'abc' or 'http://site/abc')
     * @param string $format [optional] either "json" or "xml"
     * @return Response
     */
    public function urlStats(string $shorturl, string $format = null)
    {

        $params = [
            'action' => 'url-stats',
            'shorturl' => $shorturl,
            'format' => $this->setFormat($format)
        ];

        return $this->process($params);
    }

    /**
     * Get stats about your links.
     *
     * @param string $filter [optional] either "top", "bottom" , "rand" or "last"
     * @param int [optional] $limit maximum number of links to return
     * @param string $format [optional] either "json" or "xml"
     * @return Response
     */
    public function stats(string $filter = null, int $limit = null, string $format = null)
    {
        $filter = empty($filter) || !in_array($filter, $this->filters) ? $this->filter : $filter;

        $params = [
            'action' => 'stats',
            'filter' => $filter,
            'format' => $this->setFormat($format)
        ];
        if (! empty($limit)) {
            $params = array_merge($params, ['limit' => $limit]);
        }

        return $this->process($params);
    }

    /**
     * Get database stats.
     *
     * @param string $format [optional] either "json" or "xml"
     * @return Response
     */
    public function dbStats(string $format = null)
    {

        $params = [
            'action' => 'db-stats',
            'format' => $this->setFormat($format)
        ];

        return $this->process($params);
    }

    /**
     * processes our request.
     *
     * @param array $request
     *
     * @throws \Exception
     *
     * @return Response
     */
    protected function process(array $request)
    {
        $format = $request['format'];
        $form_params = array_merge($request, $this->authParam);

        $result = $this->client->request('POST', 'yourls-api.php', ['form_params' => $form_params]);
        if(!$result || '200' != $result->getStatusCode()) {
            throw new \Exception('Failed to process request');
        }

        $body = $result->getBody();
        $this->lastResponse = new Response($body);

        return $this->lastResponse;


    }

    /**
     * Returns the result of the last request in.
     *
     * @return string|\stdClass
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * checks the format is of a correct value else defaults to the default format
     *
     * @param string $format
     *
     * @return string
     */
    protected function setFormat(string $format = NULL){
        return empty($format) || !in_array($format, $this->formats) ? $this->format: $format;
    }
}
