<?php

  function PageContent(){

//    class Options {
//      $name;
//      $description;
//      $options;
//      
//      Options($_name, $_description, $_options = array("Wyłączone", "Włączone")) {
//        $name = $_name;
//        $description = $_description;
//        $options = $_options;
//      }
//    };
//    
//    $x = new Options("Motyw graficzny", "Wybierz motyw graficzny strony, który najbardziej Ci się podoba");
//    echo $x->$name;
        
    $options = array("Wyłączone", "Włączone");
    $settings = array(
      array("setting_name" => "Motyw graficzny", "description" => "Wybierz motyw graficzny strony, który najbardziej Ci się podoba", "options" => array("Ciemny", "Jasny")),
      array("setting_name" => "System przewijania", "description" => "Strona posiada własny system przewijania zawartości dzięki któremu pasek przewijania komponuje się ze stylem graficznym strony i wygląda tak samo w każdej przeglądarce, natomiast może bardziej obciążać komputer. Wybierz, który system przewijania wolisz używać", "options" => array("Przeglądarki", "Strony (beta)")),
      array("setting_name" => "Pozycja menu", "description" => "Wybierz, z której strony ma być wyświetlane menu główne oraz przyciski nagłówkowe strony", "options" => array("Z lewej", "Z prawej")),
      array("setting_name" => "Zachowanie Menu", "description" => "Zdecyduj czy menu główne strony ma przesuwać zawartość strony (jeśli szerokość strony jest odpowiednio duża) czy być zawsze na wierzchu", "options" => array("Domyślne", "Na wierzchu")),
      array("setting_name" => "Animowane efekty strony", "description" => "Używaj animacji podczas chowania i pojawiania się elementów a także efektów po najechaniu kursorem myszy"),
      array("setting_name" => "Animowane obrazki Pokemonów", "description" => "Wyświetlaj ruchome obrazki Pokemonów zamiast zwykłych"),
      array("setting_name" => "Pokemony Shiny", "description" => "Wybierz sposób wyświetlania Pokemonów Shiny względem zwykłych w odnośnikach", "options" => array("Wyłączone", "Obok", "Zamiast")),
      array("setting_name" => "Rozmiar czcionek", "description" => "Wybierz rozmiary czcionek oraz elementów na stronie", "options" => array("Mały", "Średni", "Duży"))
    );

    if(! count($_COOKIE)){
      echo
      '<div class="wrapper">';
      Info(3, -1);
      echo
      '</div>';
    }

    echo
    '<div class="wrapper">';

    for($i = 0; $i < count($settings); $i++){

      $cookies = Cookies($i);
      $setting = $settings[$i];
      $values = $options;

      echo
      '<div class="wrapper inline setting-div">
        <div class="setting-info-div" data-name="'.$cookies['cookie_name'].'">
          <h1 class="setting-name-div"><span class="item-icon icon-cog-alt"></span>'.$setting['setting_name'].'</h1>
          <p class="setting-description-div description">'.$setting['description'].'</p>
        </div><div class="setting-status-div">';

          if(isset($setting['options'])){
            $values = $setting['options'];
          }

          for($o = 0; $o < count($values); $o++){
            echo
            '<button class="setting-option page-button ';

            if(CookieValue($cookies['cookie_name']) == $o){
              echo ' selected';
            }

            if(count($_COOKIE) == 0){
              echo ' disable';
            }

            echo
            '"/><span class="checkbox-icon"></span>'.$values[$o].'</button>';
          }

      echo
        '</div>
      </div>';
    }

    echo
    '</div>';

  }
    
	require_once "PHP/page-body.php";
?>

