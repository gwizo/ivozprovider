<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\Brand\BrandInterface;
use Ivoz\Provider\Domain\Model\Brand\BrandRepository;
use Ivoz\Provider\Domain\Model\Company\CompanyInterface;
use Ivoz\Provider\Domain\Model\Company\CompanyRepository;
use Ivoz\Provider\Domain\Model\Domain\Domain;
use Ivoz\Provider\Domain\Model\Domain\DomainInterface;
use Ivoz\Provider\Domain\Model\Domain\DomainRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * DomainDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DomainDoctrineRepository extends ServiceEntityRepository implements DomainRepository
{
    protected $brandRepository;
    protected $companyRepository;

    public function __construct(
        RegistryInterface $registry,
        BrandRepository $brandRepository,
        CompanyRepository $companyRepository
    ) {
        parent::__construct($registry, Domain::class);

        $this->brandRepository = $brandRepository;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param string $domain
     * @return DomainInterface | null
     */
    public function findOneByDomain($domain)
    {
        /** @var DomainInterface $response */
        $response = $this->findOneBy([
            'domain' => $domain
        ]);

        return $response;
    }

    /**
     * @param int $brandId
     * @return DomainInterface[]
     */
    public function findByBrandIdAndCompanies(int $brandId)
    {
        $domains = [];

        /** @var BrandInterface $brand */
        $brand = $this->brandRepository->find($brandId);
        if (!$brand) {
            return $domains;
        }

        $brandDomain = $brand->getDomain();
        if ($brandDomain) {
            $domains[] = $brandDomain;
        }

        $companies = $brand->getCompanies();
        foreach ($companies as $company) {
            $companyDomain = $this->findByCompanyId(
                $company->getId()
            );

            if (!$companyDomain) {
                continue;
            }
            $domains[] = $companyDomain;
        }

        return $domains;
    }

    /**
     * @param int $companyId
     * @return DomainInterface|null
     */
    public function findByCompanyId(int $companyId)
    {
        /** @var CompanyInterface $company */
        $company = $this->companyRepository->find($companyId);
        if (!$company) {
            return null;
        }

        return $company->getDomain();
    }
}
