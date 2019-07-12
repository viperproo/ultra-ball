
<?php
  function PageContent(){        
?>
    
<div class="wrapper">
  <div class="image-div">
    <img src="Files/Images/Ultra_Ball.png" alt="Logo">
  </div>
</div>

<div class="wrapper"><?php
        
  $info = array(
    array("info-title" => "Wersja strony" , "info-description" => "0.5 (beta)"),
    array("info-title" => "Pliki Cookie" , "info-description" => "Strona zapisuje na urządzeniu końcowym użytkownika pliki Cookie w celu zapamiętywania ustawień strony"),
    array("info-title" => "Prywatność" , "info-description" => "Strona gromadzi anonimowe dane od użytkowników takie jak: Adres IP, data odwiedzenia strony, ile razy strona została odwiedzona itp. w celu tworzenia statystyk")
  );

  for($i = 0 ; $i < count($info) ; $i++){

    echo
    '<section class="wrapper">
      <div class="info-header">'.$info[$i]['info-title'].'</div>
      <div class="info-description description">'.$info[$i]['info-description'].'</div>
    </section>';

  }
        
?></div>

<?php        
  }
	require_once "PHP/page-body.php";
?>	

		