<?php
namespace OpsWay\TocatCore\Service;

use Zend\Navigation\Service;

class TopNavigationFactory extends Service\AbstractNavigationFactory
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'top_nav';
    }
}
