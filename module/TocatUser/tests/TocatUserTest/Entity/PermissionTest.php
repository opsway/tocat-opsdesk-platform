<?php

namespace TocatUserTest\Entity;

use TocatUser\Entity\Permission as Entity;
use TocatUser\Entity\Role;

class PermissionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Entity
     */
    protected $permission;

    public function setUp()
    {
        $permission = new Entity();
        $this->permission = $permission;
    }

    public function testSetGetId()
    {
        $this->assertEquals($this->permission, $this->permission->setId(1));
        $this->assertEquals(1, $this->permission->getId());
    }

    public function testSetGetResource()
    {
        $this->assertEquals($this->permission, $this->permission->setResource('test'));
        $this->assertEquals('test', $this->permission->getResource());
    }

    public function testSetGetPrivileges()
    {
        $this->assertEquals($this->permission, $this->permission->setPrivileges('test desc'));
        $this->assertEquals('test desc', $this->permission->getPrivileges());
    }

    public function testSetGetType()
    {
        $this->assertEquals($this->permission, $this->permission->setType('test'));
        $this->assertEquals('test', $this->permission->getType());
    }

    public function testSetGetRole()
    {
        $this->assertEquals($this->permission, $this->permission->setRole(new Role()));
        $this->assertNotEquals((new Role())->setId(2), $this->permission->getRole());
        $this->assertEquals(new Role(), $this->permission->getRole());
    }
}
