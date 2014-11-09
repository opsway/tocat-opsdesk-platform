<?php
namespace OpsWay\AppManager\Service;

use Herrera\Json\Exception\Exception;
use OpsWay\AppManager\Module;
use OpsWay\AppManager\Provider\VersionStorage\ProviderInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Exception\InvalidArgumentException;
use Zend\Config;

class Manager implements EventManagerAwareInterface, ServiceLocatorAwareInterface
{
    use EventManagerAwareTrait;
    use ServiceLocatorAwareTrait;

    /**
     * @var Module
     */
    protected $_module;

    /**
     * @var ProviderInterface
     */
    protected $_versionStorage;

    public function __construct(ServiceLocatorInterface $serviceLocator, EventManagerInterface $eventManager)
    {
        $this->setServiceLocator($serviceLocator);
        $this->_module = $this->getServiceLocator()->get('ModuleManager')->getModule('OpsWay\AppManager');
        $this->_versionStorage = $this->getServiceLocator()->get('version_storage');
        $this->setEventManager($eventManager);
    }

    protected function attachDefaultListeners()
    {
        $this->installAttachModules();
        $this->updateAttachModules();
    }

    public function installAll($params = [])
    {
        return $this->getEventManager()->trigger('install', $this, $params, $this->postProcessingCallback());
    }

    protected function postProcessingCallback()
    {
        return function ($result) {
            $current = $this->_versionStorage->getVersions();
            $this->_versionStorage->setVersions(array_merge($current, [$result['module'] => $result['version']]));
        };
    }

    public function updateAll()
    {
        return $this->getEventManager()->trigger('update', $this, [], $this->postProcessingCallback());
    }

    public function installAttachModules()
    {
        $i = 0;
        $paths = $this->_module->getPathMigrations();
        $currentVersionModules = $this->_versionStorage->getVersions();
        $installFile = 'install.php';// todo resolve it dynamically by modules
        foreach ($this->_module->getListModules() as $name => $version) {
            if (file_exists($paths[$name] . DIRECTORY_SEPARATOR . $installFile)
                && !isset($currentVersionModules[$name])
            ) {
                $this->getEventManager()->attach('install', $this->returnCallbackMigration($installFile, $name), $i--);
            }
        }
    }

    public function updateAttachModules()
    {
        $i = 0;
        $paths = $this->_module->getPathMigrations();
        $currentVersionModules = $this->_versionStorage->getVersions();
        foreach ($this->_module->getListModules() as $name => $version) {
            if (!isset($currentVersionModules[$name])) {
                continue;
            }
            if (version_compare($version, $currentVersionModules[$name], '==')) {
                continue;
            }
            foreach (glob($paths[$name] . '/update-*.php') as $file) {
                preg_match('/update-(?P<version>.*).php$/', $file, $matches);
                if (version_compare($currentVersionModules[$name], $matches['version'], '>=')) {
                    continue;
                }
                if (version_compare($version, $matches['version'], '<')) {
                    continue;
                }
                $this->getEventManager()->attach('update', $this->returnCallbackMigration(basename($file), $name, $matches['version']), $i--);
            }
        }
    }


    public function returnCallbackMigration($migrationFile, $moduleName, $moduleVersion = '0.0.0')
    {
        $paths = $this->_module->getPathMigrations();
        $migrationFile = $paths[$moduleName] . DIRECTORY_SEPARATOR . $migrationFile;
        return function ($e) use ($migrationFile, $moduleName, $moduleVersion) {
            include $migrationFile;
            return ['module' => $moduleName, 'version' => $moduleVersion, 'result' => true];
        };
    }
}
