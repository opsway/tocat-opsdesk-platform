<?php
namespace OpsWay\TocatUser\Service;

use OpsWay\TocatUser\Entity\Group;
use OpsWay\TocatUser\Repository\GroupRepository;

class GroupService
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function getAll()
    {
        return $this->groupRepository->findAll();
    }

    public function getList()
    {
        return array_map(function ($group) {
            return $this->groupRepository->extract($group);
        }, $this->getAll());
    }
    
    public function saveRow(array $row)
    {
        $group = false;
        if (isset($row['id'])) {
            $group = $this->groupRepository->find($row['id']);
        }
        if (!$group) {
            $group = new Group();
        }
        $group = $this->groupRepository->hydrate($group, $row);
        $this->groupRepository->save($group);
        return $this->groupRepository->extract($group);
    }

    public function deleteRow(array $row)
    {
        if (!isset($row['id'])) {
            throw new \InvalidArgumentException('$entity should contain ID key for delete action');
        }
        $group = $this->groupRepository->find($row['id']);
        $this->groupRepository->delete($group);
    }
}
