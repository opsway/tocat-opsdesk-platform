<?php

namespace OpsWay\TocatBudgetTest\Entity;

use OpsWay\TocatBudget\Entity\My as Entity;

class MyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Entity
     */
    protected $my;

    public function setUp()
    {
        $my = new Entity();
        $this->my = $my;
    }

    public function testSetGetId()
    {
        $this->assertEquals($this->my, $this->my->setId(1));
        $this->assertEquals(1, $this->my->getId());
    }

    public function testSetGetName()
    {
        $this->assertEquals($this->my, $this->my->setName('test'));
        $this->assertEquals('test', $this->my->getName());
    }
}
