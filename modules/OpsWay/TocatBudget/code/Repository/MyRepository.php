<?php

namespace OpsWay\TocatBudget\Repository;

use OpsWay\TocatCore\Library\Traits\DoctrineHydratorAwareInterface;
use OpsWay\TocatCore\Library\Traits\DoctrineHydratorAwareTrait;
use Doctrine\ORM\EntityRepository;
use OpsWay\TocatBudget\Entity\Issue as IssueEntity;

/**
 *  @method null|IssueEntity find($id, $lockMode = \Doctrine\DBAL\LockMode::NONE, $lockVersion = null)
 */
class MyRepository extends EntityRepository implements DoctrineHydratorAwareInterface
{
    use DoctrineHydratorAwareTrait;

    /**
     * @return issueEntity
     */
    public function createNewEntity()
    {
        return new IssueEntity();
    }

    /**
     * @param issueEntity $issueEntity
     * @param array      $data
     *
     * @return issueEntity
     */
    public function hydrate(IssueEntity $issueEntity, array $data)
    {
        return $this->getHydrator()->hydrate($data, $issueEntity);
    }

    /**
     * @param issueEntity $issueEntity
     *
     * @return array
     */
    public function extract(IssueEntity $issueEntity)
    {
        return $this->getHydrator()->extract($issueEntity);
    }

    /**
     * @param issueEntity $issueEntity
     * @param bool       $flush
     */
    public function save(IssueEntity $issueEntity, $flush = true)
    {
        $this->getEntityManager()->persist($issueEntity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param issueEntity $issueEntity
     * @param bool       $flush
     */
    public function delete(IssueEntity $issueEntity, $flush = true)
    {
        $this->getEntityManager()->remove($issueEntity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
