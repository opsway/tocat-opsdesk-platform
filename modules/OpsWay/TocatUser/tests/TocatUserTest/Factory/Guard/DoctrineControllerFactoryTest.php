<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link           http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright      Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license        http://framework.zend.com/license/new-bsd New BSD License
 * @package        Zend_Service
 */

namespace OpsWay\TocatUserTest\Factory\Guard;

use OpsWay\TocatUser\Factory\Guard\DoctrineControllerFactory;
use OpsWay\TocatUser\Guard\DoctrineController;
use PHPUnit_Framework_TestCase;
use BjyAuthorize\Service\ControllerGuardServiceFactory;

/**
 * Test for {@see \OpsWay\TocatUserTest\Factory\Guard\DoctrineControllerFactory}
 *
 */
class DoctrineControllerFactoryTest extends PHPUnit_Framework_TestCase
{
    protected $factory;
    protected $serviceLocator;
    protected $config;
    protected $entityManager;
    protected $repository;

    protected function setUp()
    {
        $this->factory = new DoctrineControllerFactory();
        $this->serviceLocator = $this->getMock('Zend\\ServiceManager\\ServiceLocatorInterface');
        $this->config = array(
            'bjyauthorize' => array(
                'guards' => array(
                    'OpsWay\TocatUser\Guard\DoctrineController' => array(),
                ),
            )
        );
        $this->entityManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository
            = $this->getMock('\Doctrine\Common\Persistence\ObjectRepository'); //$this->getMockBuilder(GroupRepository::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * @covers \BjyAuthorize\Service\ControllerGuardServiceFactory::createService
     */
    public function testCreateServiceWithException1()
    {
        $this->setExpectedException('InvalidArgumentException');

        $this->serviceLocator
            ->expects($this->any())
            ->method('get')
            ->with('Config')
            ->will($this->returnValue($this->config));

        $guard = $this->factory->createService($this->serviceLocator);
    }

    /**
     * @covers \BjyAuthorize\Service\ControllerGuardServiceFactory::createService
     */
    public function testCreateServiceWithException2()
    {
        $this->setExpectedException('InvalidArgumentException');
        try {
            $this->config['bjyauthorize']['guards']['OpsWay\TocatUser\Guard\DoctrineController'] = [
                'rule_entity_class' => \OpsWay\TocatUser\Entity\Permission::class
            ];
            $this->serviceLocator
                ->expects($this->any())
                ->method('get')
                ->with('Config')
                ->will($this->returnValue($this->config));

            $guard = $this->factory->createService($this->serviceLocator);
        } catch (\Exception $e) {
            $this->assertInstanceOf('BjyAuthorize\Exception\InvalidArgumentException', $e);
            throw $e;
        }
    }

    /**
     * @covers \BjyAuthorize\Service\ControllerGuardServiceFactory::createService
     */
    public function testCreateService()
    {
        $this->config['bjyauthorize']['guards']['OpsWay\TocatUser\Guard\DoctrineController'] = [
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'rule_entity_class' => \OpsWay\TocatUser\Entity\Permission::class
        ];

        $this->repository->expects($this->once())
            ->method('findBy')
            ->with(['type' => 'guard'])
            ->will($this->returnValue([]));

        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->with(\OpsWay\TocatUser\Entity\Permission::class)
            ->will($this->returnValue($this->repository));

        $this->serviceLocator->expects($this->at(1))
            ->method('get')
            ->with('doctrine.entitymanager.orm_default')
            ->will($this->returnValue($this->entityManager));

        $this->serviceLocator
            ->expects($this->at(0))
            ->method('get')
            ->with('Config')
            ->will($this->returnValue($this->config));


        $guard = $this->factory->createService($this->serviceLocator);

        $this->assertInstanceOf(DoctrineController::class, $guard);
    }

    /**
     * @covers \BjyAuthorize\Service\ControllerGuardServiceFactory::createService
     */
    public function testCreateServiceWithException3()
    {
        $this->setExpectedException('InvalidArgumentException');
        unset($this->config['bjyauthorize']['guards']['OpsWay\TocatUser\Guard\DoctrineController']);
        $this->serviceLocator
            ->expects($this->any())
            ->method('get')
            ->with('Config')
            ->will($this->returnValue($this->config));

        $guard = $this->factory->createService($this->serviceLocator);
    }
}
