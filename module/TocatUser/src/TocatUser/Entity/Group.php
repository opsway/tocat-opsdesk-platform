<?php

namespace TocatUser\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity Group
 *
 * @package TocatUser\Entity
 * @ORM\Entity
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
     * @ORM\ManyToMany(targetEntity="TocatUser\Entity\User", mappedBy="users", cascade={"persist"})
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
     */
    public function setActive($active)
    {
        $this->active = $active;
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
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     */
    public function setId($id)
    {
        $this->id = $id;
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
     */
    public function setIsTeam($isTeam)
    {
        $this->team = $isTeam;
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
     */
    public function setName($name)
    {
        $this->name = $name;
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
