<?php
namespace OpsWay\TocatBudget\Service;

use OpsWay\TocatBudget\Entity\My;
use OpsWay\TocatBudget\Repository\MyRepository;

class MyService
{
    /**
     * @var MyRepository
     */
    private $myRepository;

    public function __construct(MyRepository $myRepository)
    {
        $this->myRepository = $myRepository;
    }

    public function getAll()
    {
        return $this->myRepository->findAll();
    }

    public function getRepo()
    {
        return $this->myRepository;
    }

    public function getList()
    {
        return array_map(function ($my) {
            return $this->myRepository->extract($my);
        }, $this->getAll());
    }
    
    public function saveRow(array $row)
    {
        $my = false;
        if (isset($row['id'])) {
            $my = $this->myRepository->find($row['id']);
        }
        if (!$my) {
            $my = new My();
        }
        $my = $this->myRepository->hydrate($my, $row);
        $this->myRepository->save($my);
        return $this->myRepository->extract($my);
    }

    public function deleteRow(array $row)
    {
        if (!isset($row['id'])) {
            throw new \InvalidArgumentException('$entity should contain ID key for delete action');
        }
        $my = $this->myRepository->find($row['id']);
        $this->myRepository->delete($my);
    }
}
