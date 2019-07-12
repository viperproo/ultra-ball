<?php
  $load = true;
  $functions = true;

  require "PHP/lib-all.php";

  function Load(){

    $id = 0;
    $query;

    if(isset($_POST['val'])){
      $val = htmlentities($_POST['val'], ENT_QUOTES, "UTF-8");
      $query = '`pokedex`.`Name` LIKE "'.$val.'%" OR `pokedex`.`id` LIKE "'.$val.'%"';
    }else{
      if(isset($_POST['lastid'])){
        if($_POST['lastid']){
          $id = intval($_POST['lastid']);
        }
      }

      $query = "`pokedex`.`id` > $id ORDER BY `pokedex`.`id`";

      if(! isset($_POST['limit']) || $_POST['limit']){
        $query .= ' LIMIT 40';
      }
    }

    $max_id = GetData("SELECT MAX(`id`) AS `Max_id` FROM `pokedex`");
    $pokedex = GetData("SELECT `pokedex`.`id` FROM `pokedex` LEFT JOIN `forms` ON `pokedex`.`id` = `forms`.`Pokemon_id` WHERE `forms`.`id_Form` = 1 AND $query");

    if($pokedex !== false && $max_id !== false){

      if(count($pokedex) > 0){

        for($x = 0; $x < count($pokedex); $x++){

          echo
          '<div class="wrapper inline">';
          PokemonLink($pokedex[$x]['id']);
          echo
          '</div>';

          $id = $pokedex[$x]['id'];

        }

        if($id >= $max_id[0]['Max_id']){
          $id = 'false';
        }
      }else{
        if(isset($_POST['val'])){
          Info(4, -1);
        }
      }

    }else{
      Info(1, -1);
    }

    if(! isset($_POST['val'])){
      echo '<input type="hidden" data-load="'.$id.'">';
    }

  }

  function PageContent(){

    echo 
    '<header class="wrapper">
      <h1 class="title">Lista wszystkich Pokemonów</h1>
    </header>
    <section class="wrapper" id="main-content">';
    Load();
    echo
    '</section>';

  }

  if(isset($_POST['val']) || isset($_POST['lastid'])){
    Load();
  }else{
    require_once "PHP/page-body.php";
  }
?>
