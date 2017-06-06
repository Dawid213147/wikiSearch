<?php
/**
 * Created by PhpStorm.
 * User: dlange
 * Date: 06.06.2017
 * Time: 13:58
 */

namespace Wiki\SearchBundle\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Wiki\SearchBundle\Factory\ClientFactory;
use Wiki\SearchBundle\Service\Category\CategoryServiceProvider;
use Wiki\SearchBundle\Service\Client\ClientHandler;
use Wiki\SearchBundle\Service\HttpRequest\HttpRequestSearch;

class RequestStackService
{

    private $requestStack;
    private $categoryServiceProvider;
    private $clientFactory;
    private $wikiSearch;

    public function __construct(
        RequestStack $requestStack,
        CategoryServiceProvider $categoryServiceProvider,
        ClientFactory $clientFactory,
        HttpRequestSearch $wikiSearch,
        $httpWebService,
        ClientHandler $clientHandler
    )
    {
        $this->requestStack = $requestStack;
        $this->categoryServiceProvider = $categoryServiceProvider;
        $this->clientFactory = $clientFactory;
        $this->wikiSearch = $wikiSearch;
        $this->httpWebService = $httpWebService;
        $this->clientHandler = $clientHandler;
    }

    public function prepareData()
    {
        $data = $this->prepareRequestData();

        $this->saveData($data);

        return $data;

    }

    public function prepareRequestData()
    {
        $request = $this->requestStack->getCurrentRequest();
        $wikiPages = $this->wikiSearch;

        $requestData = [
            'searchValue' => $request->query->get('form')['wikiSearch'],
            'searchCategory' => $request->query->get('form')['category'],
            'searchLimit' => $request->query->get('limit') ? $request->query->get('limit') : 10,
            'webServis' => $this->httpWebService
        ];

        $searchResult = $wikiPages->getHttpRequestResult($requestData['searchValue'],
            $requestData['webServis'],
            $requestData['searchLimit']);
        $requestUri = strtok($request->getRequestUri(), '&');
        $urlDecode = urldecode($requestUri);

        $result = [
           'requestData' => $requestData,
            'searchResult' => $searchResult,
            'urlDecode' => $urlDecode
        ];

        return $result;
    }

    public function saveData($request)
    {

        $categoryProvider = $this->categoryServiceProvider;
        $category = $categoryProvider->getCategory($request['requestData']['searchCategory']);

        $client = $this->clientFactory->createClient();
        $client->setSearch($request['requestData']['searchValue']);
        $client->setResultCount($request['requestData']['searchLimit']);
        $client->setCategoryId($request['requestData']['searchCategory']);
        $client->setCategory($category);


        $clientHandler = $this->clientHandler;
        $clientHandler->saveClient($client);
    }

}