<?php

namespace OpsWay\TocatBudgetTest\Repository;

use Tests\Bootstrap;
use OpsWay\TocatBudget\Repository\MyRepository;
use OpsWay\TocatBudget\Entity\My as MyEntity;

class MyRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $locator;
    /**
     * @var MyRepository
     */
    private $repository;

    protected function setUp()
    {
        $this->locator = Bootstrap::getServiceManager();
        $this->repository = $this->locator->get(MyRepository::class);
    }

    public function testCreateNewEntity()
    {
        $this->assertEquals(new MyEntity(), $this->repository->createNewEntity());
    }

    public function testHydrate()
    {
        $data = ['id' => 1];
        $my = $this->repository->hydrate(new MyEntity(), $data);
        $this->assertInstanceOf('OpsWay\TocatBudget\Entity\My', $my);
        $this->assertEquals(1, $my->getId());
    }

    public function testExtract()
    {
        $my = (new MyEntity())->setId(2);
        $data = $this->repository->extract($my);
        $this->assertArrayHasKey('id', $data);
        $this->assertEquals(2, $data['id']);
    }
}
