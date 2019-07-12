<?php

  if(! isset($functions)){
    header("location: index.php");
    exit();
  }

  function Info($num, $type = 0){

    switch($num){

      case 1:
        $num = "Nie udało się wczytać zawartości";
        break;

      case 2:
        $num = "Wyłączona obsługa JavaScript";
        $description = "Wiele funkcji i elementów na stronie nie będzie działać. Włącz obsługę JavaScript w ustawieniach przeglądarki by to zmienić";
        break;

      case 3:
        $num = "Wyłączona obsługa Ciasteczek";
        $description = "Wszystkie ustawienia strony mają wartości domyślne i nie można ich zmieniać. Włącz obsługę ciasteczek (plików cookie) w ustawieniach przeglądarki aby to zmienić";
        break;

      case 4:
        $num = "Nie znaleziono Pokemona";
        break;

      default:
        $num = "Wystąpił błąd";
        break;

    }

    switch($type){

      case 1:
        $type = " color-green";
        break;

      case -1:
        $type = " color-red";
        break;

      default:
        $type = "";
        break;

    }

    echo
    '<div class="info-container-div circled-edges">
      <h1 class="info-header'.$type.'">'.$num.'</h1>';
    if(isset($description)){
      echo
      '<p class="info-description">'.$description.'</p>';
    }

    echo
    '</div>';

  }
?>