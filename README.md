TOCAT App
=======================
[![Build Status](https://travis-ci.org/opsway/tocat.svg)](https://travis-ci.org/opsway/tocat)
[![Coverage Status](https://coveralls.io/repos/opsway/tocat/badge.png)](https://coveralls.io/r/opsway/tocat)
Introduction
------------
Theory of Constraints Accounting for Teams (TOCAT) provide UI and API for management budgets.
TOCAT Platform based on Zend Framework 2 and it modules.

Unstable application, development process...

Installation
------------

Create MySQL/PostgresSQL database:
```sql
CREATE DATABASE tocat;
```

 - Clone source 
 - Run composer install
 - Run bower install
 - Run install & update application and follow instruction in console
```bash
git clone git@github.com:opsway/tocat.git
cd tocat
php composer.phar install
bower install
php public/index.php app install && php public/index.php app update
```

If you need OneLogin write setting in config/autoload/local/onelogin.local.php file.
Or use email/password access to site provide by default: admin@test.com / admin123
Enjoy!

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
