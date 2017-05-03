<?php

namespace Wiki\SearchBundle\Helper\HttpRequestSearch;

use GuzzleHttp\Client;

/**
 * Class creata a request to webservice
 */
class HttpRequestSearch {

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
     * @return array
     */
    public function getHttpRequestResult($search, $webService, $limit) {

        $client = $this->client;

        $request = $client->request('GET', $webService, [
            'verify' => false,
            'query' => [
                'action' => 'query',
                'list' => 'search',
                'srwhat' => 'text',
                'srsearch' => $search,
                'srlimit' => $limit,
                'format' => 'xml'
            ]
        ]);
        $this->request = $request;

        $result = $this->prepareData();

        return $result;
    }

    /**
     * Return array result of search
     * @return array|NULL
     */
    private function prepareData() {

        $pages = $this->getRequestBodyAsObject();

        $wikiPages = json_decode(json_encode($pages->query->search), TRUE);
        
        if ($wikiPages != NULL) {
            $result = call_user_func_array('array_merge', $wikiPages);

            $singleResult = [];

            foreach ($result as $row) {
                $singleResult[] = call_user_func_array('array_merge', $row);
            }

            return $singleResult;
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
