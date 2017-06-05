<?php
namespace Wiki\SearchBundle\Repository\Client;

use Doctrine\ORM\EntityRepository;
use Wiki\SearchBundle\Entity\Client;

/**
 * Class ClientRepository
 * @package Wiki\SearchBundle\Repository\Client
 */
class ClientRepository extends EntityRepository implements ClientRepositoryInterface
{

    public function save(Client $client)
    {
        $this->getEntityManager()->persist($client);
        $this->getEntityManager()->flush();
    }

}