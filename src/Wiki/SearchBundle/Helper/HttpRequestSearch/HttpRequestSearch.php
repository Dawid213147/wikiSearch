<?php

namespace Wiki\SearchBundle\Helper\HttpRequestSearch;

use GuzzleHttp\Client;
use Wiki\SearchBundle\Helper\HttpRequestImage\HttpRequestImage;

/**
 * Class creata a request to webservice
 * @author Dawid
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
     * Value with request to get image
     * @var object 
     */
    private $image;
    
    /**
     * Value of search word
     * @var strng 
     */
    private $searchWord;
    
    /**
     * Value of web service 
     * @var string 
     */
    private $webService;
    
    /**
     * Constructor
     */
    public function __construct() {

        $this->client = new Client();
        $this->image = new HttpRequestImage();
    }

    /**
     * Return result of request to web serwise
     * @param string $search
     * @return array
     */
    public function getHttpRequestResult($search, $webService, $limit) {

        $this->searchWord = $search;
        $this->webService = $webService;
        $client = $this->client;
        try {
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
        } catch (\Exception $e) {
            return FALSE;
        }
    }

    /**
     * Return array result of search
     * @return array|NULL
     */
    private function prepareData() {

        $pages = $this->getRequestBodyAsObject();
        
        $image = $this->image;

        if ($pages != NULL) {

            $wikiPages = json_decode(json_encode($pages->query->search), TRUE);

                $cleanArray = call_user_func_array('array_merge', $wikiPages);

                $singleResult = [];

                foreach ($cleanArray as $key => $row) {
                    $singleResult[] = call_user_func_array('array_merge', $row);
                    $singleResult[$key]['image'] = '$image->getHttpRequestImage($search, $webService)';
                }

                return $singleResult;
        }
        return NULL;
    }

    /**
     * Get xml with search results
     * @return object \SimpleXMLElement
     */
    private function getRequestBodyAsObject() {

        $request = $this->request;

        $body = $request->getBody();
        $xmlObject = new \SimpleXMLElement($body);

        return $xmlObject;
    }

}
