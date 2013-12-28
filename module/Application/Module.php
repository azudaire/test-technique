<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface, FormElementProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }


    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__)
                ),
            ),
        );
    }

    public function getFormElementConfig() {
        return array(
            'factories' => array(
                'form.user' => function ($fem) {
                    $em = $fem->getServiceLocator()->get('entity_manager');

                    $form = new \Application\Form\UserForm();
                    $form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($em, 'Application\Entity\User'))
                        ->setObjectManager($em)
                        ->setObject(new \Application\Entity\User)
                        ->setInputFilter(new \Application\Form\Filter\UserForm($fem->getServiceLocator()));
                    return $form;
                },
            )
        );
    }

    public function getServiceConfig() {
        return array(
            'invokables' => array(
                'application.service.user' => 'Application\Service\UserService'
            )
        );
    }
}
