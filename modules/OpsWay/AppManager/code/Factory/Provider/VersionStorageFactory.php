<?php
namespace OpsWay\AppManager\Factory\Provider;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class VersionStorageFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['application_manager'];
        foreach ($config['version_storage'] as $name => $config) {
            if (class_exists($name)) {
                return new $name($config);
            }
        }
        throw new \RuntimeException('Not found providers for version_storage service.');
    }
}
