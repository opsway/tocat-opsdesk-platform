<?php

namespace OpsWay\TocatBudget\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use OpsWay\TocatUser\Entity\Account;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity Recipient
 *
 * @package OpsWay\TocatBudget\Entity
 * @ORM\Entity
 * @ORM\Table(name="tocat_issue_recipients")
 */
class Recipient
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="OpsWay\TocatUser\Entity\Account", cascade={"persist"})
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     **/
    private $account;

    /**
     * @var int
     * @ORM\Column(type="smallint", nullable=false, options={"default" = 100, "comment" = "the percentage of completion issue"})
     */
    protected $perOfCom;

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
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param Account $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return int
     */
    public function getPerOfCom()
    {
        return $this->perOfCom;
    }

    /**
     * @param int $perOfCom
     */
    public function setPerOfCom($perOfCom)
    {
        $this->perOfCom = $perOfCom;
    }
}
