<?php

namespace Application\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\EventManager\EventManagerAwareInterface;

class UserService implements ServiceManagerAwareInterface
{
    /**
     * @var ServiceManager
     */
    protected $sm = null;

    /**
     * Set service manager
     *
     * @param ServiceManager $sm
     *
     * @return $this
     */
    public function setServiceManager(ServiceManager $sm)
    {
        $this->sm = $sm;
        return $this;
    }

    /*
     * Get service manager
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->sm;
    }

    public function saveUser(\Application\Entity\User $user)
    {
        $em = $this->getServiceManager()->get('entity_manager');
        $em->persist($user);
        $em->flush();
    }

    public function removeUser(\Application\Entity\User $user)
    {
        $em = $this->getServiceManager()->get('entity_manager');
        $em->remove($user);
        $em->flush();
    }
}