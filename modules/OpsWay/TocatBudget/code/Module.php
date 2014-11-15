<?php
namespace OpsWay\TocatBudget;

use OpsWay\AppManager\Feature\VersionProviderInterface;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\Mvc\ModuleRouteListener;

class Module implements BootstrapListenerInterface, ConfigProviderInterface, AutoloaderProviderInterface, DependencyIndicatorInterface, VersionProviderInterface
{

    public function onBootstrap(EventInterface $e)
    {
        /* @var $application \Zend\Mvc\Application */
        $application = $e->getTarget();
        $eventManager = $application->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return array_merge(
            include __DIR__ . '/../config/module.config.php',
            include __DIR__ . '/../config/controller.config.php',
            include __DIR__ . '/../config/router.config.php',
            include __DIR__ . '/../config/service.config.php',
            include __DIR__ . '/../config/view.config.php',
            include __DIR__ . '/../config/navigation.config.php'
        );
    }


    /**
     * Expected to return an array of modules on which the current one depends on
     *
     * @return array
     */
    public function getModuleDependencies()
    {
        return [
            'OpsWay\TocatCore',
            'OpsWay\TocatUser'
        ];
    }

    /**
     * Expected to return string to
     * current version module code
     * Format X.Y.Z[-dev|-beta|-alpha|-rc1]
     *
     * @return string
     */
    public function getVersion()
    {
        return TOCAT_VERSION_SYNC_MODULES;
    }
}
