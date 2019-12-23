<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\RoutingPatternGroup\RoutingPatternGroup;
use Ivoz\Provider\Domain\Model\RoutingPatternGroup\RoutingPatternGroupInterface;
use Ivoz\Provider\Domain\Model\RoutingPatternGroup\RoutingPatternGroupRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * RoutingPatternGroupDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RoutingPatternGroupDoctrineRepository extends ServiceEntityRepository implements RoutingPatternGroupRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RoutingPatternGroup::class);
    }

    /**
     * @param int $brandId
     * @param string $name
     * @return RoutingPatternGroupInterface
     */
    public function findByBrandIdAndName($brandId, string $name)
    {
        /** @var RoutingPatternGroupInterface $response */
        $response = $this->findOneBy([
            'brand' => $brandId,
            'name' => $name
        ]);

        return $response;
    }
}
