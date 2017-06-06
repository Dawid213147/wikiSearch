<?php
namespace Wiki\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Controller 
 * @author Dawid
 */
class SearchController extends Controller {

    /**
     * @Route("/search", name="app")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction() {

        $requestData = $this->get('wiki.client_creator')->prepareData();

        $response = $this->render(
            'WikiSearchBundle:Search:search.html.twig', [
            'wikiPages' => $requestData['searchResult'],
            'searchValue' => $requestData['requestData']['searchValue'],
            'decodeUrl' => $requestData['urlDecode'],
        ]);
   
        return $response;
    }

    /**
     * @Route("/my", name="my")
     */
    public function myAction()
    {
        $categoryProvider = $this->get('wiki_category.provider.service');
        $category = $categoryProvider->getCategory(2);
        var_dump($category);exit;
    }
}
