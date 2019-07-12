var scrollUpBtn,
    mainContainer,
    menuCheckbox,
    fsContainer,
    menuBtnSelector = '#menu-button',
    loadingDivSelector = 'loading',
    errorDivSelector = 'info-container-div';

function Spinner(div) {
  var loading = document.createElement("div"),
      icon = document.createElement("span");

  loading.classList.add(loadingDivSelector);
  icon.classList.add("icon-spin4", "animate-spin");
  loading.appendChild(icon);

  if(typeof div != 'undefined'){
    return loading;
  }
  return icon;
}

function ErrorDiv(error) {
  var container = document.createElement("div"),
      error_header = document.createElement("h1"),
      error_text = 'Wystąpił błąd';

  error_header.classList.add("info-header", "color-red");
  if(error){
    error_text = error;
  }
  
  error_header.innerHTML = error_text;

  container.classList.add(errorDivSelector);
  container.appendChild(error_header);

  return container;
}

function AddSpin(element, div) {
  element.append(Spinner(div));
}

function AddError(element, error) {
  element.append(ErrorDiv(error));
}

function RemoveSpin(element) {
  element.children('.' + loadingDivSelector).remove();
}

function RemoveError(element) {
  element.children('.' + errorDivSelector).remove();
}

function InfoContainer() {
  var div = document.createElement('div');
  div.setAttribute('id', 'info-container');
  
  return div;
}

function RemoveInfoContainer() {
  $('#info-container').remove();
}

function PageReload() {
  window.location.reload();
}

// Scrolling

function ScrollUpButtonToggle() {
  if(mainContainer.scrollTop() > 0){
    scrollUpBtn.removeClass("hidden");
  }else{
    scrollUpBtn.addClass("hidden");
  }
}

function ScrollUp() {
  scrollUpBtn.off("click", ScrollUp);

  if($("body").hasClass("anim")){
    mainContainer.animate({
      scrollTop: 0
    }, 300);
  }else{
    mainContainer.scrollTop(0);
  }

  scrollUpBtn.on("click", ScrollUp);
}

// Menu

function MenuTop() {
  return mainContainer.hasClass("menu-top") || $(window).width() < 1300;
}

function MenuPosition() {
  var menu = $("#page-menu"),
      menu_position = ["left", "right"],
      margin,
      margin_value = 0;
  
  for(var x = 0; x < menu_position.length; x++){
    if($("body").hasClass("menu-" + menu_position[x])){
      margin = menu_position[x];      
      break;
    }
  }
  
  if(! MenuTop() && menuCheckbox.checked === true){
    margin_value = menu.width();      
  }
  
  mainContainer.css("margin-" + margin, margin_value + "px");  
}

function MenuBehavior(click) {
  var checkbox;
  
  if(MenuTop()){
    checkbox = false;
  }else{
    if(click){
      checkbox = menuCheckbox.checked;
    }else{
      checkbox = true;
    }
  }
  
  menuCheckbox.checked = checkbox;
  MenuPosition();
}

// Tooltips

var tooltip = false;

function RemoveTooltip(element, className) {
  tooltip = false;
  element.parent().removeClass(className);
}

function Tooltips() {
  var tooltipContainer = $('.tooltip-container'),
      className = 'tooltip-visible',
      selector = '*:first-child';
  tooltipContainer.on('mouseover', selector, function () {
    var button = $(this);
    tooltip = button;
    setTimeout(function () {
      if(tooltip === button){
        button.parent().addClass(className);
      }
    }, 500);
  });
  tooltipContainer.on('mouseleave', selector, function () {
    RemoveTooltip($(this), className);
  });
  tooltipContainer.on('click', selector, function () {
    RemoveTooltip($(this), className);
  });
}

// Cookies Info

function CookiesInfo() {  
  var cookie_button = $("#cookie-div-close-button");
  
  if(cookie_button.length > 0){
    var cookie_info = $("#cookies-info-div");
    cookie_button.on("click", function () {
      cookie_info.addClass('removed');
      setTimeout(function () {
        cookie_info.remove();
      }, 1000);
    });
  }
}

$(document).ready(function () {
  scrollUpBtn = $("#scroll-up-button");
  mainContainer = $("#page-content-container");
  menuCheckbox = document.querySelector("#menu-toggle");
  fsContainer = {
    div: $('#fs-container'),
    className: 'visible'
  };
  
  MenuBehavior(false);
  ScrollUpButtonToggle();
  CookiesInfo();
  Tooltips();

  $(document).on('click', function (ev) {
    if(ev.target != menuCheckbox && ev.target.closest(menuBtnSelector) != document.querySelector(menuBtnSelector)){
      MenuBehavior(true);
    }
  });
  mainContainer.on('scroll', ScrollUpButtonToggle);
  scrollUpBtn.on('click', ScrollUp);
  menuCheckbox.addEventListener('change', MenuPosition);
});

$(window).on("resize", function () {
  ScrollUpButtonToggle();
  MenuBehavior(false);
});
