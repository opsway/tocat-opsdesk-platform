<?php

namespace OpsWay\TocatUser\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity Group
 *
 * @package OpsWay\TocatUser\Entity
 * @ORM\Entity(repositoryClass="OpsWay\TocatUser\Repository\GroupRepository")
 * @ORM\Table(name="groups")
 */
class Group
{
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
    * @var string
    * @ORM\Column(type="string", length=250, nullable=true)
    */
    protected $description;

    /**
     * @var bool
     * @ORM\Column(name="is_team", type="boolean", nullable=false)
     */
    protected $team = false;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $active = true;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="OpsWay\TocatUser\Entity\User", mappedBy="groups", cascade={"persist"})
     */
    protected $users;

    /**
     * Initialies the users variable.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     *
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
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
     * @return boolean
     */
    public function isTeam()
    {
        return $this->team;
    }

    /**
     * @param boolean $isTeam
     *
     * @return $this
     */
    public function setIsTeam($isTeam)
    {
        $this->team = $isTeam;
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
     * Get user list from group
     * @return array
     */
    public function getUsers()
    {
        return $this->users->getValues();
    }
}
