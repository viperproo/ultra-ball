<?php

  $functions = true;

  require_once "PHP/lib-pokemon.php";

  function PageContent(){

    echo
    '<div class="wrapper">
      <h1 class="title">Typy Pokemonów</h1>
    </div>
    <div class="wrapper">';

    $type = GetData("SELECT * FROM `types`");

    if($type){
      for($x = 0; $x < count($type); $x++){
        echo
        '<div class="wrapper inline colored-group circled-edges type">
          <div class="pokemon-type-container">
            <div class="pokemon-type-div">';                    
            TypeImg($type[$x]['id']);                    
        echo
            '</div>
            <div class="pokemon-type-name-div">'.$type[$x]['Name'].'</div>
          </div>
        </div>';
      }
    }else{
      Info(1, -1);
    }

    echo
    '</div>';
  }

	require_once "PHP/page-body.php";
?>