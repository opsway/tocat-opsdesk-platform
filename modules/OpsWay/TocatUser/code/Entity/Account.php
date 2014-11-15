<?php

namespace OpsWay\TocatUser\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity Account
 *
 * @package OpsWay\TocatUser\Entity
 * @ORM\Entity
 * @ORM\Table(name="user_accounts")
 */
class Account
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="OpsWay\TocatUser\Entity\User", inversedBy="account")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    protected $user;
    /**
     * @var float
     * @ORM\Column(type="decimal", precision=7, scale=3, options={"default" = 0})
     */
    protected $balance;

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
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param float $balance
     *
     * @return $this
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
