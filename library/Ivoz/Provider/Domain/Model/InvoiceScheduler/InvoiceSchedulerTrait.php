<?php

namespace Ivoz\Provider\Domain\Model\InvoiceScheduler;

use Ivoz\Core\Application\DataTransferObjectInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;

/**
 * InvoiceSchedulerTrait
 * @codeCoverageIgnore
 */
trait InvoiceSchedulerTrait
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var Collection
     */
    protected $relFixedCosts;


    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct(...func_get_args());
        $this->relFixedCosts = new ArrayCollection();
    }

    /**
     * Factory method
     * @param DataTransferObjectInterface $dto
     * @return self
     */
    public static function fromDto(DataTransferObjectInterface $dto)
    {
        /**
         * @var $dto InvoiceSchedulerDto
         */
        $self = parent::fromDto($dto);
        if ($dto->getRelFixedCosts()) {
            $self->replaceRelFixedCosts($dto->getRelFixedCosts());
        }
        if ($dto->getId()) {
            $self->id = $dto->getId();
            $self->initChangelog();
        }

        return $self;
    }

    /**
     * @param DataTransferObjectInterface $dto
     * @return self
     */
    public function updateFromDto(DataTransferObjectInterface $dto)
    {
        /**
         * @var $dto InvoiceSchedulerDto
         */
        parent::updateFromDto($dto);
        if ($dto->getRelFixedCosts()) {
            $this->replaceRelFixedCosts($dto->getRelFixedCosts());
        }
        return $this;
    }

    /**
     * @param int $depth
     * @return InvoiceSchedulerDto
     */
    public function toDto($depth = 0)
    {
        $dto = parent::toDto($depth);
        return $dto
            ->setId($this->getId());
    }

    /**
     * @return array
     */
    protected function __toArray()
    {
        return parent::__toArray() + [
            'id' => self::getId()
        ];
    }
    /**
     * Add relFixedCost
     *
     * @param \Ivoz\Provider\Domain\Model\FixedCostsRelInvoiceScheduler\FixedCostsRelInvoiceSchedulerInterface $relFixedCost
     *
     * @return InvoiceSchedulerTrait
     */
    public function addRelFixedCost(\Ivoz\Provider\Domain\Model\FixedCostsRelInvoiceScheduler\FixedCostsRelInvoiceSchedulerInterface $relFixedCost)
    {
        $this->relFixedCosts->add($relFixedCost);

        return $this;
    }

    /**
     * Remove relFixedCost
     *
     * @param \Ivoz\Provider\Domain\Model\FixedCostsRelInvoiceScheduler\FixedCostsRelInvoiceSchedulerInterface $relFixedCost
     */
    public function removeRelFixedCost(\Ivoz\Provider\Domain\Model\FixedCostsRelInvoiceScheduler\FixedCostsRelInvoiceSchedulerInterface $relFixedCost)
    {
        $this->relFixedCosts->removeElement($relFixedCost);
    }

    /**
     * Replace relFixedCosts
     *
     * @param \Ivoz\Provider\Domain\Model\FixedCostsRelInvoiceScheduler\FixedCostsRelInvoiceSchedulerInterface[] $relFixedCosts
     * @return self
     */
    public function replaceRelFixedCosts(Collection $relFixedCosts)
    {
        $updatedEntities = [];
        $fallBackId = -1;
        foreach ($relFixedCosts as $entity) {
            $index = $entity->getId() ? $entity->getId() : $fallBackId--;
            $updatedEntities[$index] = $entity;
            $entity->setInvoiceScheduler($this);
        }
        $updatedEntityKeys = array_keys($updatedEntities);

        foreach ($this->relFixedCosts as $key => $entity) {
            $identity = $entity->getId();
            if (in_array($identity, $updatedEntityKeys)) {
                $this->relFixedCosts->set($key, $updatedEntities[$identity]);
            } else {
                $this->relFixedCosts->remove($key);
            }
            unset($updatedEntities[$identity]);
        }

        foreach ($updatedEntities as $entity) {
            $this->addRelFixedCost($entity);
        }

        return $this;
    }

    /**
     * Get relFixedCosts
     *
     * @return \Ivoz\Provider\Domain\Model\FixedCostsRelInvoiceScheduler\FixedCostsRelInvoiceSchedulerInterface[]
     */
    public function getRelFixedCosts(Criteria $criteria = null)
    {
        if (!is_null($criteria)) {
            return $this->relFixedCosts->matching($criteria)->toArray();
        }

        return $this->relFixedCosts->toArray();
    }
}
