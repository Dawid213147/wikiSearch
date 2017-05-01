<?php

namespace Wiki\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Controller render a serach form
 */
class SearchFormController extends Controller {

    /**
     * 
     * @return type
     */
    public function indexAction() {

        $request = $this->container->get('request');
        $routeName = $request->get('_route');
        $currentUrl = $this->get('router')
                ->generate($routeName, array(), true);
        $url = $currentUrl . 'search';
        $form = $this->createFormBuilder()
                ->setAction($url)
                ->add('wikiSearch', 'search', [
                    'label' => 'Search: ',
                ])
                ->add('Search', 'submit')
                ->getForm();

        $response = $this->render(
            'WikiSearchBundle:SearchForm:index.html.twig', [
            'form' => $form->createView(),
            'url' => $url
        ]);

        return $response;
    }

}
