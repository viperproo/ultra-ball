var selected_class = 'selected',
    selected_option_selector = '.setting-option';

function OptionClick() {
  $(selected_option_selector).on('click', function () {
    var button = $(this);
    if(! (button.hasClass(selected_class) || button.hasClass('disable'))){
      ChangeOption(button);
    }
  });
}

function ChangeOption(button) {

  $(selected_option_selector).off('click');
  
  var value = button.index(),
      cookie = button.parent().prev().data('name'),
      div = $(InfoContainer()),
      fs = fsContainer;

  AddSpin(fs.div, true);
  fs.div.addClass(fs.className);
  
  $.ajax({
    url: "PHP/cookie-edit.php",
    method: "POST",
    data: {
      cookie_name: cookie,
      value: value
    },
    datatype: "text",
    success: function (data) {
      button.parent().children().removeClass(selected_class);
      button.addClass(selected_class);
      PageReload();
    },
    complete: function () {
      OptionClick();
      fs.div.removeClass(fs.className);
      RemoveSpin(fs.div);
    }
  });
}

$(document).ready(OptionClick);