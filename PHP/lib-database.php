<?php

  if(! isset($functions)){
    header("location: index.php");
    exit();
  }

  function Connect(){
    $connect = mysqli_connect("localhost", "root", "vertrigo", "ultraball");
    if($connect){
      mysqli_set_charset($connect, 'utf8');
    }
    return $connect;
  }

  function GetData($sql){
    $array = array();
    $connect = Connect();
    
    if($connect){
      $query = mysqli_query($connect, $sql);

      if($query){
        $fields = mysqli_fetch_fields($query);
        if($fields){
          $x = 0;
          while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            $y = -1;
            while(++$y < count($fields)){
              $array_key = $fields[$y]->name;
              $array[$x][$array_key] = $result[$array_key];
            }
            $x++;
          }
        }else{
          $array = false;
        }
        mysqli_free_result($query);
      }else{
        $array = false;
      }
      mysqli_close($connect);
    }else{
      $array = false;
    }
    
    return $array;
  }

?>
