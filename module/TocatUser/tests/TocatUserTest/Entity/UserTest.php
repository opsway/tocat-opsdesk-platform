<?php

namespace TocatUserTest\Entity;

use TocatUser\Entity\Group;
use TocatUser\Entity\Role;
use TocatUser\Entity\User as Entity;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Entity
     */
    protected $user;

    /**
     * @covers TocatUser\Entity\User::__construct
     */
    public function setUp()
    {
        $user = new Entity();
        $this->user = $user;
    }

    /**
     * @covers TocatUser\Entity\User::setId
     * @covers TocatUser\Entity\User::getId
     */
    public function testSetGetId()
    {
        $this->user->setId(1);
        $this->assertEquals(1, $this->user->getId());
    }

    /**
     * @covers TocatUser\Entity\User::setUsername
     * @covers TocatUser\Entity\User::getUsername
     */
    public function testSetGetUsername()
    {
        $this->user->setUsername('tocatUser');
        $this->assertEquals('tocatUser', $this->user->getUsername());
    }

    /**
     * @covers TocatUser\Entity\User::setDisplayName
     * @covers TocatUser\Entity\User::getDisplayName
     */
    public function testSetGetDisplayName()
    {
        $this->user->setDisplayName('Zfc User');
        $this->assertEquals('Zfc User', $this->user->getDisplayName());
    }

    /**
     * @covers TocatUser\Entity\User::setEmail
     * @covers TocatUser\Entity\User::getEmail
     */
    public function testSetGetEmail()
    {
        $this->user->setEmail('tocatUser@tocatUser.com');
        $this->assertEquals('tocatUser@tocatUser.com', $this->user->getEmail());
    }

    /**
     * @covers TocatUser\Entity\User::setPassword
     * @covers TocatUser\Entity\User::getPassword
     */
    public function testSetGetPassword()
    {
        $this->user->setPassword('tocatUser');
        $this->assertEquals('tocatUser', $this->user->getPassword());
    }

    /**
     * @covers TocatUser\Entity\User::setState
     * @covers TocatUser\Entity\User::getState
     */
    public function testSetGetState()
    {
        $this->user->setState(1);
        $this->assertEquals(1, $this->user->getState());
    }

    /**
     * @covers TocatUser\Entity\User::getRoles
     * @covers TocatUser\Entity\User::addRole
     * @covers TocatUser\Entity\User::updateRoles
     * @covers TocatUser\Entity\User::removeRoles
     */
    public function testRoles()
    {
        // Setup two different roles
        $role = new Role();
        $role2 = new Role();
        $role2->setId(2);
        $role2->setRoleId('fake');
        $role2->setParent($role);

        //Check what current user don't contain any roles
        $this->assertCount(0, $this->user->getRoles());
        //Check count roles after add one roles
        $this->user->addRole($role);
        $this->assertCount(1, $this->user->getRoles());
        //Check equal one role in list user roles
        foreach ($this->user->getRoles() as $row) {
            $this->assertEquals($role, $row);
        }
        //Check not equal two role2 in list user roles
        foreach ($this->user->getRoles() as $row) {
            $this->assertNotEquals($role2, $row);
        }
        //Check same inverted after updating roles
        $this->user->updateRoles(array($role2));
        foreach ($this->user->getRoles() as $row) {
            $this->assertEquals($role2, $row);
        }
        foreach ($this->user->getRoles() as $row) {
            $this->assertNotEquals($role, $row);
        }
        //Check what removing deleting right role
        $this->user->removeRoles(array($role));
        $this->assertCount(1, $this->user->getRoles());
        $this->user->removeRoles(array($role2));
        $this->assertCount(0, $this->user->getRoles());

    }

    /**
     * @covers TocatUser\Entity\User::addGroup
     * @covers TocatUser\Entity\User::getGroups
     * @covers TocatUser\Entity\User::updateGroups
     */
    public function testGroups()
    {
        $this->assertCount(0, $this->user->getGroups());
        $this->user->addGroup(new Group());
        $this->assertCount(1, $this->user->getGroups());
        foreach ($this->user->getGroups() as $group) {
            $this->assertEquals(new Group(), $group);
        }
        $groups = [(new Group())->setId(1), (new Group())->setId(2)];
        $this->user->updateGroups($groups);
        $this->assertCount(2, $this->user->getGroups());
        foreach ($this->user->getGroups() as $group) {
            $this->assertNotEquals(new Group(), $group);
        }
    }
}
