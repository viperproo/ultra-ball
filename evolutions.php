
<?php
  $load = true;
  $functions = true;

  require "PHP/lib-all.php";

  function Load(){
    $id = 0;
    
    if(isset($_POST['lastid'])){
      $id = intval($_POST['lastid']);
    }

    $query = "`evolutions`.`id` > $id";

    if(! isset($_POST['limit']) || $_POST['limit']){
      $query .= " LIMIT 30";
    }
      
    $max_id = GetData("SELECT COUNT(`id`) AS `Max_id` FROM `evolutions`");
    $evolutions = EvolutionRow($query);

    if($evolutions !== false && $max_id !== false){

      for($x = 0; $x < count($evolutions); $x++){
        EvolutionDiv($evolutions[$x]['PreEvo_id'], $evolutions[$x]['PreEvo_Name'], $evolutions[$x]['Evo_id'], $evolutions[$x]['Method'], $evolutions[$x]['Item']);
        $id = $evolutions[$x]['Row_id'];
      }

      if($id >= $max_id[0]['Max_id']){
        $id = 'false';
      }

    }else{
      Info(1, -1);
    }
    
    echo '<input type="hidden" data-load="'.$id.'">';    
  }

  function PageContent(){
    echo
    '<header class="wrapper">
      <h1 class="title">Sposoby ewoluowania Pokemonów</h1>
      <h2 class="description">Opisy dotyczą Pokemona przed ewolucją</h2>
    </header>
    <section class="wrapper" id="main-content">';    
    Load();
    echo
    '</section>';
  }

  if(isset($_POST['lastid'])){
    Load();
  }else{
    require_once "PHP/page-body.php";
  }
?>