//function ResultContainer() {
//  var container = document.createelement('div'),
//      title_container = document.createelement('h1'),
//      title = document.createelement('span'),
//      amount = document.createelement('span'),
//      result = document.createelement('div');
//  
//  title.innerHTML = 'Pokemony: ';
//  amount.setAttribute('id', 'search-items-amount');
//  amount.classList.add('items-amount');
//  title_container.classList.add('result-title', 'title');
//  title_container.appendChild(title);
//  title_container.appendChild(amount);
//  result.setAttribute('id', 'result');
//  container.setAttribute('id', 'result-container');
//}

function ResultContainerSelector() {
  return '#result-container';
}

function ResultSelector() {
  return '#result';
}

function InputElement() {
  return $("#main-search");
}

function BodyResultClass() {
  return 'show-search-result';
}

function NullField() {
  $(ResultSelector()).html(null);
  $("#search-items").html(0);
}

function FocusSearch() {
  InputElement().focus();
}

function SearchResultToggle() {
  var body = $('body'),
      class_name = BodyResultClass();
  
  body.toggleClass(class_name);

  if(! body.hasClass(class_name)){
    InputElement().val(null);
    NullField();
  }
}

function SearchBarToggle() {
  $('#page-header').toggleClass('search-bar');  
}

function GetResult(object) {
  var container = $(ResultContainerSelector());    
  if(container.length){
    var val = object.val(),
        result_div = $(ResultSelector()),
        items_amount = $("#search-items"),
        div = $(InfoContainer());
    
    RemoveInfoContainer();
    items_amount.html(Spinner());

    if(val){

      $.ajax({
        url: "pokedex.php",
        method: "POST",
        datatype: "text",
        data: {
          val: val
        },
        success: function (result) {
          result_div.html(result);
        },
        error: function () {
          result_div.html(div);
          div.html(ErrorDiv('Wyszukiwanie nie powiodło się'));
        },
        complete: function () {
          items_amount.html($(ResultContainerSelector() + ' .pokemon-div').length);
        }
      });

    }else{
      NullField();
    }
  }
}

$(document).ready(function () {
  $("#search-button").on("click", SearchBarToggle);
  $("#result-button").on("click", SearchResultToggle);
  $("#search-icon").on("click", FocusSearch);

  InputElement().on('input', function () {
    GetResult($(this));
  });
  
  $('.filter-checkbox').on('change', function () {
    GetResult($(this));
  });
  
  $(window).on('keydown', function (ev) {
    if(ev.keyCode === 13 && ! $('body').hasClass(BodyResultClass())){
      SearchResultToggle();
    }else if(ev.keyCode === 27 && $('body').hasClass(BodyResultClass())){
      SearchResultToggle();
    }
  });
});
