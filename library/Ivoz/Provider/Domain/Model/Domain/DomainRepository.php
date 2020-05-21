<?php

namespace Ivoz\Provider\Domain\Model\Domain;

use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Persistence\ObjectRepository;

interface DomainRepository extends ObjectRepository, Selectable
{

    /**
     * @param string $endpointDomain
     * @return DomainInterface | null
     */
    public function findOneByDomain($endpointDomain);

    /**
     * @param int $brandId
     * @return DomainInterface[]
     */
    public function findByBrandIdAndCompanies(int $brandId);

    /**
     * @param int $companyId
     * @return DomainInterface|null
     */
    public function findByCompanyId(int $companyId);
}
