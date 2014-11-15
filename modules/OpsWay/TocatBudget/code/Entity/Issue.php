<?php

namespace OpsWay\TocatBudget\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity Issue
 *
 * @package OpsWay\TocatBudget\Entity
 * @ORM\Entity
 * @ORM\Table(name="tocat_issues")
 */
class Issue
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
    protected $referenceId;
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $status;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $spentTime;

    /**
     * @var bool
     * @ORM\Column(name="is_accept", type="boolean", nullable=false)
     */
    protected $accept = false;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="OpsWay\TocatBudget\Entity\Budget", mappedBy="issue", cascade={"persist"})
     */
    protected $budgets;

    /**
     *
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="OpsWay\TocatBudget\Entity\Recipient")
     * @ORM\JoinTable(name="tocat_issue_recipient_linker",
     *      joinColumns={@ORM\JoinColumn(name="issue_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="recipient_id", referencedColumnName="id", unique=true)}
     *      )
     **/
    protected $recipients;

    /**
     * Initialies the $budgets variable.
     */
    public function __construct()
    {
        $this->budgets = new ArrayCollection();
        $this->recipients = new ArrayCollection();
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
     * @return string
     */
    public function getReferenceId()
    {
        return $this->referenceId;
    }

    /**
     * @param string $referenceId
     *
     * @return $this
     */
    public function setReferenceId($referenceId)
    {
        $this->referenceId = $referenceId;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isAccept()
    {
        return $this->accept;
    }

    /**
     * @param boolean $accept
     *
     * @return $this
     */
    public function setAccept($accept)
    {
        $this->accept = $accept;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getBudgets()
    {
        return $this->budgets->getValues();
    }

    public function getTotalCost()
    {
        return array_reduce(
            $this->getBudgets(),
            function ($total, $budget) {
                $total += $budget->getCost();
            },
            0
        );
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getSpentTime()
    {
        return $this->spentTime;
    }

    /**
     * @param int $spentTime
     *
     * @return $this
     */
    public function setSpentTime($spentTime)
    {
        $this->spentTime = $spentTime;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRecipients()
    {
        return $this->recipients->getValues();
    }

    /**
     * @param Recipient $recipient
     */
    public function addRecipient(Recipient $recipient)
    {
        if (!$this->recipients->contains($recipient)) {
            $this->recipients->add($recipient);
        }
    }
}
