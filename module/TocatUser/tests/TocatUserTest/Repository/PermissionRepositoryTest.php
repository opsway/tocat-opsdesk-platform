<?php

namespace TocatUserTest\Repository;

use Tests\Bootstrap;
use TocatUser\Repository\PermissionRepository;
use TocatUser\Entity\Permission as PermissionEntity;

class PermissionRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $locator;
    /**
     * @var PermissionRepository
     */
    private $repository;

    protected function setUp()
    {
        $this->locator = Bootstrap::getServiceManager();
        $this->repository = $this->locator->get(PermissionRepository::class);
    }

    public function testCreateNewEntity()
    {
        $this->assertEquals(new PermissionEntity(), $this->repository->createNewEntity());
    }

    public function testHydrate()
    {
        $data = ['id' => 1];
        $permission = $this->repository->hydrate(new PermissionEntity(), $data);
        $this->assertInstanceOf('TocatUser\Entity\Permission', $permission);
        $this->assertEquals(1, $permission->getId());
    }

    public function testExtract()
    {
        $permission = (new PermissionEntity())->setId(2);
        $data = $this->repository->extract($permission);
        $this->assertArrayHasKey('id', $data);
        $this->assertEquals(2, $data['id']);
    }
}
