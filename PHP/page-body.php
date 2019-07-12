<?php

//  error_reporting(0);
  
  $path = basename($_SERVER['SCRIPT_FILENAME'], ".php");
  $functions = true;

  require_once "PHP/lib-all.php";

  if(! isset($title)){
    $title = MenuLinks($path);
  }

  if($title){
    $title .= ' - ';
  }

  SetCookies();
	
?>

<!DOCTYPE html>

<html lang="pl" class="<?php PrintCookieOptionValue(array("font")) ?>">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
	<meta name="description" content="Biblioteka informacji o grach Pokemon">
	<meta name="keywords" content="Pokemon, Ultra Ball">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
	<link rel="Shortcut icon" href="Files/Images/Ultra_Ball.png"><?php
	if(CookieValue('scrollbar') == 1){
    echo
    '<script src="JS/scrollbar.js"></script>
    <link rel="stylesheet" href="CSS/scrollbar.css">
    <noscript>
      <link rel="stylesheet" href="CSS/browser-scrollbar.css">
    </noscript>';
  }else{
    echo '<link rel="stylesheet" href="CSS/browser-scrollbar.css">';
  }
  ?><link rel="stylesheet" href="Files/Fontello/css/fontello.css">
	<link rel="Stylesheet" href="CSS/style.css"><?php
    if(file_exists("CSS/".$path.".css")){
  ?><link rel="Stylesheet" href="CSS/<?php echo $path ?>.css"><?php
    }
    if(isset($css)){
      if(file_exists("CSS/".$css.".css")){
  ?><link rel="Stylesheet" href="CSS/<?php echo $css ?>.css"><?php
      }
    }
  ?><link rel="Stylesheet" href="CSS/style-<?php PrintCookieOptionValue(array("style")) ?>.css">
	
	<title><?php echo $title.PageName(); ?></title>
	
	<script src="JS/jquery.js"></script>
  <script src="JS/mainjs.js"></script>
  <script src="JS/search.js"></script>
  <?php if(isset($load)){ ?>
  <script src="JS/load.js"></script>
  <?php
    }
    if(file_exists("JS/".$path.".js")){
  ?>
  <script src="JS/<?php echo $path ?>.js"></script>
  <?php
    }
  ?>
  <!--[if lt IE 9]>
    <script src="JS/html5.js"></script>
  <![endif]-->
    
</head>
<body class="<?php PrintCookieOptionValue(array("menu_position", "animations")) ?>">
	<header id="page-header" class="search-bar">
		<div id="header-buttons-div">
      <div class="tooltip-container">
        <label id="menu-button" class="header-button" for="menu-toggle"><span class="icon-menu-2"></span></label>
        <div class="tooltip">Menu</div>
      </div>
      <div class="tooltip-container" id="search-button-container">
        <button class="header-button" id="search-button"><span></span></button>
        <div class="tooltip">Szukaj</div>
        <div class="tooltip">Wstecz</div>
      </div><?php
        if(isset($load)){
      ?><div class="tooltip-container">
         <button class="header-button" id="load-button"><span class="icon-download"></span></button>
         <div class="tooltip">Załaduj całą zawartość</div>
      </div><?php
        }
      ?><div class="tooltip-container">
        <button class="header-button hidden" id="scroll-up-button"><span class="icon-up-open-3"></span></button>
        <div class="tooltip">Do góry</div>
      </div>
      <div class="clear-both"></div>
		</div>
		<div id="page-header-div">
      <div id="page-logo">
        <a href="index.php" id="home-link">
          <img src="Files/Images/Ultra_Ball.png" alt="Logo">
        </a>
      </div>
      <div class="search-container-div">
          <div id="search-icon"><span class="icon-search-1"></span></div>
          <div class="search-input-container">
            <input type="search" id="main-search" name="val" placeholder="Wyszukaj Pokemona" maxlength=20>
          </div>
          <div class="search-buttons-div">
            <div class="tooltip-container">
              <button id="result-button" class="search-button header-button"><span></span></button>
              <div class="tooltip">Szukaj</div>
              <div class="tooltip">Zamknij</div>
            </div>
          </div>
      </div>
    </div>
  </header>    
  <input type="checkbox" id="menu-toggle">    
  <nav id="page-menu">
    <ul id="nav-links-container" class="scrollable"><?php                                    
      for($m = 0 ; MenuLinks($m) ; $m++){                    
        $menu_links = MenuLinks($m);
      ?><li>
        <a href="<?php echo $menu_links['link']; ?>.php" class="nav-link<?php 

        if($path == $menu_links['link']){
          echo ' active';
        }

        ?>"><span class="item-icon <?php

            if(isset($menu_links['class'])){
              echo $menu_links['class'];
            }else{
              echo "icon-dot-circled";
            }

          ?>"></span>
          <span class="menu-link-name"><?php
            echo $menu_links['description'];
          ?></span>
        </a>
      </li>
      <?php                            
        if(isset($menu_links['hr']) && $menu_links['hr']){
      ?>
      <hr class="menu-hr">
      <?php
          }
        }
      ?>
    </ul>
  </nav>
    
  <main id="page-content-container" class="scrollable <?php PrintCookieOptionValue(array("menutop")) ?>">
    <section id="content">
      <noscript>
        <div class="wrapper"><?php
          Info(2, -1);
        ?></div>
      </noscript>           
        <?php
          PageContent();
        ?>            
    </section>
    <section id="result-container">
      <div id="search-result" class="wrapper">
        <div class="wrapper">
          <h1 class="result-title title">Pokemony : <span id="search-items">0</span></h1>
        </div>
        <div id="result" class="wrapper"></div>
      </div>
    </section>
    <footer id="page-footer">
      <span>&copy; 2017 <?php echo PageName() ?></span>
    </footer>
  </main>
  <div id="fs-container"></div>
<?php
  if(! isset($_COOKIE['ci'])){
    echo
    '<div id="cookies-info-div" class="scrollable">
      <button id="cookie-div-close-button"><span class="icon-cancel"></span></button>
      <h1 id="cookies-info-header" class="title">Ciasteczka</h1>
      <div id="cookie-info">Strona zapisuje na urządzeniu końcowym użytkownika ciasteczek (pliki cookie) w celu zapamiętywania ustawień strony. Jeśli nie chcesz aby pliki cookie były zapisywane na Twoim urządzeniu, wyłącz ich obsługę w ustawieniach przeglądarki.</div>
      <div class="clear-both"></div>
    </div>';
  }
?>
</body>
</html>
        
