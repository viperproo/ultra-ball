(function () {
  
  // Config
  
  var scrollable_elements_class = 'scrollable',
      scrollbar_class = 'scrollbar',
      axis_class = 'axis-',
      slider_class = 'scrollbar-slider',
      scrolling_class = 'scrolling';
  
  // Code

  var html = document.querySelector('html'),
      grabPointX = false,
      grabPointY = false,
      scrollbar = false,
      s_element = false,
      y_position = false,
      x_position = false,
      ax = 'x',
      ay = 'y',
      x_axis = axis_class + ax,
      y_axis = axis_class + ay,
      checking,
      scrolling = false;
  
  function start_checking() {
    checking = window.setInterval(function () {
      check_scrollbars();
    }, 10);
  }
  
  function stop_checking() {
    clearInterval(checking);
  }

  function scrollBar(axis) {
    if(axis === ax || axis === ay){
      var scrollbar = document.createElement('div'),
          slider = document.createElement('div');

      scrollbar.classList.add(scrollbar_class, axis_class + axis);
      slider.classList.add(slider_class);

      scrollbar.appendChild(slider);

      return scrollbar;
    }
  }
  
  function has_class(element, className) {
    return element.classList.contains(className);
  }
  
  function overflowX(element) {
    return element.clientWidth < element.scrollWidth;
  }
  
  function overflowY(element) {
    return element.clientHeight < element.scrollHeight;
  }

  function closestscrollableElement(element) {
    while((! has_class(element, scrollable_elements_class) || (has_class(element, scrollable_elements_class) && ! (overflowX(element) || overflowY(element)))) && (element = element.parentElement));
    return element;
  }

  function element_scrollbar(element, axis) {
    if(element != null){
      var children = element.children;
      for(var x = children.length - 1; x >= 0; x--){
        if(has_class(children[x], scrollbar_class) && has_class(children[x], axis_class + axis)){
          return children[x];
        }
      }
    }
    return null;
  }
  
// t: current time/currnet step
// b: starting position
// c: amount of change (end - start)
// d: total animation time/steps
  
  function easeOutQuad(t, b, c, d) {
    return -c *(t/=d)*(t-2) + b;
  }
  
  function easeOutCubic(t, b, c, d) {
    return c*((t=t/d-1)*t*t + 1) + b;
  }
  
  function easeInOut(t, b, c, d) {
    if((t/=d/2) < 1) return c/2*t*t*t + b;
    return c/2*((t-=2)*t*t + 2) + b;
  }
  
  function easeOutQuart(t, b, c, d) {
    return -c * ((t=t/d-1)*t*t*t - 1) + b;
  }
  
  function easeOutCirc(t, b, c, d) {
    return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
  }
  
  function easeInOutSine(t, b, c, d) {
    return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
  }
  
  function linear_scroll_animation(element, axis, scroll_distance, duration, delay, x) {
    if(scroll_distance > 0){
      var scroll = Math.floor(scroll_distance / Math.floor(duration / delay));
      scroll_distance -= scroll;
      duration -= delay;
      window.setTimeout(function () {
        element[axis] += scroll * x;
        linear_scroll_animation(element, axis, scroll_distance, duration, delay, x)
      }, delay);
    }
  }
  
  var scroll_distance,
      starting_position,
      time,
      duration;

  function scroll(element, delta, sd, dur) {
    if(element != null){
//      stop_checking();
      var axis;
      
      if(overflowY(element)){
        axis = 'scrollTop';
      }else if(overflowX(element)){
        axis = 'scrollLeft';
      }else{
        return;
      }
      
//      var starting_position = element[axis],
//          delay = 10,
//          time = 0;
      
      var delay = 10;
      
      dur = dur || 250;
      sd = (sd || 120) * (delta < 0 ? -1 : 1);
      
      linear_scroll_animation(element, axis, 150, dur, delay, delta < 0 ? -1 : 1);
      
//      if(! scrolling){
//        scroll_distance = sd;
//        duration = dur;
//        starting_position = element[axis];
//        time = 0;
//        scrolling = window.setInterval(function () {
//          if(time < duration){
//            element[axis] = easeInOutSine(time += delay, starting_position, scroll_distance, duration);
//          }else{
//            clearInterval(scrolling);
//            scrolling = false;
//          }
//        }, delay);
//      }else{
//        scroll_distance += .5 * sd;
//        duration += .4 * dur;
//      }
      
      
//      start_checking();
    }
  }

  function XscrollBarProperties(scrollbar) {
    if(scrollbar != null){
      var element = scrollbar.parentElement,
          slider = scrollbar.children[0];
      scrollbar.style.bottom = -element.scrollTop + 'px';
      scrollbar.style.right = -element.scrollLeft + 'px';
      slider.style.width = element.clientWidth / element.scrollWidth * 100 + '%';
      slider.style.left = element.scrollLeft / element.scrollWidth * scrollbar.clientWidth + 'px';
    }
  }

  function YscrollBarProperties(scrollbar) {
    if(scrollbar != null){
      var element = scrollbar.parentElement,
          slider = scrollbar.children[0];
      scrollbar.style.right = -element.scrollLeft + 'px';
      scrollbar.style.bottom = -element.scrollTop + 'px';
      slider.style.height = element.clientHeight / element.scrollHeight * 100 + '%';
      slider.style.top = element.scrollTop / element.scrollHeight * scrollbar.clientHeight + 'px';
//      element.style.paddingRight = "";
//      console.log(window.getComputedStyle(element).getPropertyValue("padding-left"), window.getComputedStyle(element).getPropertyValue("padding-right"));
//      element.style.paddingRight = parseInt(window.getComputedStyle(element).getPropertyValue("padding-right")) + parseInt(window.getComputedStyle(scrollbar).getPropertyValue("width")) + "px";
    }
  }
  
  function reset_scrollbar_position(scrollbar) {
    scrollbar.style.bottom = "0";
    scrollbar.style.right = "0";
  }
  
  function remove_scrollbar(element, scrollbar) {
    if(scrollbar != null){
      element.removeChild(scrollbar);
    }
  }

  function check_scrollbars() {
    var elements = document.querySelectorAll('.' + scrollable_elements_class),
        element,
        scrollbarX,
        scrollbarY,
        visible_overflow;

    for(var e = 0; e < elements.length; e++){
      element = elements[e];
      scrollbarY = element_scrollbar(element, ay);
      scrollbarX = element_scrollbar(element, ax);
      visible_overflow = window.getComputedStyle(element).overflow == "visible";
      
      if(overflowY(element) && ! visible_overflow){
        scrollbarY = scrollbarY || element.appendChild(scrollBar(ay));
        reset_scrollbar_position(scrollbarY);
        YscrollBarProperties(scrollbarY);
      }else{
        remove_scrollbar(element, scrollbarY);
      }
      
      if(overflowX(element) && ! visible_overflow){
        scrollbarX = scrollbarX || element.appendChild(scrollBar(ax));
        reset_scrollbar_position(scrollbarX);
        XscrollBarProperties(scrollbarX);
      }else{
        remove_scrollbar(element, scrollbarX);
      }
    }
  }
  
  function drag_start(ev) {
    if(has_class(ev.target, slider_class) && has_class(ev.target.parentElement, scrollbar_class)){
      html.classList.add(scrolling_class);
      scrollbar = ev.target.parentElement;
      s_element = scrollbar.parentElement;
      
      if(has_class(ev.target.parentElement, x_axis)){
        grabPointX = ev.clientX - ev.target.offsetLeft;
      }else if(has_class(ev.target.parentElement, y_axis)){
        grabPointY = ev.clientY - ev.target.offsetTop;
      }
    }
  }
  
  function drag(ev) {
    if(scrollbar && s_element){
      if(grabPointX){
        s_element.scrollLeft = (ev.clientX - grabPointX) / scrollbar.clientWidth * s_element.scrollWidth;
      }else if(grabPointY){
        s_element.scrollTop = (ev.clientY - grabPointY) / scrollbar.clientHeight * s_element.scrollHeight;
      }
    }
  }
  
  function drag_end() {
    grabPointX = grabPointY = scrollbar = s_element = false;
    html.classList.remove(scrolling_class);
  }
  
  function touch_start(touch) {
    if(! scrollbar){
      grabPointX = touch.clientX;
      grabPointY = touch.clientY;
      s_element = closestscrollableElement(touch.target);
      if(s_element){
        y_position = s_element.scrollTop;
        x_position = s_element.scrollLeft;
      }
    }
  }
  
  function touch_move(touch) {
    if(s_element && grabPointY && grabPointY && ! scrollbar){
      s_element.scrollLeft = x_position - (touch.clientX - grabPointX);
      s_element.scrollTop = y_position - (touch.clientY - grabPointY);
    }
  }
  
  function touch_end() {
    s_element = grabPointY = y_position = x_position = false;
  }
  
  window.addEventListener('mousedown', function (ev) {
    drag_start(ev);
  }, true);
  
  window.addEventListener('mousemove', function (ev) {
    drag(ev);
  }, true);
  
  window.addEventListener('mouseup', function () {
    drag_end();
  }, true);

  window.addEventListener('touch_start', function (ev) {
    if(ev.changedTouches.length == 1){
      drag_start(ev.changedTouches[0]);
      touch_start(ev.changedTouches[0]);
    }else{
      drag_end();
      touch_end();
    }
  }, true);

  window.addEventListener('touch_move', function (ev) {
    drag(ev.changedTouches[0]);
    touch_move(ev.changedTouches[0]);
  }, true);

  window.addEventListener('touch_end', function () {
    drag_end();
    touch_end();
  }, true);

  window.addEventListener('wheel', function (ev) {
    scroll(closestscrollableElement(ev.target), ev.deltaY);
  }, true);

  window.addEventListener('scroll', function (ev) {
    var closest = closestscrollableElement(ev.target);
    YscrollBarProperties(element_scrollbar(closest, ay));
    XscrollBarProperties(element_scrollbar(closest, ax));
  }, true);

  window.addEventListener('load', function () {
    start_checking();
  }, true);
  
})();