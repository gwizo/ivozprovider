<?php

namespace Ivoz\Kam\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Core\Infrastructure\Persistence\Doctrine\Model\Helper\CriteriaHelper;
use Ivoz\Kam\Domain\Model\TrunksLcrGateway\TrunksLcrGatewayInterface;
use Ivoz\Kam\Domain\Model\TrunksLcrRule\TrunksLcrRuleInterface;
use Ivoz\Kam\Domain\Model\TrunksLcrRuleTarget\TrunksLcrRuleTarget;
use Ivoz\Kam\Domain\Model\TrunksLcrRuleTarget\TrunksLcrRuleTargetInterface;
use Ivoz\Kam\Domain\Model\TrunksLcrRuleTarget\TrunksLcrRuleTargetRepository;
use Ivoz\Provider\Domain\Model\OutgoingRouting\OutgoingRoutingInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * TrunksLcrRuleTargetDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TrunksLcrRuleTargetDoctrineRepository extends ServiceEntityRepository implements TrunksLcrRuleTargetRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrunksLcrRuleTarget::class);
    }

    /**
     * @param OutgoingRoutingInterface $outgoingRouting
     * @param TrunksLcrRuleInterface $lcrRule
     * @param TrunksLcrGatewayInterface $lcrGateway
     * @return TrunksLcrRuleTargetInterface | null
     */
    public function findRuleTarget(
        OutgoingRoutingInterface $outgoingRouting,
        TrunksLcrRuleInterface $lcrRule,
        TrunksLcrGatewayInterface $lcrGateway
    ) {
        /** @var TrunksLcrRuleTargetInterface $response */
        $response = $this->findOneBy([
            'outgoingRouting' => $outgoingRouting->getId(),
            'rule' => $lcrRule->getId(),
            'gw' => $lcrGateway->getId()
        ]);

        return $response;
    }

    /**
     * {@inheritdoc}
     *
     * @param OutgoingRoutingInterface $outgoingRouting
     * @return TrunksLcrRuleTargetInterface[]
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function findOrphanLcrRuleTargets(OutgoingRoutingInterface $outgoingRouting)
    {
        $lcrRuleTargetIds = [];

        $outgoingRoutingLcrRuleTargets = $outgoingRouting->getLcrRuleTargets();
        foreach ($outgoingRoutingLcrRuleTargets as $outgoingRoutingLcrRule) {
            $lcrRuleTargetIds[] = $outgoingRoutingLcrRule->getId();
        }

        $qb = $this->createQueryBuilder('self');
        $qb
            ->select('self')
            ->addCriteria(
                CriteriaHelper::fromArray([
                    [ 'outgoingRouting', 'eq', $outgoingRouting ],
                    [ 'id', 'notIn', $lcrRuleTargetIds ]
                ])
            );

        return $qb->getQuery()->getResult();
    }
}
