<?php

namespace TocatCore\Library\Traits;

use Zend\Stdlib\Hydrator\HydratorInterface;

interface DoctrineHydratorAwareInterface
{
    public function setHydrator(HydratorInterface $hydrator);

    public function getHydrator();
}
