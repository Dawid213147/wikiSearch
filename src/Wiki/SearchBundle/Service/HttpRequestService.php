<?php

namespace Wiki\SearchBundle\Service;

use GuzzleHttp\Client;

/**
 * Description of HttpRequestService
 *
 * @author Dawid
 */
class HttpRequestService {

    /**
     * Value of a http client
     * @var object
     */
    protected $client;

    /**
     * Value of a request
     * @var string 
     */
    protected $request;

    /**
     * Constructor
     */
    public function __construct() {

        $this->client = new Client();
    }
    
     /**
     * Get result as simple xml object
     * @return object \SimpleXMLElement
     */
     protected function getRequestBodyAsObject() {

        $request = $this->request;

        $body = $request->getBody();
        $xmlObject = new \SimpleXMLElement($body);

        return $xmlObject;
    }
}
