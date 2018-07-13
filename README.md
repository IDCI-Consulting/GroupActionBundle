# GroupActionBundle

This Symfony bundle allows to run an action on several `abstract` data type (array, entities, documents, ...) throught a form.
The purpose is to give a simple way to create actions and display a form.

* Introduction(#introduction)
    * Glossary
    * UML Schema
* Installation(#installation)
* How to create a group action
* How to create a group action form
* How to define group actions throught namespaces
* Example

Introduction
------------

### Glossary

* A **group action** is a Symfony service that will do any work you want. It will run a sequence of intructions on a dataset.

### UML Schema

![Simple schema](Resources/doc/images/uml.png)

Installation
------------

Add dependencies in your `composer.json` file:
```json
"require": {
    ...
     "idci/group-action-bundle": "~2.0"
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

That's it, you are ready to use the bundle.

TODO
----

* Testing the bundle.
* Add continious integration.
