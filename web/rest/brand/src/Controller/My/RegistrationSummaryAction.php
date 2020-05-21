<?php

namespace Controller\My;

use ApiPlatform\Core\Exception\ResourceClassNotFoundException;
use Ivoz\Kam\Domain\Model\UsersLocation\UsersLocationRepository;
use Ivoz\Provider\Domain\Model\Administrator\AdministratorInterface;
use Ivoz\Provider\Domain\Model\Company\CompanyRepository;
use Ivoz\Provider\Domain\Model\Terminal\TerminalRepository;
use Ivoz\Provider\Domain\Model\Friend\FriendRepository;
use Ivoz\Provider\Domain\Model\Domain\DomainRepository;
use Ivoz\Provider\Domain\Model\ResidentialDevice\ResidentialDeviceRepository;
use Ivoz\Provider\Domain\Model\RetailAccount\RetailAccountRepository;
use Model\RegistrationSummary;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class RegistrationSummaryAction
{
    protected $tokenStorage;
    protected $domainRepository;
    protected $usersLocationRepository;
    protected $companyRepository;
    protected $terminalRepository;
    protected $friendRepository;
    protected $residentialDeviceRepository;
    protected $retailAccountRepository;

    public function __construct(
        TokenStorage $tokenStorage,
        DomainRepository $domainRepository,
        UsersLocationRepository $usersLocationRepository,
        CompanyRepository $companyRepository,
        TerminalRepository $terminalRepository,
        FriendRepository $friendRepository,
        ResidentialDeviceRepository $residentialDeviceRepository,
        RetailAccountRepository $retailAccountRepository
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->domainRepository = $domainRepository;
        $this->usersLocationRepository = $usersLocationRepository;
        $this->companyRepository = $companyRepository;
        $this->terminalRepository = $terminalRepository;
        $this->friendRepository = $friendRepository;
        $this->residentialDeviceRepository = $residentialDeviceRepository;
        $this->retailAccountRepository = $retailAccountRepository;
    }

    public function __invoke()
    {
        /** @var TokenInterface $token */
        $token =  $this->tokenStorage->getToken();

        if (!$token || !$token->getUser()) {
            throw new ResourceClassNotFoundException('User not found');
        }

        /** @var AdministratorInterface $user */
        $user = $token->getUser();
        $brand = $user->getBrand();

        if (!$brand) {
            throw new NotFoundHttpException('Brand not found');
        }

        $domains = $this->domainRepository->findByBrandIdAndCompanies(
            $brand->getId()
        );

        $domainFqdns = [];
        foreach ($domains as $domain) {
            $domainFqdns[] = $domain->getDomain();
        }

        $userLocations = $this->usersLocationRepository->findByDomains(
            $domainFqdns
        );

        $now = new \DateTime();
        $active = 0;
        $total = $this->getTotalDevices();

        foreach ($userLocations as $userLocation) {
            if ($userLocation->getExpires() > $now) {
                $active++;
            }
        }

        return new RegistrationSummary(
            $active,
            $total
        );
    }

    /**
     * @return int
     */
    private function getTotalDevices(): int
    {
        $total = 0;

        $vpbxIds = $this->companyRepository->getVpbxIds();

        $total += $this->terminalRepository->countRegistrableDevices($vpbxIds);
        $total += $this->friendRepository->countRegistrableDevices($vpbxIds);
        $total += $this->residentialDeviceRepository->countRegistrableDevices();
        $total += $this->retailAccountRepository->countRegistrableDevices();

        return $total;
    }
}
