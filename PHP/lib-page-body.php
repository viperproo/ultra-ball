<?php
  if(! isset($functions)){
    header("location: index.php");
    exit();
  }

  function PageName(){
    return 'Ultra Ball';
  }

  function MenuLinks($index){
    $menu_links = array(
      array("link" => "index", "description" => "Strona główna", "class" => "icon-home", "hr" => true),
      array("link" => "types", "description" => "Typy Pokemonów"),
      array("link" => "pokedex", "description" => "Pokedex"),
      array("link" => "evolutions", "description" => "Ewoluowanie", "hr" => true),
      array("link" => "settings", "description" => "Ustawienia", "class" => "icon-cog"),
      array("link" => "info", "description" => "O stronie", "class" => "icon-info-circled")
    );

    if(gettype($index) == "integer"){

      if($index >= 0 && $index < count($menu_links)){
        return $menu_links[$index];
      }else{
        return false;
      }

    }else if(gettype($index) == "string"){

      for($x = 0; $x < count($menu_links); $x++){
        if($menu_links[$x]['link'] == $index){
          return $menu_links[$x]['description'];
        }
      }

      return false;

    }else{
      return false;
    }
  }
?>