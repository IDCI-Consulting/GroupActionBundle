# Getting The Form In The Controller

Simply call the `createForm` method of the [GroupActionManager](../src/Manager/GroupActionManager.php) in your action. Like the following :

```php
// By namespace
$groupActionForm = $this->get('idci_group_action.manager')->createForm([
    'namespace' => 'your_namespace',
]);

// By actions
$groupActionForm = $this->get('idci_group_action.manager')->createForm([
    'actions' => [
        'my_group_action_1',
        'my_group_action_2',
    ],
]);
```

The `createForm` method accepts the following parameters:


| Option | Description | Type |
| ------ | ----------- | ---- |
| `namespace` | The namespace. | `string` |
| `actions` | The group actions list. | `array` |
| `submit_button_options` | Options given to each group action submit button. | `array` |
| `form_options` | Options given to the group action form. | `array` |

To execute the group action you have to use the manager.

```php
if ($this->get('idci_group_action.manager')->hasAction($request)) {
    $result = $this->get('idci_group_action.manager')->execute($request, $groupActionForm, $elements);

    if ($result instanceof Response) {
        return $result;
    }
}
```
