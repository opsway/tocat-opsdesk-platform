<?php

namespace OpsWay\TocatUser\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity Group
 *
 * @package OpsWay\TocatUser\Entity
 * @ORM\Entity(repositoryClass="OpsWay\TocatUser\Repository\PermissionRepository")
 * @ORM\Table(name="permissions")
 */
class Permission
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="OpsWay\TocatUser\Entity\Role", inversedBy="permissions", cascade={"persist"})
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id", unique=false, nullable=false)
     */
    protected $role;
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $resource;

    /**
    * @var string
    * @ORM\Column(type="string", length=250, nullable=true)
    */
    protected $privileges;

    /**
     * @var bool
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    protected $type;

    /**
     * Get role
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set role
     *
     * @param Role $role
     *
     * @return $this
     */
    public function setRole(Role $role)
    {
        $this->role = $role;
        return $this;
    }
    /**
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param string $resource
     *
     * @return $this
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
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
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrivileges()
    {
        return $this->privileges;
    }

    /**
     * @param string $privileges
     *
     * @return $this
     */
    public function setPrivileges($privileges)
    {
        $this->privileges = $privileges;
        return $this;
    }
}
