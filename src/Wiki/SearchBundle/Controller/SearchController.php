<?php

namespace Wiki\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Wiki\SearchBundle\Helper\HttpRequestSearch\HttpRequestSearch;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller 
 * @author Dawid
 */
class SearchController extends Controller {

    /**
     * @Route("/search", name="app")
     * @return string
     */
    public function searchAction(Request $request) {
        $wikiPages = new HttpRequestSearch();
        $searchValue = $request->query->get('form')['wikiSearch'];
        $searchLimit = $request->query->get('limit') ? $request->query->get('limit') : 10;
        $web_serwise = $this->container->getParameter('http_web_service');
        $searchResult = $wikiPages->getHttpRequestResult($searchValue, $web_serwise, $searchLimit);
        
        $requestUri = strtok($request->getRequestUri(),'&');
        $urlDecode = urldecode($requestUri);
        $response = $this->render(
            'WikiSearchBundle:Search:search.html.twig', [
            'wikiPages' => $searchResult,
            'searchValue' => $searchValue,
            'decodeUrl' => $urlDecode,
        ]);
   
        return $response;
    }
}
