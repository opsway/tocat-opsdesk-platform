<?php
namespace OpsWay\TocatUser\Service;

use OpsWay\TocatUser\Entity\Permission;
use OpsWay\TocatUser\Repository\PermissionRepository;

class PermissionService
{
    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAll()
    {
        return $this->permissionRepository->findAll();
    }

    public function getList()
    {
        return array_map(function ($permission) {
            return $this->permissionRepository->extract($permission);
        }, $this->getAll());
    }
    
    public function saveRow(array $row)
    {
        $permission = false;
        if (isset($row['id'])) {
            $permission = $this->permissionRepository->find($row['id']);
        }
        if (!$permission) {
            $permission = new Permission();
        }
        $permission = $this->permissionRepository->hydrate($permission, $row);
        $this->permissionRepository->save($permission);
        return $this->permissionRepository->extract($permission);
    }

    public function deleteRow(array $row)
    {
        if (!isset($row['id'])) {
            throw new \InvalidArgumentException('$entity should contain ID key for delete action');
        }
        $permission = $this->permissionRepository->find($row['id']);
        $this->permissionRepository->delete($permission);
    }
}
