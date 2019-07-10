<?php

namespace Phpsa\LaravelYourlsPlugin;

use GuzzleHttp\Client;

//https://onein.ml/

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
    private $__formats = ['json', 'xml', 'simple'];

    /**
     * Available filters for statistics.
     *
     * @var string
     */
    private $__filters = ['top', 'bottom', 'rand', 'last'];

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
     * @var stdClass
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
     * @return void
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
     * @return array|string
     */
    public function shorturl(string $url, string $title = null, string $keyword = null, string $format = null)
    {
        if (empty($format)) {
            $format = $this->format;
        }
        $params = [
            'action' => 'shorturl',
            'url' => $url,
            'format' => $format,
        ];
        if ($title) {
            $params['title'] = $title;
        }
        if ($keyword) {
            $params['keyword'] = $keyword;
        }

        $body = $this->process($params, $format);

        if ($format === 'simple' && $body) {
            return $body;
        }
        if ($body && isset($body->shorturl)) {
            return $body->shorturl;
        }

        if ($body && isset($body->message)) {
            throw new \Exception($body->message);
        }
    }

    /**
     * Get long URL of a shorturl.
     *
     * @param string $shorturl to expand (can be either 'abc' or 'http://site/abc')
     * @param string $format [optional] either "json" or "xml"
     * @return array|string
     */
    public function expand(string $shorturl, string $format = null)
    {
        if (empty($format)) {
            $format = $this->format;
        }
        $params = [
            'action' => 'expand',
            'shorturl' => $shorturl,
            'format' => $format,
        ];

        return $this->process($params, $format);
    }

    /**
     * Get stats about one short URL.
     *
     * @param string $shorturl for which to get stats (can be either 'abc' or 'http://site/abc')
     * @param string $format [optional] either "json" or "xml"
     * @return array|string
     */
    public function urlStats(string $shorturl, string $format = null)
    {
        if (empty($format)) {
            $format = $this->format;
        }
        $params = [
            'action' => 'url-stats',
            'shorturl' => $shorturl,
            'format' => $format,
        ];

        return $this->process($params, $format);
    }

    /**
     * Get stats about your links.
     *
     * @param string $filter [optional] either "top", "bottom" , "rand" or "last"
     * @param int [optional] $limit maximum number of links to return
     * @param string $format [optional] either "json" or "xml"
     * @return array|string
     */
    public function stats(string $filter = null, int $limit = null, string $format = null)
    {
        if (empty($format)) {
            $format = $this->format;
        }
        if (empty($filter)) {
            $filter = $this->filter;
        }
        $params = [
            'action' => 'stats',
            'filter' => $filter,
            'format' => $format,
        ];
        if (! empty($limit)) {
            $params = array_merge($params, ['limit' => $limit]);
        }

        return $this->process($params, $format);
    }

    /**
     * Get database stats.
     *
     * @param string $format [optional] either "json" or "xml"
     * @return array|string
     */
    public function dbStats(string $format = null)
    {
        if (empty($format)) {
            $format = $this->format;
        }
        $params = [
            'action' => 'db-stats',
            'format' => $format,
        ];

        return $this->process($params, $format);
    }

    /**
     * processes our request.
     *
     * @param array $request
     *
     * @return mixed
     */
    protected function process(array $request)
    {
        $format = $request['format'];
        $form_params = array_merge($request, $this->authParam);

        $result = $this->client->request('POST', 'yourls-api.php', ['form_params' => $form_params]);

        if ('200' == $result->getStatusCode()) {
            $body = $result->getBody();
            switch ($format) {
                case 'xml':
                    libxml_use_internal_errors(true);
                    $res = simplexml_load_string((string) $body);
                    if ($res) {
                        $res = json_decode(json_encode($res));
                    }
                    break;
                case 'json':
                    $res = json_decode((string) $body);
                    break;
                default:
                    $res = (string) $body;
                break;
            }

            $this->lastResponse = $res;

            if (! $res) {
                throw new \Exception('Failed to parse result');
            }

            return $res;
        }
        throw new \Exception('Failed to process request');
    }

    /**
     * Returns the result of the last request in.
     *
     * @return string|object
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }
}
