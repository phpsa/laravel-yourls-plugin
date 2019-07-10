<?php

namespace Phpsa\LaravelYourlsPlugin;

class Response
{

    /**
     * status of the server response - fail is not nessisary a fail in this case.
     *
     * @var string
     */
    public $status;

    /**
     * status code of the server response.
     *
     * @var int
     */
    public $statusCode;

    /**
     * message from the response.
     *
     * @var string
     * @author Craig Smith <craig.smith@customd.com>
     */
    public $message;


    public function __construct($body, $format)
    {
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
        $this->parseResponseBody($res);
    }

    protected function parseResponseBody($body)
    {
        if(empty($body)) {
            throw new \Exception('No response recieved');
        }

        if (\is_string($body)) {
            $this->status = 'success';
            $this->statusCode = '200';
            $this->shorturl = $url;

            return;
        }

        foreach ((array) $body as $key => $value) {
            $this->{$key} = $value;
        }

    }

}
