<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Company;
use App\Entity\Plane;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class PlaneEventSubscriber implements EventSubscriberInterface
{

    private $manager;

    /**
     * PlaneEventSubscriber constructor.
     * @param ManagerRegistry $manager
     */
    public function __construct(ManagerRegistry $manager)
    {
        $this->manager = $manager->getManager();
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['createPlane', EventPriorities::PRE_WRITE],
        ];
    }

    public function createPlane(GetResponseForControllerResultEvent $event)
    {
        $plane = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$plane instanceof Plane || Request::METHOD_POST !== $method) {
            return;
        }

        /** @var Company $company */
        $companies = $this->manager->getRepository(Company::class)->findAll();
        $plane->setCompany($companies[0]);
    }
}