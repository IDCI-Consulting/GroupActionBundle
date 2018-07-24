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

How to use
----------

Build the form in your controller :

```php
// By namespace
$groupActionForm = $this->get('idci.group_action.manager')->createForm(array(
    'namespace' => 'your_namespace',
    'submit_button_options' => array('attr' => array(
        'class' => 'btn',
    )),
));

// By actions
$groupActionForm = $this->get('idci.group_action.manager')->createForm(array(
    'actions' => array(
        'action_1',
        'action_2',
        ...
    ),
    'submit_button_options' => array('attr' => array(
        'class' => 'btn',
    )),
));
```
Executing the submitted form :

```php
if ($this->get('idci.group_action.manager')->hasAction($request)) {
    $result = $this->get('idci.group_action.manager')->execute(
        $request,
        $groupActionForm,
        $yourData
    );

    if ($result instanceof Response) {
        return $result;
    }

    // Redirect to your route
    return $this->redirect($this->generateUrl('your_route'));
}
```

TODO
----

* Testing the bundle.
* Add continious integration.
