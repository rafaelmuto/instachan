<!DOCTYPE html>
<?php
  if(file_exists("instadb.json")){
    $array = json_decode(file_get_contents("instadb.json"),TRUE);
  }
  else{
    $array = ["instadb"=>[]];
  }

  if(!is_dir("img/")){
    mkdir("img/");
  }

  function add_data(){
    $temp_array = [];
    $temp_array["time"] = date("YmdHis");
    $temp_array["user"] = $_POST["user"];
    $temp_array["passw"] = password_hash($_POST["passw"], PASSWORD_DEFAULT);
    $temp_array["msg"] = $_POST["msg"];
    if($_FILES["img"]["error"]==UPLOAD_ERR_OK) $temp_array["img_path"] = "img/".$_FILES["img"]["name"];
    else $temp_array["img_path"]=FALSE;
    return $temp_array;
  }

 ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <style media="screen">
      *{
        font-family: monospace;
        margin: 0;
        padding: 0;
      }
    </style>
    <title>InstaChan</title>
  </head>
  <body>
    <h1>InstaChan v.0</h1>
    a one file solution for image BBS.
    <hr>
    <form action="#" method="post" enctype="multipart/form-data">
      <label for="user">User:</label><input type="text" name="user" value=""><br>
      <label for="passw">Password:</label><input type="Password" name="passw" value=""><br>
      <label for="file">Image:</label><input type="file" name="img" value=""><br>
      <label for="msg">Message:</label><br><textarea name="msg" rows="8" cols="80"></textarea><br>
      <input type="submit" name="Submit">
    </form>
    <?php
      if($_POST!=[]){
        $array["instadb"][] = add_data();
        file_put_contents("instadb.json",json_encode($array));
      }
      if($_POST!=[] && $_FILES["img"]["error"]==UPLOAD_ERR_OK){
        $file_name = $_FILES["img"]["name"];
        $file = $_FILES["img"]["tmp_name"];
        $move_ok = move_uploaded_file($file, "img/".$file_name);
      }
     ?>
    <hr><pre>
    <?php
    $array["instadb"] = array_reverse($array["instadb"],TRUE);
    foreach ($array["instadb"] as $id => $item) {
      echo "#" . $id . " @ " . $item["time"] . "<br>" . $item["user"] . ":<br>" . $item["msg"];
      if($item["img_path"] != FALSE) echo '<img src="' . $item["img_path"] . '">';
      echo "<hr>";
    } ?>

  </body>
</html>
