MARKETING PLACE CRM - GROWTHMIPYMES
============================

Management and Marketing

STRUCTURE
-------------------

      Information Company/    contains Company Information
      Marketing Plan/         contains marketin plan
      Accions Plan/           contains accions plan
      Customers/              contains managment customers
      Evaluation/             contains reports
      

REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Install from an Archive File

Extract the archive file downloaded from here.

You can then access the application through the following URL:

~~~
http://localhost/marquetingplace/web/
~~~


CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=namemarketingplace',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTES:**
- Marketingplace won't create the database for you, this has to be done manually before you can access it.
- Check and edit the other files in the `config/` directory to customize your application as required.
- Refer to the README in the `tests` directory for information specific to basic application tests.
