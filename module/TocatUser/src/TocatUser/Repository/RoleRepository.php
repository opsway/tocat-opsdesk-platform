<?php

namespace TocatUser\Repository;

use TocatCore\Library\Traits\DoctrineHydratorAwareInterface;
use TocatCore\Library\Traits\DoctrineHydratorAwareTrait;
use Doctrine\ORM\EntityRepository;
use TocatUser\Entity\Role as RoleEntity;

class RoleRepository extends EntityRepository implements DoctrineHydratorAwareInterface
{
    use DoctrineHydratorAwareTrait;

    /**
     * @return RoleEntity
     */
    public function createNewEntity()
    {
        return new RoleEntity();
    }

    /**
     * @param RoleEntity $RoleEntity
     * @param array      $data
     *
     * @return RoleEntity
     */
    public function hydrate(RoleEntity $RoleEntity, array $data)
    {
        return $this->getHydrator()->hydrate($data, $RoleEntity);
    }

    /**
     * @param RoleEntity $RoleEntity
     *
     * @return array
     */
    public function extract(RoleEntity $RoleEntity)
    {
        return $this->getHydrator()->extract($RoleEntity);
    }

    /**
     * @param RoleEntity $RoleEntity
     * @param bool       $flush
     */
    public function save(RoleEntity $RoleEntity, $flush = true)
    {
        $this->getEntityManager()->persist($RoleEntity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param RoleEntity $RoleEntity
     * @param bool       $flush
     */
    public function delete(RoleEntity $RoleEntity, $flush = true)
    {
        $this->getEntityManager()->remove($RoleEntity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}