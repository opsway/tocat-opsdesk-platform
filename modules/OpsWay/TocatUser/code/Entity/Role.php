<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link    https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */

namespace OpsWay\TocatUser\Entity;

use BjyAuthorize\Acl\HierarchicalRoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * An example entity that represents a role.
 *
 * @ORM\Entity(repositoryClass="OpsWay\TocatUser\Repository\RoleRepository")
 * @ORM\Table(name="role")
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Role implements HierarchicalRoleInterface
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
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    protected $roleId;

    /**
     * @var Role
     * @ORM\ManyToOne(targetEntity="OpsWay\TocatUser\Entity\Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     * })
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="OpsWay\TocatUser\Entity\Permission", mappedBy="role", cascade={"persist"})
     */
    protected $permissions;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="OpsWay\TocatUser\Entity\User", mappedBy="roles", cascade={"persist"})
     */
    protected $users;

    /**
     * Initialies the $permissions variable.
     */
    public function __construct()
    {
        $this->permissions = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    /**
     * Get the id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the id.
     *
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = (int) $id;
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

    /**
     * Get the role id.
     *
     * @return string
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * Set the role id.
     *
     * @param string $roleId
     *
     * @return $this
     */
    public function setRoleId($roleId)
    {
        $this->roleId = (string) $roleId;
        return $this;
    }

    /**
     * Get the parent role
     *
     * @return Role
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set the parent role.
     *
     * @param Role $parent
     *
     * @return $this
     */
    public function setParent(Role $parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions->getValues();
    }
}
