# Display the group action form in the view

Two Twig functions are available :
* `add_group_action_checkbox` : Add a checkbox input for a specific data.

To display the group action form view, do as the following :

```twig
 {{ form_start(groupActionForm) }}
<table class="table table-hover">
    <thead>
        <tr>
            <th><input type="checkbox" onchange="handleCheckboxes(this)" name="chk[]"/></th>
            <th>{% trans %}Id{% endtrans %}</th>
            <th>{% trans %}Name{% endtrans %}</th>
        </tr>
    </thead>
    <tbody>
    {% for data in my_data %}
        <tr>
            <td>{{ add_group_action_checkbox(loop.index) }}</td>
            <td>{{ data.id }}</td>
            <td>{{ data.name }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{{ form_end(groupActionForm) }}
```
