<?php

namespace TocatUserTest\Entity;

use TocatUser\Entity\User as Entity;

class UserTest extends \PHPUnit_Framework_TestCase
{
    protected $user;

    public function setUp()
    {
        $user = new Entity;
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
}
