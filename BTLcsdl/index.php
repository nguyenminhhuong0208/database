<?php
   $db_name = 'mysql:host=localhost;dbname=BTLcsdl';
   $user_name = 'root';
   $user_password = '';

   $connection = new PDO($db_name,$user_name, $user_password );

   if(!$connection){
     echo"Can not connect to the database";
   }

   function unique_id(){
      $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charLength = strlen($chars);
      $randomStr = '';

      for($i = 0; $i < 20; $i++){
         $randomStr .= $chars[mt_rand(0,$charLength -1)];
      }
      return $randomStr;
   }
?>