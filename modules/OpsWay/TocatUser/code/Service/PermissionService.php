<?php
namespace OpsWay\TocatUser\Service;

use OpsWay\TocatUser\Entity\Permission;
use OpsWay\TocatUser\Entity\Role;
use OpsWay\TocatUser\Repository\PermissionRepository;
use Zend\ServiceManager\ServiceLocatorInterface;

class PermissionService
{
    const TYPE_GUARD = 'guard';
    const TYPE_RESOURCE = 'resource';
    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * @var null|array
     */
    protected $_staticController = null;

    public function __construct(PermissionRepository $permissionRepository, ServiceLocatorInterface $serviceLocator)
    {
        $this->permissionRepository = $permissionRepository;
        $this->serviceLocator = $serviceLocator;
    }

    public function updateAclByRole($role, $data, $type)
    {
        $currentPermissions = $role->getPermissions();
        foreach ($currentPermissions as $permission) {
            if (!isset($data[$permission->getResource()])) {
                $this->permissionRepository->delete($permission, false);
                continue;
            }
            $privileges = $permission->getPrivileges();
            $newPriv = $privileges;
            if ($privileges && !isset($data[$permission->getResource()]['action'])) {
                $newPriv = null;
            } elseif (isset($data[$permission->getResource()]['action'])) {
                $newPriv = implode(',', $data[$permission->getResource()]['action']);
            }
            if ($newPriv != $privileges) {
                $permission->setPrivileges($newPriv);
                $this->permissionRepository->save($permission, false);
            }
            unset($data[$permission->getResource()]);
        }
        foreach ($data as $resource => $value) {
            $aclEntity = $this->permissionRepository->createNewEntity();
            $aclEntity->setResource($resource)
                ->setRole($role)
                ->setType($type);
            if (isset($value['action'])) {
                $aclEntity->setPrivileges(implode(',', $value['action']));
            }
            $this->permissionRepository->save($aclEntity, false);
        }

        $this->permissionRepository->flushAll();
    }

    public function getIsAccessedCallback($role_id)
    {
        $permissions = [];
        foreach ($this->permissionRepository->findBy(['role' => $role_id]) as $rowEntity) {
            $permissions[$rowEntity->getResource()] = $this->permissionRepository->extract($rowEntity);
        }

        return function ($resource, $privilege = null) use ($permissions) {
            if (is_null($privilege) && isset($permissions[$resource])) {
                return true;
            } elseif (!is_null($privilege) && isset($permissions[$resource])) {
                return (stripos($permissions[$resource]['privileges'], $privilege) !== false);
            }
            return false;
        };
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

    public function getAllStaticControllerGuard()
    {

        if (is_null($this->_staticController)) {
            $controllerManager = $this->getServiceLocator()->get('ControllerManager');
            $controllerConfig = $controllerManager->getRegisteredServices();
            $listCanonicalNames = $controllerManager->getCanonicalNames();
            $this->_staticController = [];
            foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($controllerConfig)) as $controllerAliasName) {
                $controllerName = array_search($controllerAliasName, $listCanonicalNames);
                if ($controllerName === false) {
                    $controllerName = $controllerAliasName;
                }
                try {

                    $controller = $controllerManager->get($controllerAliasName);
                    $reflection = new \ReflectionObject($controller);
                    $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);

                    if (count($methods)) {
                        $this->_staticController[$controllerName] = array_filter(
                            array_map(function ($method) {
                                return $method->name;
                            }, $methods),
                            function ($action) {
                                if ($action === 'getMethodFromAction') {
                                    return false;
                                }
                                return (strpos($action, 'Action') !== false);
                            }
                        );

                        $this->_staticController[$controllerName] = array_map(
                            function ($action) {
                                return str_replace('Action', '', $action);
                            },
                            $this->_staticController[$controllerName]
                        );
                    } else {
                        $this->_staticController[$controllerName] = [];
                    }
                } catch (\Exception $e) {
                    $this->_staticController[$controllerName] = [];
                }
            }
        }

        return $this->_staticController;
    }

    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}
