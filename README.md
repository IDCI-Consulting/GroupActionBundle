# GroupActionBundle

A symfony bundle to create/run grouped actions.

Installation
------------

Add dependencies in your `composer.json` file:
```json
"require": {
    ...
     "idci/group-action-bundle": "~1.0"
},
```

Install these new dependencies in your application using composer:
```sh
$ php composer.phar update
```

Register needed bundles in your application kernel:
```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new IDCI\Bundle\GroupActionBundle\IDCIGroupActionBundle(),
    );
}
```

Import the bundle configuration:
```yml
# app/config/config.yml

imports:
    - { resource: '@IDCIGroupActionBundle/Resources/config/config.yml' }
```

That's it, you are ready to use the bundle.

Usage
-----

* Use groupaction in your controller
* Create your own group action service
