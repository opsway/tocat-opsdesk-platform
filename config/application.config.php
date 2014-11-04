<?php
$config = array(
    'modules' => array(
       'ZF\DevelopmentMode',
        'ZF\Apigility',
        'ZF\Apigility\Provider',
        'ZF\Apigility\Documentation',
        'AssetManager',
        'ZF\ApiProblem',
        'ZF\Configuration',
        'ZF\MvcAuth',
        'ZF\OAuth2',
        'ZF\Hal',
        'ZF\ContentNegotiation',
        'ZF\ContentValidation',
        'ZF\Rest',
        'ZF\Rpc',
        'ZF\Versioning',
        'ZendDeveloperTools',
        'DoctrineModule',
        'DoctrineORMModule',
        'ZfcBase',
        'ZfcUser',
        'ZfcUserDoctrineORM',
        'BjyAuthorize',
        'ZfcUserOnelogin',
        'ZfcAdmin',
        'ZfcUserAdmin',
        'OpsWay\TocatCore',
        'OpsWay\TocatApi',
        'OpsWay\TocatUser',
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './modules',
            './vendor'
        ),
        'config_glob_paths' => array(
            'config/autoload/global/{,*.}{global,local}.php',
            'config/autoload/local/{,*.}{global,local}.php',
            'config/autoload/{,*.}{global,local}.php',
        ),
        'config_cache_key' => 'application.config.cache',
        'config_cache_enabled' => false,
        'module_map_cache_key' => 'application.module.cache',
        'module_map_cache_enabled' => false,
        'cache_dir' => 'data/cache/'
    )
);
//todo Delete this hack after update BjyAuthorize module to 2.0
if (Zend\Console\Console::isConsole()) {
    array_splice($config['modules'],array_search('BjyAuthorize',$config['modules']),1);
}
return $config;
