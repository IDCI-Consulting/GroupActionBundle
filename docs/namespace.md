# Define group actions throught namespaces

A "namespace" is, as its name say, a namespace to defined a list of several group actions can be retrieved by the configured namespace.

This bundle allows to associate a list of group actions with a namespace. In your `config.yml` file, do the following (with your context of course).

```yml
# IDCIGroupAction
idci_group_action:
    namespaces:
        my_namespace:
            - my_group_action_1
            - my_group_action_2
            ...
```

From now, when you build the group action form with `my_namespace`, the associate group actions will be available in your view.

See [this documentation](group_action_form.md) to know how to create a group action form in your controller.
