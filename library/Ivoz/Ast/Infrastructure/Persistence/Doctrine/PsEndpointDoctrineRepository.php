<?php

namespace Ivoz\Ast\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Ast\Domain\Model\PsEndpoint\PsEndpointRepository;
use Ivoz\Ast\Domain\Model\PsEndpoint\PsEndpoint;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * PsEndpointDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PsEndpointDoctrineRepository extends ServiceEntityRepository implements PsEndpointRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PsEndpoint::class);
    }
}
