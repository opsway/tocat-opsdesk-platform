<?php

namespace OpsWay\TocatUser\Repository;

use OpsWay\TocatCore\Library\Traits\DoctrineHydratorAwareInterface;
use OpsWay\TocatCore\Library\Traits\DoctrineHydratorAwareTrait;
use Doctrine\ORM\EntityRepository;
use OpsWay\TocatUser\Entity\Permission as PermissionEntity;

/**
 *  @method null|PermissionEntity find($id, $lockMode = \Doctrine\DBAL\LockMode::NONE, $lockVersion = null)
 */
class PermissionRepository extends EntityRepository implements DoctrineHydratorAwareInterface
{
    use DoctrineHydratorAwareTrait;

    /**
     * @return permissionEntity
     */
    public function createNewEntity()
    {
        return new PermissionEntity();
    }

    /**
     * @param permissionEntity $permissionEntity
     * @param array      $data
     *
     * @return permissionEntity
     */
    public function hydrate(PermissionEntity $permissionEntity, array $data)
    {
        return $this->getHydrator()->hydrate($data, $permissionEntity);
    }

    /**
     * @param permissionEntity $permissionEntity
     *
     * @return array
     */
    public function extract(PermissionEntity $permissionEntity)
    {
        return $this->getHydrator()->extract($permissionEntity);
    }

    /**
     * @param permissionEntity $permissionEntity
     * @param bool       $flush
     */
    public function save(PermissionEntity $permissionEntity, $flush = true)
    {
        $this->getEntityManager()->persist($permissionEntity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param permissionEntity $permissionEntity
     * @param bool       $flush
     */
    public function delete(PermissionEntity $permissionEntity, $flush = true)
    {
        $this->getEntityManager()->remove($permissionEntity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
