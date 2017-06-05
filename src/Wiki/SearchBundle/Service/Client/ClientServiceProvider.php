<?php
namespace Wiki\SearchBundle\Service\Client;

use Wiki\SearchBundle\Repository\Client\ClientRepository;

/**
 * Class ClientServiceProvider
 * @package Wiki\SearchBundle\Service\Client
 */
class ClientServiceProvider
{

    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * ClientServiceProvider constructor.
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @return array
     */
    public function getClients()
    {
        return $this->clientRepository->findAll();
    }

}