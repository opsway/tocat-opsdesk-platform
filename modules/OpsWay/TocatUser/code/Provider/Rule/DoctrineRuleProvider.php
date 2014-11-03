<?php

namespace OpsWay\TocatUser\Provider\Rule;

use Doctrine\Common\Persistence\ObjectRepository;
use BjyAuthorize\Provider\Rule\ProviderInterface;

class DoctrineRuleProvider implements ProviderInterface
{
    const TYPE_GUARD = 'guard';
    const TYPE_RESOURCE = 'resource';
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $objectRepository;

    /**
     * @param \Doctrine\Common\Persistence\ObjectRepository $objectRepository
     */
    public function __construct(ObjectRepository $objectRepository)
    {
        $this->objectRepository = $objectRepository;
    }

    /**
     * Here we read rules from DB and put them into an a form that BjyAuthorize's Controller.php understands
     *
     * @param string $type
     *
     * @return array
     */
    public function getRules($type = self::TYPE_RESOURCE)
    {
        //read from object store a set of (role, controller, action)
        $result = $this->objectRepository->findBy(['type' => $type]);

        //transform to object BjyAuthorize will understand
        $rules = array();
        foreach ($result as $key => $rule) {
            $role = $rule->getRole()->getRoleId();
            $controller = $rule->getResource();
            $action = $rule->getPrivileges();

            if (!$action) {
                $rules[$controller]['roles'][] = $role;
                $rules[$controller]['controller'] = array($controller);
            } else {
                $rules[$controller . ':' . $action]['roles'][] = $role;
                $rules[$controller . ':' . $action]['controller'] = array($controller);
                $rules[$controller . ':' . $action]['action'] = explode(',', $action);
            }
        }

        return array_values($rules);
    }
}
