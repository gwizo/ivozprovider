<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Ivoz\Core\Infrastructure\Domain\Service\DoctrineQueryRunner;
use Ivoz\Core\Infrastructure\Persistence\Doctrine\Model\Helper\CriteriaHelper;
use Ivoz\Core\Infrastructure\Persistence\Doctrine\Traits\GetGeneratorByConditionsTrait;
use Ivoz\Provider\Domain\Model\BillableCall\BillableCall;
use Ivoz\Provider\Domain\Model\BillableCall\BillableCallInterface;
use Ivoz\Provider\Domain\Model\BillableCall\BillableCallRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * BillableCallDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BillableCallDoctrineRepository extends ServiceEntityRepository implements BillableCallRepository
{
    use GetGeneratorByConditionsTrait;

    protected $queryRunner;

    public function __construct(
        RegistryInterface $registry,
        DoctrineQueryRunner $queryRunner
    ) {
        parent::__construct($registry, BillableCall::class);
        $this->queryRunner = $queryRunner;
    }

    /**
     * @param string $callid
     * @param int $brandId
     * @return BillableCallInterface[]
     */
    public function findOutboundByCallid(string $callid, int $brandId = null)
    {
        $criteria = [
            'callid' => $callid,
            'direction' => BillableCallInterface::DIRECTION_OUTBOUND
        ];

        if ($brandId) {
            $criteria['brand'] = $brandId;
        }

        /** @var BillableCallInterface[] $response */
        $response = $this->findBy(
            $criteria
        );

        return $response;
    }

    /**
     * @param int $id
     * @return BillableCallInterface
     */
    public function findOneByTrunksCdrId($id)
    {
        /** @var BillableCallInterface $response */
        $response = $this->findOneBy([
            'trunksCdr' => $id
        ]);

        return $response;
    }

    /**
     * @inheritdoc
     * @see BillableCallRepository::areRetarificable
     */
    public function areRetarificable(array $pks)
    {
        $qb = $this->createQueryBuilder('self');

        $conditions = [
            ['id', 'in', $pks],
            'or' => [
                ['invoice', 'isNotNull']
            ]
        ];

        $qb
            ->select('count(self)')
            ->addCriteria(
                CriteriaHelper::fromArray($conditions)
            );

        $elementNumber = (int) $qb->getQuery()->getSingleScalarResult();
        return $elementNumber === 0;
    }

    /**
     * Return non externally rated calls without cgrid
     * @inheritdoc
     * @see BillableCallRepository::findUnratedInGroup
     */
    public function findUnratedInGroup(array $pks)
    {
        $qb = $this->createQueryBuilder('self');

        $conditions = [
            ['self.id', 'in', $pks],
            ['self.invoice', 'isNull'],
            ['trunksCdr.cgrid', 'isNull'],
            ['self.direction', 'eq', BillableCallInterface::DIRECTION_OUTBOUND],
            'or' => [
                ['carrier.externallyRated', 'eq', 0],
                ['self.carrier', 'isNUll']
            ]
        ];

        $qb
            ->select('self, trunksCdr')
            ->innerJoin('self.trunksCdr', 'trunksCdr')
            ->leftJoin('self.carrier', 'carrier')
            ->addCriteria(
                CriteriaHelper::fromArray($conditions)
            );
        $query = $qb->getQuery();

        return $query->getResult();
    }

    /**
     * @inheritdoc
     * @see BillableCallRepository::findRerateableCgridsInGroup
     */
    public function findRerateableCgridsInGroup(array $ids)
    {
        $qb = $this->createQueryBuilder('self');

        $conditions = [
            ['id', 'in', $ids],
            ['trunksCdr.cgrid', 'isNotNull'],
            ['self.direction', 'eq', BillableCallInterface::DIRECTION_OUTBOUND],
            'or' => [
                ['carrier.externallyRated', 'eq', 0],
                ['self.carrier', 'isNull']
            ]
        ];

        $qb
            ->select('self, trunksCdr')
            ->innerJoin('self.trunksCdr', 'trunksCdr')
            ->leftJoin('self.carrier', 'carrier')
            ->addCriteria(
                CriteriaHelper::fromArray($conditions)
            );

        $query = $qb->getQuery();

        /** @var BillableCallInterface[] $billableCalls */
        $billableCalls = $query->getResult();

        $cgrids = [];
        foreach ($billableCalls as $billableCall) {
            $cgrids[] = $billableCall->getTrunksCdr()->getCgrid();
        }

        return $cgrids;
    }

    /**
     * @inheritdoc
     * @see BillableCallRepository::idsToTrunkCdrId
     */
    public function idsToTrunkCdrId(array $ids)
    {
        $qb = $this->createQueryBuilder('self');

        $conditions = [
            ['id', 'in', $ids]
        ];

        $qb
            ->select('IDENTITY(self.trunksCdr) as trunksCdr')
            ->addCriteria(
                CriteriaHelper::fromArray($conditions)
            );

        $result = $qb
            ->getQuery()
            ->getScalarResult();

        $trunkCdrIds = array_map(
            function ($item) {
                return $item['trunksCdr'];
            },
            $result
        );

        if (count($ids) !== count($trunkCdrIds)) {
            throw new \RuntimeException('Some id were not found');
        }

        return $trunkCdrIds;
    }

    /**
     * @inheritdoc
     * @see BillableCallRepository::resetPricingData
     */
    public function resetPricingData(array $ids)
    {
        $qb = $this
            ->createQueryBuilder('self')
            ->update($this->_entityName, 'self')
            ->set('self.price', ':nullValue')
            ->set('self.cost', ':nullValue')
            ->set('self.destination', ':nullValue')
            ->set('self.destinationName', ':nullValue')
            ->set('self.ratingPlanGroup', ':nullValue')
            ->set('self.ratingPlanName', ':nullValue')
            ->setParameter(':nullValue', null)
            ->where('self.id in (:ids)')
            ->setParameter(':ids', $ids);

        return $this->queryRunner->execute(
            $this->getEntityName(),
            $qb->getQuery()
        );
    }

    /**
     * @inheritdoc
     * @see BillableCallRepository::resetInvoiceId
     */
    public function resetInvoiceId(int $invoiceId)
    {
        $qb = $this
            ->createQueryBuilder('self')
            ->update($this->_entityName, 'self')
            ->set('self.invoice', ':nullValue')
            ->setParameter(':nullValue', null)
            ->where('self.invoice = :invoiceId')
            ->setParameter(':invoiceId', $invoiceId);

        return $this->queryRunner->execute(
            $this->getEntityName(),
            $qb->getQuery()
        );
    }

    /**
     * @inheritdoc
     * @see BillableCallRepository::setInvoiceId
     */
    public function setInvoiceId(array $conditions, int $invoiceId)
    {
        // In order to reduce table lock times search target ids first
        $finder = $this
            ->createQueryBuilder('self')
            ->select('self.id')
            ->addCriteria(
                CriteriaHelper::fromArray($conditions)
            )
            ->getQuery();

        $targetIds = array_map(
            function (array $row) {
                return $row['id'];
            },
            $finder->execute()
        );

        if (empty($targetIds)) {
            return;
        }

        $qb = $this
            ->createQueryBuilder('self')
            ->update($this->_entityName, 'self')
            ->set('self.invoice', ':invoiceId')
            ->setParameter(':invoiceId', $invoiceId)
            ->addCriteria(
                CriteriaHelper::fromArray([
                    ['id', 'in', $targetIds],
                ])
            );

        return $this->queryRunner->execute(
            $this->getEntityName(),
            $qb->getQuery()
        );
    }

    /**
     * @param int $companyId
     * @param int $brandId
     * @param string $startTime
     * @param string $endTime
     * @return QueryBuilder
     * @throws \Doctrine\ORM\Query\QueryException
     */
    private function getUntarificattedCallQueryBuilder(int $companyId, int $brandId, string $startTime, string $endTime): QueryBuilder
    {
        $qb = $this->createQueryBuilder('self');

        $conditions = [
            ['company', 'eq', $companyId],
            ['brand', 'eq', $brandId],
            ['startTime', 'gt', $startTime],
            ['direction', 'eq', BillableCallInterface::DIRECTION_OUTBOUND],
            'or' => [
                ['price', 'isNull'],
                ['price', 'lt', 0],
            ]
        ];

        $qb
            ->addCriteria(
                CriteriaHelper::fromArray($conditions)
            )->andWhere(
                $qb->expr()->lt(
                    '(self.startTime + self.duration)',
                    preg_replace('/[^0-9]+/', '', $endTime)
                )
            );

        return $qb;
    }

    /**
     * @inheritdoc
     * @see BillableCallRepository::getUntarificattedCallIdsInRange
     */
    public function getUntarificattedCallIdsInRange(int $companyId, int $brandId, string $startTime, string $endTime): array
    {
        $qb = $this->getUntarificattedCallQueryBuilder(
            ...func_get_args()
        );
        $qb->select('self.id');

        $result = $qb->getQuery()->getResult();

        return array_map(
            function ($row) {
                return $row['id'];
            },
            $result
        );
    }

    /**
     * @inheritdoc
     * @see BillableCallRepository::countUntarificattedCallsInRange
     */
    public function countUntarificattedCallsInRange(int $companyId, int $brandId, string $startTime, string $endTime): int
    {
        $results = $this->getUntarificattedCallIdsInRange(
            ...func_get_args()
        );

        return count($results);
    }
}
