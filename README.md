Test task Brights
============================


Installation
------------

### Clone project
~~~
git clone https://github.com/timoffmax/test_task_brights.git
~~~
### Install Yii2 and components

~~~
composer global require "fxp/composer-asset-plugin:^1.3.1"
composer install
~~~


Configuration connect to database
-------------

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTES:**
- Yii won't create the database for you, this has to be done manually before you can access it.


Create DB structure and load mock data
--------------------------------------
~~~
php yii migrate/up
~~~