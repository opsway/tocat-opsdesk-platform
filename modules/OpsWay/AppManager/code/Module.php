<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace OpsWay\AppManager;

use OpsWay\AppManager\Service\Manager;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements BootstrapListenerInterface, ConfigProviderInterface, AutoloaderProviderInterface, ConsoleUsageProviderInterface
{
    protected $_listModules = [];
    protected $_pathMigrations = [];

    public function onBootstrap(EventInterface $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function init($moduleManager)
    {
        // Remember to keep the init() method as lightweight as possible
        $events = $moduleManager->getEventManager();
        $events->attach('loadModules.post', array($this, 'modulesLoaded'));
        $sharedEvents = $events->getSharedManager();
        $sharedEvents->attach('Zend\Mvc\Application', MvcEvent::EVENT_BOOTSTRAP, array($this, 'onStartBootstrap'), PHP_INT_MAX - 1);
        $sharedEvents->attach('doctrine', 'loadCli.post', array($this, 'initializeConsole'), 100);
    }

    public function initializeConsole($e)
    {
        if (strpos(implode('-', $_SERVER['argv']), 'app-install') !== false) {
            $e->stopPropagation(true);
        }
    }

    public function modulesLoaded($e)
    {
        // This method is called once all modules are loaded.
        $moduleManager = $e->getTarget();
        $sm = $e->getParam('ServiceManager');
        $loadedModules = $moduleManager->getLoadedModules();
        $config = $sm->get('Config');
        if (isset($config['application_manager']) && isset($config['application_manager']['module_paths_migration'])) {
            $configMigration = $config['application_manager']['module_paths_migration'];
            foreach ($loadedModules as $name => $module) {
                if ($module instanceof Feature\VersionProviderInterface && isset($configMigration[$name])) {
                    $this->_listModules[$name] = $module->getVersion();
                    $this->_pathMigrations[$name] = $configMigration[$name];
                }
            }
        }

    }

    public function onStartBootstrap($e)
    {
        if (!\Zend\Console\Console::isConsole()) {
            $manager = $e->getApplication()->getServiceManager()->get(Manager::class);
            if (!$manager->getEventManager()->getListeners('install')->isEmpty()) {
                die('Please first install this application');
            }
        }
    }


    /**
     * This method is defined in ConsoleUsageProviderInterface
     */
    public function getConsoleUsage(Console $console)
    {
        return [
            'Installation and updating modules in application',
            'app update [--params=]'  => 'Run UPDATE migration if needed for application modules',
            'app install [--params=]' => 'Run INSTALL migrations on each modules if needed',
            ['--params="FOO=bar&P1=234"', 'Params like GET params which will available in migrations'],
        ];
    }

    public function getConfig()
    {
        return array_merge(
            include __DIR__ . '/../config/module.config.php',
            include __DIR__ . '/../config/controller.config.php',
            include __DIR__ . '/../config/router.config.php',
            include __DIR__ . '/../config/service.config.php'
        );
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

    /**
     * @return array
     */
    public function getListModules()
    {
        return $this->_listModules;
    }

    /**
     * @return array
     */
    public function getPathMigrations()
    {
        return $this->_pathMigrations;
    }
}
