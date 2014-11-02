<?php

namespace OpsWay\TocatUserTest\Entity;

use OpsWay\TocatUser\Entity\Group;
use OpsWay\TocatUser\Entity\Role;
use OpsWay\TocatUser\Entity\User as Entity;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Entity
     */
    protected $user;

    /**
     * @covers OpsWay\TocatUser\Entity\User::__construct
     */
    public function setUp()
    {
        $user = new Entity();
        $this->user = $user;
    }

    /**
     * @covers OpsWay\TocatUser\Entity\User::setId
     * @covers OpsWay\TocatUser\Entity\User::getId
     */
    public function testSetGetId()
    {
        $this->user->setId(1);
        $this->assertEquals(1, $this->user->getId());
    }

    /**
     * @covers OpsWay\TocatUser\Entity\User::setUsername
     * @covers OpsWay\TocatUser\Entity\User::getUsername
     */
    public function testSetGetUsername()
    {
        $this->user->setUsername('tocatUser');
        $this->assertEquals('tocatUser', $this->user->getUsername());
    }

    /**
     * @covers OpsWay\TocatUser\Entity\User::setDisplayName
     * @covers OpsWay\TocatUser\Entity\User::getDisplayName
     */
    public function testSetGetDisplayName()
    {
        $this->user->setDisplayName('Zfc User');
        $this->assertEquals('Zfc User', $this->user->getDisplayName());
    }

    /**
     * @covers OpsWay\TocatUser\Entity\User::setEmail
     * @covers OpsWay\TocatUser\Entity\User::getEmail
     */
    public function testSetGetEmail()
    {
        $this->user->setEmail('tocatUser@tocatUser.com');
        $this->assertEquals('tocatUser@tocatUser.com', $this->user->getEmail());
    }

    /**
     * @covers OpsWay\TocatUser\Entity\User::setPassword
     * @covers OpsWay\TocatUser\Entity\User::getPassword
     */
    public function testSetGetPassword()
    {
        $this->user->setPassword('tocatUser');
        $this->assertEquals('tocatUser', $this->user->getPassword());
    }

    /**
     * @covers OpsWay\TocatUser\Entity\User::setState
     * @covers OpsWay\TocatUser\Entity\User::getState
     */
    public function testSetGetState()
    {
        $this->user->setState(1);
        $this->assertEquals(1, $this->user->getState());
    }

    /**
     * @covers OpsWay\TocatUser\Entity\User::getRoles
     * @covers OpsWay\TocatUser\Entity\User::addRole
     * @covers OpsWay\TocatUser\Entity\User::updateRoles
     * @covers OpsWay\TocatUser\Entity\User::removeRoles
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
     * @covers OpsWay\TocatUser\Entity\User::addGroup
     * @covers OpsWay\TocatUser\Entity\User::getGroups
     * @covers OpsWay\TocatUser\Entity\User::updateGroups
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
