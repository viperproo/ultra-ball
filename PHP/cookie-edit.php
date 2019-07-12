<?php
	if(isset($_POST['cookie_name'])){
    if(isset($_COOKIE[$_POST['cookie_name']])){
      if(isset($_POST['value']) && $_POST['value']){
        $value = $_POST['value'];
      }else{
        if($_COOKIE[$_POST['cookie_name']]){
          $value = 0;
        }else{
          $value = 1;
        }
      }
      setcookie($_POST['cookie_name'] , $value , time() + (86400 * 150) , "/");
    }
	}else{
		header("location: ../index.php");
		exit();
	}
?>