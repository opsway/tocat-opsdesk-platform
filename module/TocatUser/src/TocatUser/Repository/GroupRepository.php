<?php

namespace TocatUser\Repository;

use TocatCore\Library\Traits\DoctrineHydratorAwareInterface;
use TocatCore\Library\Traits\DoctrineHydratorAwareTrait;
use Doctrine\ORM\EntityRepository;
use TocatUser\Entity\Group as GroupEntity;

/**
 *  @method null|GroupEntity find($id, $lockMode = \Doctrine\DBAL\LockMode::NONE, $lockVersion = null)
 */
class GroupRepository extends EntityRepository implements DoctrineHydratorAwareInterface
{
    use DoctrineHydratorAwareTrait;

    /**
     * @return groupEntity
     */
    public function createNewEntity()
    {
        return new GroupEntity();
    }

    /**
     * @param groupEntity $groupEntity
     * @param array      $data
     *
     * @return groupEntity
     */
    public function hydrate(GroupEntity $groupEntity, array $data)
    {
        return $this->getHydrator()->hydrate($data, $groupEntity);
    }

    /**
     * @param groupEntity $groupEntity
     *
     * @return array
     */
    public function extract(GroupEntity $groupEntity)
    {
        return $this->getHydrator()->extract($groupEntity);
    }

    /**
     * @param groupEntity $groupEntity
     * @param bool       $flush
     */
    public function save(GroupEntity $groupEntity, $flush = true)
    {
        $this->getEntityManager()->persist($groupEntity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param groupEntity $groupEntity
     * @param bool       $flush
     */
    public function delete(GroupEntity $groupEntity, $flush = true)
    {
        $this->getEntityManager()->remove($groupEntity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
