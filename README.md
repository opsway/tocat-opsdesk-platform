TOCAT App
=======================

Introduction
------------
Theory of Constraints Accounting for Teams (TOCAT) provide UI and API for managment budgets.

https://github.com/opsway/tocat/wiki/TODO-list

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
    'db' => array(
        'adapters' => array(
            'dbBase' => array(
                'driver' => 'Pdo_Mysql',
                'database' => 'tocat',
                'username' => 'user',
                'password' => 'password',
                'charset' => 'utf8',
            ),
        ),
    ),
);
```

Run migration sql files in folder "migrations/".

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
