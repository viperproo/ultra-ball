<?php

  if(! isset($functions)){
    header("location: index.php");
    exit();
  }

  function StringContainsWords($words, $string){
    if(gettype($words) === "string" && gettype($string) === "string"){
      $words = explode(" ", $words);
      $string = explode(" ", $string);

      for($a = 0; $a < count($string); $a++){
        for($b = 0; $b < count($words); $b++){
          if($string[$a + $b] !== $words[$b]){
            break;
          }
          if($b + 1 == count($words)){
            return $a;
          }
        }
      }
    }
    return false;
  }

  function ExtractVariables($text, $variables){
    if(gettype($text) === 'string' && gettype($variables) === 'array'){
      $extract1 = explode('[', $text);
      $new_text = array();
      for($x = 0; $x < count($extract1); $x++){
        $extract2 = explode(']', $extract1[$x]);
        for($y = 0; $y < count($extract2); $y++){
          $push = $extract2[$y];
          if($y === 0 && isset($variables[$extract2[$y]])){
            $push = $variables[$extract2[$y]];
          }
          array_push($new_text, $push);
        }
      }
      return implode('', $new_text);
    }else{
      return $text;
    }
  }

  function DescriptionWithItem($text, $item_name){
    if($index = StringContainsWords($item_name, $text)){
      $description = explode(" ", $text);
      $item = explode(" ", $item_name);

      for($a = 0; $a < count($description); $a++){
        if($a == $index){
          ItemSpan($item_name);
          
          for($x = 0; $x < count($item); $x++){
            $description[$index + $x] = '';
          }
        }
        echo $description[$a];
        if($a != count($description) - 1){
          echo ' ';
        }
      }
    }else{
      echo $text;
    }        
  }

  function BasicPokemon($id){
    $get = GetData("SELECT `evolutions`.`PreEvolution_id` FROM `evolutions` WHERE `evolutions`.`Evolution_id` = $id");
    if($get !== false){
      if(count($get) > 0){
        return BasicPokemon($get[0]['PreEvolution_id']);
      }else{
        return $id;
      }
    }
    return -1;
  }

  function EvolutionRow($where){
    return GetData("SELECT `evolutions`.`id` AS `Row_id`, `pokedex_1`.`id` AS `PreEvo_id`, `pokedex_1`.`Name` AS `PreEvo_Name`, `pokedex_2`.`id` AS `Evo_id`, `pokedex_2`.`Name` AS `Evo_Name`, `items`.`Name` AS `Item`, `evolutions`.`Method` FROM `evolutions` LEFT JOIN `pokedex` `pokedex_1` ON `evolutions`.`PreEvolution_id` = `pokedex_1`.`id` LEFT JOIN `pokedex` `pokedex_2` ON `evolutions`.`Evolution_id` = `pokedex_2`.`id` LEFT JOIN `items` ON `evolutions`.`Item_id` = `items`.`id` WHERE $where");
  }

  function TypeImg($id){
    echo '<img src="Files/Pokemon/Types/'.$id.'.png" alt="Typ">';
  }

  function ItemImg($name){
    $item_name = implode("_", explode(' ', $name));
    echo '<img src="Files/Pokemon/Items/'.$item_name.'.png" alt="'.$name.'">';
  }

  function ItemSpan($name){
    ItemImg($name);
    echo '<span class="item-name">'.$name.'</span>';
  }

  function PokemonNameDiv($name, $form_name, $shiny){
    echo
    '<div class="pokemon-name-div pokemon-info-div">
      <span class="pokemon-name">';
      if($name == 'NidoranM'){
        echo 'Nidoran <span class="icon-male"></span>';
      }else if($name == 'NidoranF'){
        echo 'Nidoran <span class="icon-female"></span>'; 
      }else{
        echo $name;
      }
    echo
      '</span>';
    if($shiny < 0){
      echo '<span class="pokemon-shiny">*</span>';
    }
    if($form_name){
      echo '<span class="pokemon-form-name">'.$form_name.'</span>';
    }
    echo
    '</div>';
  }

  function PokemonIdDiv($id){
    echo '<div class="pokemon-id-div"><span>#</span><span class="pokemon-id">'.$id.'</span></div>';
  }

  function PokemonTypesDiv($type1, $type2){
    echo
    '<div class="pokemon-types-div">';
        TypeImg($type1);
        if($type2){
          TypeImg($type2);
        }
    echo
    '</div>';
  }

  function PokemonImage($id, $name, $form_name = null, $shiny = null){
    $image;
    if(CookieValue('images') == 1){
      $image = 'gif';
    }else{
      $image = 'png';
    }
    echo
    '<div class="pokemon-image circled-edges">';
    if($id){
      echo '<img src="Files/Pokemon/Sprites/';
      
      if($shiny){
        echo 'Shiny-';
      }
      
      echo strtoupper($image).'/'.$id;

      if($form_name){
        echo '-';

        if($form_name == "?"){
          echo 'qm';
        }else{
          echo $form_name;
        }
      }
      
      echo '.'.$image.'" alt="'.$name.'">';
    }else{
      echo '<span>?</span>';
    }
    echo
    '</div>';
  }

  function PokemonImagesContainer($id, $name, $form_name, $shiny){
    echo
    '<div class="pokemon-image-div">';
    
      if($shiny < 0){
        $sh = true;
      }else{
        $sh = false;
      }

      PokemonImage($id, $name, $form_name, $sh);

      if($shiny > 0){
        PokemonImage($id, $name, $form_name, true);
      }
    echo
    '</div>';
  }

  function GetPokemonData($id, $form_id){
    return GetData("SELECT `pokedex`.`id` AS `Pokemon_id`, `pokedex`.`Name` AS `Pokemon_Name`, `forms`.`Form_Name`, `type_1`.`id` AS `Type1_id`, `type_2`.`id` AS `Type2_id` FROM `pokedex` LEFT JOIN `forms` ON `forms`.`Pokemon_id` = `pokedex`.`id` LEFT JOIN `types` `type_1` ON `type_1`.`id` = `forms`.`Type1_id` LEFT JOIN `types` `type_2` ON `type_2`.`id` = `forms`.`Type2_id` WHERE `pokedex`.`id` = $id AND `forms`.`id_Form` = $form_id");
  }

  function PokemonDiv($id, $form_id, $shiny){
    $pokemon = GetPokemonData($id, $form_id)[0];
    
    if($id){
      $x = GetPokemonData($id, $form_id)[0];
      $id = $x['Pokemon_id'];
      $name = $x['Pokemon_Name'];
      $form_name = $x['Form_Name'];
      $type1 = $x['Type1_id'];
      $type2 = $x['Type2_id'];
    }else{
      $id = $name = $type1 = '???';
      $form_name = $type2 = null;
    }
    
    echo
    '<div class="pokemon-div circled-edges colored-group';
    if($shiny < 0){
      echo ' shiny';
    }
    echo '">';
      PokemonNameDiv($name, $form_name, $shiny);
      PokemonTypesDiv($type1, $type2);
      PokemonImagesContainer($id, $name, $form_name, $shiny);
    echo
    '</div>';
  }

  function PokemonLink($id, $form_id = 1){

  //        $shiny < 0 -> Pokemon shiny instead normal.
  //        $shiny = 0 -> No shiny Pokemon.
  //        $shiny > 0 -> Pokemon shiny next to normal.
    
    $shiny = CookieOptionValue('shiny');
    
    if($id){
      $x = GetPokemonData($id, $form_id)[0];
      $id = $x['Pokemon_id'];
      $name = $x['Pokemon_Name'];
      $form_name = $x['Form_Name'];
      $type1 = $x['Type1_id'];
      $type2 = $x['Type2_id'];
    }else{
      $id = $name = $type1 = '???';
      $form_name = $type2 = null;
    }
    
    echo
    '<a href="pokemon.php?id='.$id.'" class="pokemon-link pokemon-div circled-edges colored-group';
    if($shiny < 0){
      echo ' shiny';
    }
    echo '">';
      PokemonNameDiv($name, false, $shiny);
    echo
      '<div class="pokemon-info-div">';
        PokemonIdDiv($id);
        PokemonTypesDiv($type1, $type2);
    echo
      '</div>';
      PokemonImagesContainer($id, $name, $form_name, $shiny);
    echo
    '</a>';
  }

  function EvolutionDiv($PreEvo_id, $PreEvo_Name, $Evo_id, $method, $item){
    echo
    '<div class="pokemon-container">';
    PokemonLink($PreEvo_id);
    echo
    '<div class="evolution-method">
      <div class="arrow-container"><span class="arrow"></span></div>
      <div class="description-div description">';
      DescriptionWithItem(ExtractVariables($method, array('item' => $item, 'pokemon' => $PreEvo_Name)), $item);
    echo
      '</div>
    </div>';
    PokemonLink($Evo_id);
    echo
    '</div>';
  }
?>