<?php
  $css = 'evolutions';
  $functions = true;
  require_once 'PHP/lib-all.php';

  $data = GetData("SELECT `pokedex`.`id`, `pokedex`.`Name`, `forms_descriptions`.`Description` FROM `pokedex` LEFT JOIN `forms_descriptions` ON `forms_descriptions`.`Pokemon_id` = `pokedex`.`id` WHERE `pokedex`.`id` = ".htmlentities($_GET['id'], ENT_QUOTES, 'utf-8'));
  $title = $data[0]['Name'];

  function EvolutionLine($id){
    $evolutions = EvolutionRow("`evolutions`.`PreEvolution_id` = $id");
    if($evolutions !== false){
      for($z = 0; $z < count($evolutions); $z++){
        EvolutionDiv($evolutions[$z]['PreEvo_id'], $evolutions[$z]['PreEvo_Name'], $evolutions[$z]['Evo_id'], $evolutions[$z]['Method'], $evolutions[$z]['Item']);
        EvolutionLine($evolutions[$z]['Evo_id']);
      }
    }
  }

  function SearchSounds($sound_file, $id){
    if($sound_file !== false && gettype($sound_file) == 'array'){
      foreach($sound_file as $file){
        $path = explode('/', $file);
        $file_name = $path[count($path) - 1];
        $f = explode('.', $file_name)[0];
        $sound_id = explode('-', $f);
        if($sound_id[0] == $id){
          echo
          '<div class="sound-container">
            <button class="pokemon-sound page-button"><span class="icon-music"></span>';
          if(isset($sound_id[1])){
            echo ' - '.$sound_id[1];
          }
          echo
            '</button>
            <audio>
              <source src="'.$file.'" type="audio/wav">
            </audio>
          </div>';
        }
      }
    }
  }

  function PageContent(){
    
    global $data;
    $id = $data[0]['id'];
    $name = $data[0]['Name'];
        
    echo '<section class="wrapper">';

    if($data !== false){
      
      $forms = GetData("SELECT `forms`.`id_Form`, `forms`.`Form_Name`, `items`.`Name` AS `Item`, `form_get_methods`.`Method` FROM `forms` LEFT JOIN `form_get_methods` ON `form_get_methods`.`Forms_id` = `forms`.`id` LEFT JOIN `items` ON `form_get_methods`.`Item_id` = `items`.`id` WHERE `forms`.`Pokemon_id` = $id");

      if($forms !== false){
        echo
        '<h1 class="title">Informacje o Pokemonie</h1>
        <section class="wrapper border pokemon-info">
          <h1 class="section-header">
            <span id="pokemon-id" class="description">#'.$id.'</span><span id="pokemon-name">'.$name.'</span>
          </h1>
          <div class="section-content">
            <div>';
            PokemonImage($id, $name, $forms[0]['Form_Name'], false);
            PokemonImage($id, $name, $forms[0]['Form_Name'], true);
        echo
            '</div>
            <div>';
            SearchSounds(glob('Files/Pokemon/Sounds/'.$id.'.*'), $id);
            SearchSounds(glob('Files/Pokemon/Sounds/'.$id.'-*'), $id);
        echo
            '</div>
          </div>
        </section>
        <section class="wrapper border pokemon-forms-div">
          <h2 class="section-header">Formy Pokemona</h2>
          <div class="section-content">
            <div>';

            for($y = 0; $y < count($forms); $y++){
              echo
              '<div class="wrapper inline">';
              PokemonDiv($id, $forms[$y]['id_Form'], 0);
              if($forms[$y]['Method']){
                echo
                '<div class="description-div description">';
                DescriptionWithItem(ExtractVariables($forms[$y]['Method'], array('pokemon' => $name, 'item' => $forms[$y]['Item'])), $forms[$y]['Item']);
                echo
                '</div>';
              }

              echo
              '</div>';
            }

        echo
          '</div>';
          if($data[0]['Description']){
            echo
            '<div class="description-div description">';
            DescriptionWithItem(ExtractVariables($data[0]['Description'], array('pokemon' => $name, 'item' => $forms[0]['Item'])), $forms[0]['Item']);
          }
        echo
            '</div>
          </div>
        </section>';
        
        if(count(EvolutionRow("`evolutions`.`PreEvolution_id` = $id OR `evolutions`.`Evolution_id` = $id")) > 0){
          echo
          '<section class="wrapper border">
            <h2 class="section-header">Linia ewolucji</h2>
            <div class="section-content">';
            EvolutionLine(BasicPokemon($id));
          echo
            '</div>
          </section>';
        }

      }else{
        Info(1, -1);
      }

    }else{
      Info(1, -1);
    }

    echo '</section>';
  }

  require_once "PHP/page-body.php";
?>