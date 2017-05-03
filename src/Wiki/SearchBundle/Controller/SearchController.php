<?php

namespace Wiki\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Wiki\SearchBundle\Helper\HttpRequestSearch\HttpRequestSearch;
use Wiki\SearchBundle\Helper\HttpRequestImage\HttpRequestImage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
        $wikiImage = new HttpRequestImage();
        $searchValue = $request->query->get('form')['wikiSearch'];
        $searchLimit = $request->query->get('limit') ? $request->query->get('limit') : 10;
        $web_serwise = $this->container->getParameter('http_web_service');
        $searchResult = $wikiPages->getHttpRequestResult($searchValue, $web_serwise, $searchLimit);
//        die(var_dump($searchResult));
        if ($searchResult == FALSE && $searchResult != NULL) {
            $url = $request->headers->get('referer') . 'error';
            $response = new RedirectResponse($url);
            $response->send();
        }
        if ($searchResult == NULL) {
            $url = $request->headers->get('referer') . 'nullError';
            $response = new RedirectResponse($url);
            $response->send();
        }
        $searchImage = $wikiImage->getHttpRequestImage($searchValue, $web_serwise);
        $url = strtok($request->getRequestUri(),'&');
        $urlDecode = urldecode($url);
        $response = $this->render(
            'WikiSearchBundle:Search:search.html.twig', [
            'wikiPages' => $searchResult,
            'searchValue' => $searchValue,
            'decodeUrl' => $urlDecode,
            'image' => $searchImage,
        ]);
   
        return $response;
    }
}
