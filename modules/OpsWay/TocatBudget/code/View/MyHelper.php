<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link    https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */

namespace OpsWay\TocatBudget\View;

use Zend\View\Helper\AbstractHelper;

class MyHelper extends AbstractHelper
{
    protected $count = 0;

    public function __invoke($count = null)
    {
        if (!is_null($count)) {
            $this->count = $count;
        }
        $this->count++;
        $output = sprintf("I have seen 'The Jerk' %d time(s).", $this->count);
        $escaper = $this->getView()->plugin('escapehtml');
        return $escaper($output);
    }
}
