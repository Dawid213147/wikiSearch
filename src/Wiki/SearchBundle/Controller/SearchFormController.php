<?php

namespace Wiki\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Wiki\SearchBundle\Repository\Client\ClientRepository;

/**
 * Controller render a serach form
 */
class SearchFormController extends Controller
{

    /**
     * @Route("/")
     * Create a search form
     * @return array
     */
    public function indexAction(Request $request, $url = null)
    {

        if ($url == null) {
            $url = $request->getUri() . 'search';
        }

        $form = $this->createFormBuilder()
            ->add('wikiSearch', SearchType::class, [
                'label' => 'Search: ',])
            ->add('Search', SubmitType::class)

            ->add('category', EntityType::class, array(
                // query choices from this entity
                'class' => 'Wiki\SearchBundle\Entity\Category',
                'choice_label' => 'name',
            ))

            ->getForm();

        $response = $this->render(
            'WikiSearchBundle:SearchForm:index.html.twig', [
            'form' => $form->createView(),
            'url' => $url,
        ]);

        return $response;
    }

}
