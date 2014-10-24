<?php
namespace TocatUser\Service;

use TocatUser\Repository\RoleRepository;

class RoleService
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAll()
    {
        return $this->roleRepository->findAll();
    }

    public function getList()
    {
        $result = [];
        foreach ($this->getAll() as $role) {
            $data = $this->roleRepository->extract($role);
            if ($role->getParent() != null) {
                $data['parentId'] = $role->getParent()->getId();
            } else {
                $data['parentId'] = 0;
            }
            unset($data['parent']);
            $result[] = $data;
        }
        return $result;
    }

    public function saveTree($treeRole)
    {
        // todo: Optimaze it to load all list entities
        $ids = [];
        foreach ($this->walkTree($treeRole) as $roleData) {
            $role = false;
            if (isset($roleData['id'])) {
                $role = $this->roleRepository->find($roleData['id']);
            }
            if (!$role) {
                $role = $this->roleRepository->createNewEntity();
            }
            $role = $this->roleRepository->hydrate($role, $roleData);
            if ($roleData['parentId']) {
                $role->setParent($this->roleRepository->find($roleData['parentId']));
            }
            $this->roleRepository->save($role);
            $ids[] = $role->getId();
        }
        foreach ($this->getAll() as $role) {
            if (in_array($role->getId(), $ids)) {
                continue;
            }
            $this->roleRepository->delete($role);
        }
    }

    /**
     * @param      $treeNode
     * @param null $parentNodeId
     *
     * @return \Generator
     */
    public function walkTree($treeNode, $parentNodeId = null)
    {
        foreach ($treeNode as $node) {
            $row = $node;
            $row['parentId'] = $parentNodeId;
            $nodes = (!empty($node['nodes'])) ? $node['nodes'] : null;
            unset($row['nodes']);
            yield $row;
            if (!is_null($nodes)) {
                foreach ($this->walkTree($nodes, $node['id']) as $nRow) {
                    yield $nRow;
                }
            }
        }
    }
}
