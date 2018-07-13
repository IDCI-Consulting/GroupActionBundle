'use strict';

function handleCheckboxes(element) {
    if (!document.forms['idci_group_action']) {
        return;
    }

    var checkboxes = document.forms['idci_group_action'].getElementsByTagName('input');

    if (element.checked) {
      console.log('checked');
        checkAll(checkboxes);
    } else {
        uncheckAll(checkboxes);
    }
}

function checkAll(elements) {
    for (var i = 0; i < elements.length; i++) {
        if (elements[i].type == 'checkbox') {
            elements[i].checked = true;
        }
    }
}

function uncheckAll(elements) {
    for (var i = 0; i < elements.length; i++) {
        if (elements[i].type == 'checkbox') {
            elements[i].checked = false;
        }
    }
}
