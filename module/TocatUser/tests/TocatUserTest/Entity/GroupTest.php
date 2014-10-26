<?php

namespace TocatUserTest\Entity;

use TocatUser\Entity\Group as Entity;

class GroupTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Entity
     */
    protected $group;

    public function setUp()
    {
        $group = new Entity();
        $this->group = $group;
    }

    public function testSetGetId()
    {
        $this->group->setId(1);
        $this->assertEquals(1, $this->group->getId());
    }

    public function testSetGetName()
    {
        $this->group->setName('test');
        $this->assertEquals('test', $this->group->getName());
    }

    public function testSetGetDescription()
    {
        $this->group->setDescription('test desc');
        $this->assertEquals('test desc', $this->group->getDescription());
    }

    public function testSetGetDefaultTeam()
    {
        $this->assertEquals(false, $this->group->isTeam());
        $this->group->setIsTeam(true);
        $this->assertEquals(true, $this->group->isTeam());
    }

    public function testSetGetDefaultActive()
    {
        $this->assertEquals(true, $this->group->isActive());
        $this->group->setActive(false);
        $this->assertEquals(false, $this->group->isActive());
    }

    public function testUsers()
    {
        $this->assertCount(0, $this->group->getUsers());
    }
}
