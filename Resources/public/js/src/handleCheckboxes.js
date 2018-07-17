export default {
  handleCheckboxes: function(element) {
    if (!document.forms['idci_group_action']) {
      console.warn('The "idci_group_action" was not found !');

      return;
    }

    var checkboxes = document.forms['idci_group_action'].getElementsByTagName('input');

    if (element.checked) {
      checkAll(checkboxes);
    } else {
      uncheckAll(checkboxes);
    }
  },

  checkAll: function(elements) {
    for (var i = 0; i < elements.length; i++) {
      if (elements[i].type == 'checkbox') {
        elements[i].checked = true;
      }
    }
  },

  uncheckAll: function (elements) {
    for (var i = 0; i < elements.length; i++) {
      if (elements[i].type == 'checkbox') {
        elements[i].checked = false;
      }
    }
  }
}
