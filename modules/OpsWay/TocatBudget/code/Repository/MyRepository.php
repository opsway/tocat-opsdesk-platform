<?php

namespace OpsWay\TocatBudget\Repository;

use OpsWay\TocatCore\Library\Traits\DoctrineHydratorAwareInterface;
use OpsWay\TocatCore\Library\Traits\DoctrineHydratorAwareTrait;
use Doctrine\ORM\EntityRepository;
use OpsWay\TocatBudget\Entity\My as MyEntity;

/**
 *  @method null|MyEntity find($id, $lockMode = \Doctrine\DBAL\LockMode::NONE, $lockVersion = null)
 */
class MyRepository extends EntityRepository implements DoctrineHydratorAwareInterface
{
    use DoctrineHydratorAwareTrait;

    /**
     * @return myEntity
     */
    public function createNewEntity()
    {
        return new MyEntity();
    }

    /**
     * @param myEntity $myEntity
     * @param array      $data
     *
     * @return myEntity
     */
    public function hydrate(MyEntity $myEntity, array $data)
    {
        return $this->getHydrator()->hydrate($data, $myEntity);
    }

    /**
     * @param myEntity $myEntity
     *
     * @return array
     */
    public function extract(MyEntity $myEntity)
    {
        return $this->getHydrator()->extract($myEntity);
    }

    /**
     * @param myEntity $myEntity
     * @param bool       $flush
     */
    public function save(MyEntity $myEntity, $flush = true)
    {
        $this->getEntityManager()->persist($myEntity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param myEntity $myEntity
     * @param bool       $flush
     */
    public function delete(MyEntity $myEntity, $flush = true)
    {
        $this->getEntityManager()->remove($myEntity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
