<?php

namespace OpsWay\TocatBudget\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity Budget
 *
 * @package OpsWay\TocatBudget\Entity
 * @ORM\Entity
 * @ORM\Table(name="tocat_budgets",uniqueConstraints={@ORM\UniqueConstraint(name="order_issue_idx", columns={"order_id", "issue_id"})})
 */
class Budget
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="OpsWay\TocatBudget\Entity\Issue", inversedBy="budgets", cascade={"persist"})
     * @ORM\JoinColumn(name="issue_id", referencedColumnName="id", unique=false, nullable=false)
     */
    protected $issue;

    /**
     * @ORM\ManyToOne(targetEntity="OpsWay\TocatBudget\Entity\Order", inversedBy="budgets", cascade={"persist"})
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", unique=false, nullable=false)
     */
    protected $order;

    /**
     * @var float
     * @ORM\Column(type="decimal", precision=7, scale=3, options={"default" = 0})
     */
    protected $cost;

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
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param float $cost
     *
     * @return $this
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
        return $this;
    }

    /**
     * @return Issue
     */
    public function getIssue()
    {
        return $this->issue;
    }

    /**
     * @param Issue $issue
     *
     * @return $this
     */
    public function setIssue($issue)
    {
        $this->issue = $issue;
        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }
}
