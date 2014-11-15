<?php

namespace OpsWay\TocatBudget\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Entity Order
 *
 * @package OpsWay\TocatBudget\Entity
 * @ORM\Entity
 * @ORM\Table(name="tocat_orders")
 */
class Order
{
    use TimestampableEntity;

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $name;

    /**
     * @var float
     * @ORM\Column(type="decimal", precision=7, scale=3, options={"default" = 0})
     */
    protected $totalAmount;

    /**
     * @var bool
     * @ORM\Column(name="accept", type="boolean", nullable=false)
     */
    protected $paid = false;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="OpsWay\TocatBudget\Entity\Budget", mappedBy="order", cascade={"persist"})
     */
    protected $budgets;

    /**
     * Initialies the $budgets variable.
     */
    public function __construct()
    {
        $this->budgets = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @param float $totalAmount
     *
     * @return $this
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isPaid()
    {
        return $this->paid;
    }

    /**
     * @param boolean $paid
     *
     * @return $this
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBudgets()
    {
        return $this->budgets->getValues();
    }

    public function getAllocatedBudget()
    {
        return array_reduce(
            $this->getBudgets(),
            function ($total, $budget) {
                $total += $budget->getCost();
            },
            0
        );
    }
}
