<?php

namespace OpsWay\TocatUser\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity CalendarEvent
 *
 * @package OpsWay\TocatUser\Entity
 * @ORM\Entity
 * @ORM\Table(name="user_calendar_events")
 */
class CalendarEvent
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     *  @ORM\ManyToOne(targetEntity="OpsWay\TocatUser\Entity\Calendar", inversedBy="events", cascade={"persist"})
     *  @ORM\JoinColumn(name="calendar_id", referencedColumnName="id", unique=false, nullable=false)
     */
    protected $calendar;
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $email;
    /**
      * @var string
      * @ORM\Column(type="string", length=255, nullable=true)
      */
     protected $name;
    /**
      * @var string
      * @ORM\Column(type="string", length=255, nullable=true)
      */
     protected $notes;
    /**
     * @var \DateTime
     * @ORM\Column(name="start_at", type="datetime")
     */
    protected $startAt;
    /**
     * @var \DateTime
     * @ORM\Column(name="end_at", type="datetime")
     */
    protected $endAt;
    /**
     * @var bool
     * @ORM\Column(name="accept", type="boolean", nullable=false)
     */
    protected $accept = false;

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
     * @return Calendar
     */
    public function getCalendar()
    {
        return $this->calendar;
    }

    /**
     * @param Calendar $calendar
     *
     * @return $this
     */
    public function setCalendar($calendar)
    {
        $this->calendar = $calendar;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartAt()
    {
        return $this->startAt;
    }


    /**
     * @param \DateTime $start_at
     * @return $this
     */
    public function setStartAt($start_at)
    {
        $this->startAt = $start_at;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndAt()
    {
        return $this->endAt;
    }


    /**
     * @param \DateTime $end_at
     * @return $this
     */
    public function setEndAt($end_at)
    {
        $this->endAt = $end_at;
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
     * @return $this
     */
    public function setAccept($accept)
    {
        $this->accept = $accept;
        return $this;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     *
     * @return $this
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
        return $this;
    }
}
