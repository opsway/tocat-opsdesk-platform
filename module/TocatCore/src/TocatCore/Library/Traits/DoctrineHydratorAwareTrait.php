<?php

namespace TocatCore\Library\Traits;

use Zend\Stdlib\Hydrator\HydratorInterface;

trait DoctrineHydratorAwareTrait
{
    /**
     * @var HydratorInterface;
     */
    protected $hydrator;

    public function setHydrator(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * @return HydratorInterface
     * @throws \LogicException
     */
    protected function getHydrator()
    {
        if (!$this->hydrator) {
            throw new \LogicException('Hydrator has not been injected!');
        }

        return $this->hydrator;
    }

}
