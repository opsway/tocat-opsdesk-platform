<?php

namespace OpsWay\TocatUser\Factory\Guard;

use BjyAuthorize\Exception\InvalidArgumentException;
use OpsWay\TocatUser\Guard\DoctrineController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use OpsWay\TocatUser\Provider\Rule\DoctrineRuleProvider;

class DoctrineControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        //just setting up our config, move along move along...
        $config = $serviceLocator->get('Config');
        $config = $config['bjyauthorize'];

        //making sure we have proper entries in our config...
        //move along "nothing to see" here....
        if (!isset($config['guards']['OpsWay\TocatUser\Guard\DoctrineController'])) {
            throw new InvalidArgumentException(
                'Config for "OpsWay\TocatUser\Guard\DoctrineController" not set'
            );
        }

        $providerConfig = $config['guards']['OpsWay\TocatUser\Guard\DoctrineController'];

        //more specific checks on config
        if (!isset($providerConfig['rule_entity_class'])) {
            throw new InvalidArgumentException('rule_entity_class not set in the OpsWay\TocatUser guards config.');
        }

        if (!isset($providerConfig['object_manager'])) {
            throw new InvalidArgumentException('object_manager not set in the OpsWay\TocatUser guards config.');
        }

        /* @var $objectManager \Doctrine\Common\Persistence\ObjectManager */
        $objectManager = $serviceLocator->get($providerConfig['object_manager']);

        $orp = new DoctrineRuleProvider($objectManager->getRepository($providerConfig['rule_entity_class']));
        $rules = $orp->getRules(DoctrineRuleProvider::TYPE_GUARD);

        return new DoctrineController($rules, $serviceLocator);
    }
}
