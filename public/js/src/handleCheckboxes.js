function handleCheckboxes(element) {
  let checkboxes = [];

  let forms = Array.from(document.forms);
  forms.forEach(function (form) {
    form.querySelectorAll('input[name*=group_action]').forEach(function (checkbox) {
      checkboxes.push(checkbox)
    });
  });

  if (element.checked) {
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

export {
  handleCheckboxes,
  checkAll,
  uncheckAll
}
