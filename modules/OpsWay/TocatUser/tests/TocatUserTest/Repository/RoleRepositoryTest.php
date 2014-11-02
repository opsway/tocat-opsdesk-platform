<?php

namespace OpsWay\TocatUserTest\Repository;

use Tests\Bootstrap;
use OpsWay\TocatUser\Repository\RoleRepository;
use OpsWay\TocatUser\Entity\Role as RoleEntity;

class RoleRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $locator;
    /**
     * @var RoleRepository
     */
    private $repository;

    protected function setUp()
    {
        $this->locator = Bootstrap::getServiceManager();
        $this->repository = $this->locator->get(RoleRepository::class);
    }

    public function testCreateNewEntity()
    {
        $this->assertEquals(new RoleEntity(), $this->repository->createNewEntity());
    }

    public function testHydrate()
    {
        $data = ['id' => 1];
        $role = $this->repository->hydrate(new RoleEntity(), $data);
        $this->assertInstanceOf('OpsWay\TocatUser\Entity\Role', $role);
        $this->assertEquals(1, $role->getId());
    }

    public function testExtract()
    {
        $role = (new RoleEntity())->setId(2);
        $data = $this->repository->extract($role);
        $this->assertArrayHasKey('id', $data);
        $this->assertEquals(2, $data['id']);
    }
}
