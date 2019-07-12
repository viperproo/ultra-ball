<?php

    if(! isset($functions)){
        header("location: index.php");
        exit();
    }

    require_once "lib-cookies.php";
    require_once "lib-database.php";
    require_once "lib-page-body.php";
    require_once "lib-pokemon.php";
    require_once "lib-errors.php";
?>