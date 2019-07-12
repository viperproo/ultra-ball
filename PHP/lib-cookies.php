<?php

  if(! isset($functions)){
    header("location: index.php");
    exit();
  }

  function Cookies($index){

    $cookies = array(
      array("cookie_name" => "style", "default" => 0, "options-values" => array("dark", "white")),
      array("cookie_name" => "scrollbar", "default" => 0, "options-values" => array(0, 1)),
      array("cookie_name" => "menu_position", "default" => 0, "options-values" => array("menu-left", "menu-right")),
      array("cookie_name" => "menutop", "default" => 0, "options-values" => array(null, "menu-top")),
      array("cookie_name" => "animations", "default" => 1, "options-values" => array(null, "anim")),
      array("cookie_name" => "images", "default" => 1, "options-values" => array(null, "anim-img")),
      array("cookie_name" => "shiny", "default" => 0, "options-values" => array(0, 1, -1)),
      array("cookie_name" => "font", "default" => 1, "options-values" => array("small-font", "medium-font", "big-font"))
    );

    if(gettype($index) == "integer"){

      if($index >= 0 && $index < count($cookies)){
        return $cookies[$index];
      }

    }else if(gettype($index) == "string"){

      for($x = 0 ; $x < count($cookies) ; $x++){
        if($cookies[$x]['cookie_name'] == $index){
          return $cookies[$x];
        }
      }

    }

    return false;

  }

  function SetCookies(){

    setcookie('ci', 1, time() + (86400 * 150), "/");

    for($x = 0; $cookie = Cookies($x); $x++){

      if(isset($_COOKIE[$cookie['cookie_name']])){
        $value = $_COOKIE[$cookie['cookie_name']];
      }else{
        $value = $cookie['default'];
      }

      setcookie($cookie['cookie_name'], $value, time() + (86400 * 150), "/");

    }

  }

  function CookieValue($cookie_name){

    if(isset($_COOKIE[$cookie_name])){
      return $_COOKIE[$cookie_name];
    }else{
      $cookie = Cookies($cookie_name);
      if(gettype($cookie) == 'array'){
        return $cookie['default'];
      }
      return $cookie;
    }

  }

  function CookieOptionValue($cookie_name){
    
    $cookie_val = CookieValue($cookie_name);
    if($cookie_val !== false){
      return Cookies($cookie_name)['options-values'][$cookie_val];
    }
    return false;

  }

  function PrintCookieOptionValue($cookie_names){
    if(gettype($cookie_names) == 'array'){
      for($x = 0; $x < count($cookie_names); $x++){
        if(CookieOptionValue($cookie_names[$x])){
          if($x > 0){
            echo ' ';
          }
          echo CookieOptionValue($cookie_names[$x]);
        }
      }
    }
  }
?>