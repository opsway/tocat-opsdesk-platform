<?php
namespace OpsWay\TocatBudget\Factory\Service;

use OpsWay\TocatBudget\Repository\MyRepository;
use OpsWay\TocatBudget\Service\MyService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MyServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return MyService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        /**
         * @var $myRepository MyRepository
         */
        $myRepository = $serviceLocator->get(MyRepository::class);

        return new MyService($myRepository);
    }
}
