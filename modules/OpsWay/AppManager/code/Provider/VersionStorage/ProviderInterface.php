<?php

namespace OpsWay\AppManager\Provider\VersionStorage;

interface ProviderInterface
{
    public function getVersions();
    public function setVersions(array $versions);
}
