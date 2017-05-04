<?php

namespace Wiki\SearchBundle\Helper\HttpRequestImage;

use GuzzleHttp\Client;

/**
 * Description of HttpRequestImage
 *
 * @author Dawid
 */
class HttpRequestImage {

    /**
     * Value of a http client
     * @var object
     */
    private $client;

    /**
     * Value of a request
     * @var string 
     */
    private $request;

    /**
     * Constructor
     */
    public function __construct() {

        $this->client = new Client();
    }

    /**
     * Return result of request to web serwise
     * @param string $search
     * @param string $webService
     * @return boolean|string
     */
    public function getHttpRequestImage($search, $webService) {

        $client = $this->client;

        try {
            $request = $client->request('GET', $webService, [
                'verify' => false,
                'query' => [
                    'action' => 'query',
                    'prop' => 'pageimages',
                    'titles' => $search,
                    'pithumbsize' => 100,
                    'format' => 'xml'
                ]
            ]);
            $this->request = $request;
            $result = $this->prepareData();
            return $result;
        } catch (\Exception $e) {
            return FALSE;
        }
    }

    /**
     * Return array result of search image
     * @return string|NULL
     */
    private function prepareData() {

        $pagesImage = $this->getRequestBodyAsObject();

        $wikiImage = json_decode(json_encode($pagesImage->query->pages->page->thumbnail['source']), TRUE);

        if ($wikiImage != NULL) {

            return $wikiImage[0];
        }

        return NULL;
    }

    /**
     * 
     * @return object \SimpleXMLElement
     */
    private function getRequestBodyAsObject() {

        $request = $this->request;

        $body = $request->getBody();
        $xmlObject = new \SimpleXMLElement($body);

        return $xmlObject;
    }

}
