var scrolledEl,
    contentContainer,
    loadBtn;

function LoadContentButton() {
  var div = document.createElement('div'),
      button = document.createElement('button'),
      text = document.createTextNode('Załaduj');
  
  button.setAttribute('id', 'load-content');
  button.classList.add('page-button');
  button.addEventListener('click', function () {
    LoadContent(1);
  });
  button.appendChild(text);
  div.appendChild(button);
  
  return div;
}

function addLoadButton(object) {
  if(scrolledEl.prop("clientHeight") >= scrolledEl.prop("scrollHeight")){
     object.append(LoadContentButton());
  }
}

function LoadContent(limit) {

  if(document.readyState === 'complete'){

    var load_selector = '[data-load]',
        input = $(load_selector),
        lastid = input.data('load'),
        fs = fsContainer,
        div = $(InfoContainer()),
        end = false,
        error = true;

    scrolledEl.off('scroll', LoadOnScroll);
    loadBtn.off('click');
    RemoveInfoContainer();
    contentContainer.append(div);
    AddSpin(div, true);
    
    if(! limit){
      AddSpin(fs.div, true);
      fs.div.addClass(fs.className);
    }

    $.ajax({
      url: window.location.href,
      datatype: 'text',
      method: 'POST',
      data: {
        limit: limit,
        lastid: lastid
      },
      success: function (result) {
        input.remove();
        contentContainer.append(result);
        div.remove();
        if($(load_selector).data('load') === false){
          end = true;
        }
        error = false;
      },
      error: function () {
        AddError(div, 'Nie udało się załadować zawartości');
        div.append(LoadContentButton());
      },
      complete: function () {
        RemoveSpin(div);
        if(! limit){
          fs.div.removeClass(fs.className);
          setTimeout(function () {
            RemoveSpin(fs.div);
          }, 350);
        }
        if(end){
          loadBtn.addClass('hidden');

          setTimeout(function () {
            loadBtn.remove();
          }, 1000);
        }else{
          ClickLoadEvents();
          if(! error){
            ScrollLoadEvent();
          }
        }
      }
    });

  }

}

function LoadOnScroll() {
  if(scrolledEl.scrollTop() + scrolledEl.height() >= contentContainer.height()){
    LoadContent(1);
  }
}

function ScrollLoadEvent() {
  scrolledEl.on('scroll', LoadOnScroll);
}

function ClickLoadEvents() {
  loadBtn.on('click', function () {
    LoadContent(0);
  });
}

$(document).ready(function () {
  scrolledEl = mainContainer;
  contentContainer = $("#main-content");
  loadBtn = $('#load-button');
  ScrollLoadEvent();
  ClickLoadEvents();
});

// NEW

//var scrolledEl,
//    contentContainer,
//    infoContainer,
//    loadBtn;
//
//function LoadContentButton() {
//  var div = document.createElement('div'),
//      button = document.createElement('button'),
//      text = document.createTextNode('Pokaż więcej');
//  
//  button.setAttribute('id', 'load-content');
//  button.classList.add('page-button');
//  button.addEventListener('click', function () {
//    LoadContent(1);
//  });
//  button.appendChild(text);
//  div.appendChild(button);
//  
//  return div;
//}
//
//function noScroll() {
//  if(scrolledEl.prop("clientHeight") >= scrolledEl.prop("scrollHeight")){
//    return true;
//  }
//  return false;
//}
//
//function LoadContent(limit) {
//
//  if(document.readyState === 'complete'){
//
//    var load_selector = '[data-load]',
//        input = $(load_selector),
//        lastid = input.data('load'),
//        fs = fsContainer,
//        div = infoContainer,
//        end = false,
//        error = true;
//
//    scrolledEl.off('scroll', LoadOnScroll);
//    loadBtn.off('click');
//    RemoveInfoContainer();
//    contentContainer.append(div);
//    AddSpin(div, true);
//    
//    if(! limit){
//      AddSpin(fs.div, true);
//      fs.div.addClass(fs.className);
//    }
//
//    $.ajax({
//      url: window.location.href,
//      datatype: 'text',
//      method: 'POST',
//      data: {
//        limit: limit,
//        lastid: lastid
//      },
//      success: function (result) {
//        input.remove();
//        contentContainer.append(result);
//        if(noScroll()){
//          div.html(LoadContentButton());
//        }else{
//          div.remove();
//        }
//        if($(load_selector).data('load') === false){
//          end = true;
//        }
//        error = false;
//      },
//      error: function () {
//        AddError(div, 'Nie udało się załadować zawartości');
//        div.append(LoadContentButton());
//      },
//      complete: function () {
//        RemoveSpin(div);
//        if(! limit){
//          fs.div.removeClass(fs.className);
//          setTimeout(function () {
//            RemoveSpin(fs.div);
//          }, 350);
//        }
//        if(end){
//          loadBtn.addClass('hidden');
//
//          setTimeout(function () {
//            loadBtn.remove();
//          }, 1000);
//        }else{
//          ClickLoadEvents();
//          if(! error){
//            ScrollLoadEvent();
//          }
//        }
//      }
//    });
//
//  }
//
//}
//
//function LoadOnScroll() {
//  if(scrolledEl.scrollTop() + scrolledEl.height() >= contentContainer.height()){
//    LoadContent(1);
//  }
//}
//
//function ScrollLoadEvent() {
//  scrolledEl.on('scroll', LoadOnScroll);
//}
//
//function ClickLoadEvents() {
//  loadBtn.on('click', function () {
//    LoadContent(0);
//  });
//}
//
//$(document).ready(function () {
//  scrolledEl = mainContainer;
//  contentContainer = $("#main-content");
//  infoContainer = $(InfoContainer());
//  loadBtn = $('#load-button');
//  ScrollLoadEvent();
//  ClickLoadEvents();
//  if(noScroll()){
//    var div = infoContainer;
//    div.html(LoadContentButton());
//    contentContainer.append(div);
//  }
//});