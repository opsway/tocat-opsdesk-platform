<?php

namespace Tests;

use OpsWay\TocatUser\Module;
use PHPUnit_Framework_TestCase;

class ModuleTest extends PHPUnit_Framework_TestCase
{
    /**
     * Scans service manager configuration, returning all services created by factories and invokables
     * @return array
     */
    public function provideServiceList()
    {
        $config = array_merge(
            include __DIR__ . '/../../config/module.config.php',
            include __DIR__ . '/../../config/controller.config.php',
            include __DIR__ . '/../../config/router.config.php',
            include __DIR__ . '/../../config/service.config.php',
            include __DIR__ . '/../../config/view.config.php',
            include __DIR__ . '/../../config/navigation.config.php'
        );
        $serviceConfig = array_merge(
            isset($config['service_manager']['factories'])?$config['service_manager']['factories']:array(),
            isset($config['service_manager']['invokables'])?$config['service_manager']['invokables']:array()
        );
        $services = array();
        foreach ($serviceConfig as $key => $val) {
            $services[] = array($key);
        }
        return $services;
    }

    /**
     * @dataProvider provideServiceList
     */
    public function testService($service)
    {
        $sm = Bootstrap::getServiceManager();
        // test if service is available in SM
        $this->assertTrue($sm->has($service));
        // test if correct instance is created
        //$this->assertInstanceOf($service, $sm->get($service));
    }

    public function testGetConfig()
    {
        $config = array_merge(
            include __DIR__ . '/../../config/module.config.php',
            include __DIR__ . '/../../config/controller.config.php',
            include __DIR__ . '/../../config/router.config.php',
            include __DIR__ . '/../../config/service.config.php',
            include __DIR__ . '/../../config/view.config.php',
            include __DIR__ . '/../../config/navigation.config.php'
        );
        $configAutoload = array(
                    'Zend\Loader\StandardAutoloader' => array(
                        'namespaces' => array(
                            'OpsWay\TocatUser' => realpath(__DIR__ . '/../../') . '/code',
                        ),
                    ),
                );
        $module = new Module();
        $this->assertEquals($config, $module->getConfig());
        $this->assertEquals($configAutoload, $module->getAutoloaderConfig());
    }
}
