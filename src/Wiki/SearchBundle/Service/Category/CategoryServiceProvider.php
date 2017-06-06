<?php

namespace Wiki\SearchBundle\Service\Category;

use Wiki\SearchBundle\Entity\Category;
use Wiki\SearchBundle\Repository\Category\CategoryRepository;

/**
 * Class ClientServiceProvider
 * @package Wiki\SearchBundle\Service\Client
 */
class CategoryServiceProvider
{

    /**
     * @var ClientRepository
     */
    private $categoryRepository;

    /**
     * CategoryServiceProvider constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param $id
     * @return array
     */
    public function getCategory($id)
    {
        return $this->categoryRepository->findOneBy(
            [
                'id' => $id,
            ]
        );
    }

}