<?php

namespace OpsWay\TocatUser\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity Calendar
 *
 * @package OpsWay\TocatUser\Entity
 * @ORM\Entity
 * @ORM\Table(name="user_calendars")
 */
class Calendar
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="OpsWay\TocatUser\Entity\User", inversedBy="calendar")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="OpsWay\TocatUser\Entity\CalendarEvent", mappedBy="calendar", cascade={"persist"})
     */
    protected $events;
    /**
     * @var \DateTime
     * @ORM\Column(type="time")
     */
    protected $begin_day;
    /**
     * @var \DateTime
     * @ORM\Column(type="time")
     */
    protected $end_day;

    /**
     * Initialies the $permissions variable.
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
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
     * @return \DateTime
     */
    public function getBeginDay()
    {
        return $this->begin_day;
    }

    /**
     * @param \DateTime $value
     *
     * @return $this
     *
     */
    public function setBeginDay(\DateTime $value)
    {
        $this->begin_day = $value;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDay()
    {
        return $this->end_day;
    }

    /**
     * @param \DateTime $value
     *
     * @return $this
     *
     */
    public function setEndDay(\DateTime $value)
    {
        $this->end_day = $value;
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
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function getEvents()
    {
        return $this->events->getValues();
    }

    public function getEventsCollection()
    {
        return $this->events;
    }
}
