# Create a Group Action

A "group action" is a Symfony service that will do any work you want. It will run a sequence of intructions on a dataset.

Create the GroupAction class
----------------------------

First you need to create a GroupAction class that extends [AbstractGroupAction](../../Action/AbstractGroupAction).
You have to implement the `execute` method.

```php
<?php

namespace My\Namespace;

use IDCI\Bundle\GroupActionBundle\Action\AbstractGroupAction;

class MyGroupAction extends AbstractGroupAction
{
    /**
     * {@inheritDoc}
     */
     public function execute(array $data)
     {
        // Your business logic with the given datasets.
     }
}
```

Register your class as a tagged service
---------------------------------------

```yml
acme.group_action.my_group_action:
    class: My\Namespace\MyGroupAction
    tags:
        - { name: idci.group_action, alias: my_group_action }
```

More
----

See the [example part](example.md) for a concrete example.
