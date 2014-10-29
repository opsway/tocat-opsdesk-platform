TOCAT App
=======================
[![Build Status](https://travis-ci.org/opsway/tocat.svg)](https://travis-ci.org/opsway/tocat)
[![Coverage Status](https://coveralls.io/repos/opsway/tocat/badge.png)](https://coveralls.io/r/opsway/tocat)
Introduction
------------
Theory of Constraints Accounting for Teams (TOCAT) provide UI and API for managment budgets.

Unstable application, development process...

Installation
------------

Cloning source and run composer
```bash
git clone git@github.com:opsway/tocat.git
cd tocat
php composer.phar install
```

Rename config/autoload/local.php.dist to local.php and write access to DB like:
```php
<?php
return array(
    'doctrine' => array(
            'connection' => array(
                'orm_default' => array(
                    'driverClass' =>'Doctrine\DBAL\Driver\PDOMySql\Driver',
                    'params' => array(
                        'host'     => 'localhost',
                        'port'     => '3306',
                        'user'     => 'root',
                        'password' => 'password',
                        'dbname'   => 'tocat',
                    )
                )
            ),
            'entity_resolver' => array(
                    'orm_default' => array()
                ),
    ),
);
```

Create database and run doctrine update scheme:
```bash
./vendor/bin/doctrine-module orm:schema-tool:update --force
```

### Development

If you want see Apigility Admin, you need to put it in development mode

```bash
cd path/to/install
php public/index.php development enable # put the skeleton in development mode
```

Run build-in web-server in PHP5.4+

```bash
cd path/to/install
php -S 0.0.0.0:8080 -t public public/index.php
```


### Documentation

Build-in in application by URL "http://[TOCAT-URL]/apigility/documentation"
