<!-- InstaChan v0-->
<!-- a one file solution for image BBS. -->
<!-- by: rafaelmuto -->
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
 ?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <style media="screen">
      :root{
        --max_w: 900px;
        --thumb_w: 100px;
        --color_post_odd: #ecf0f1;
        --color_post_even: #bdc3c7;
        --color_btn: #e74c3c;
        --color_bord: #7f8c8d;
      }
      *{
        font-family: monospace;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body{
        padding: 10px;
      }

      .form_post{
        max-width: var(--max_w);
        border-radius: 20px 20px 0 0;
        border: 1px solid var(--color_bord);
        margin: 0 auto;
        padding: 10px;
      }

      input{
        border: 0;
        border-bottom: 1px solid #7f8c8d;
        margin-bottom: .5em;
      }

      textarea{
        resize: none;
        width: 100%;
      }

      .line{
        width: 100%;
      }

      .btn {
        padding: 1rem 2rem;
        border: 1px solid var(--color_bord);
        background: transparent;
        font-size: 0.9em;
        border-radius: 2px;
        margin: 0  auto;
      }

      .btn:hover {
        cursor: pointer;
        background: var(--color_btn);
        color: white;
        border: 1px solid white;
      }

      .board{
        max-width: var(--max_w);
        margin: 0 auto;
        border-left: 1px solid var(--color_bord);
        border-right: 1px solid  var(--color_bord);
      }

      .post{
        border-bottom: 1px solid var(--color_bord);
        padding: 5px;
        padding-top: 0;
        display: grid;
        grid-template-columns: var(--thumb_w) auto;
        grid-template-rows: auto auto auto;
        grid-template-areas: "post_header post_header" "img post_msg";
      }

      .post:nth-child(odd){
        background-color: var(--color_post_odd);
      }

      .post:nth-child(even){
        background-color: var(--color_post_even);
      }

      .post_header{
        grid-column: span 2;
        grid-area: post_header;
      }

      .img_thumb{
        width: var(--thumb_w);
        height: auto;
        grid-area: img;
      }

      .post_msg{
        margin-left: 5px;
        grid-area: post_msg;
      }

      .del_post{
        max-width: var(--max_w);
        padding: 10px;
        margin: 0 auto;
        border: 1px solid var(--color_bord);
        border-top: 0;
        border-radius: 0 0 20px 20px;
      }

    </style>

    <title>ᶘ ᵒᴥᵒᶅ InstaChan</title>
  </head>

  <body>

    <!-- POST FORM -->
    <div class="form_post">
      <h1>ᶘ ᵒᴥᵒᶅ InstaChan v0</h1>
      a one file solution for image BBS.
      <hr>
      <form action="#" method="post" enctype="multipart/form-data">
        <label for="user">User:</label><input class="line" type="text" name="user" value=""><br>
        <label for="passw">Delete Code:</label><input class="line" type="Password" name="passw" value=""><br>
        <label for="file">Image:</label><input class="line" type="file" name="img" value=""><br>
        <label for="msg">Message:</label><br><textarea name="msg" rows="8" cols="80"></textarea><br>
        <button class="btn" type="submit" name="button">submit</button>
      </form>
    </div>

    <!-- Instadb -->
    <?php
      if($_GET!=[]){
        foreach ($array["instadb"] as $id => $item) {
          if($_GET["del_id"] == $item["time"] && password_verify($_GET["del_code"],$item["passw"])){
            unset($array["instadb"]["$id"]);
          }
        }
        file_put_contents("instadb.json",json_encode($array));
      }

      if($_POST!=[] && $_POST["user"]!=="" ){
        $post["time"] = date("YmdHis");
        $post["user"] = $_POST["user"];
        $post["passw"] = password_hash($_POST["passw"], PASSWORD_DEFAULT);
        $post["msg"] = $_POST["msg"];
        if($_FILES["img"]["error"]==UPLOAD_ERR_OK){
          $file_ext = explode(".", strtolower($_FILES["img"]["name"]));
          $file_name = $post["time"] .".". $file_ext[1];
          $file = $_FILES["img"]["tmp_name"];
          $move_ok = move_uploaded_file($file, "img/".$file_name);
          $post["img_path"] = "img/".$file_name;
        }
        else $post["img_path"]=FALSE;
        $array["instadb"][] = $post;
        file_put_contents("instadb.json",json_encode($array));
      }

     ?>

    <!-- BOARD -->
    <div class="board">
      <?php
      $array["instadb"] = array_reverse($array["instadb"],TRUE);
      foreach ($array["instadb"] as $id => $item) {
        echo '<div class="post">';
        echo '<p class="post_header">#' . $id . ' id: ' . $item["time"] . ' >> <strong>' . $item["user"] . ':</strong><br></p>';
        if($item["img_path"] != FALSE) echo '<a href="' . $item["img_path"] . '"><img class="img_thumb" src="' . $item["img_path"] . '"></a>';
        echo '<p class="post_msg">' . $item["msg"] . '</p>';
        echo "</div>";
      } ?>
    </div>

    <!-- DELETE FORM -->
    <div class="del_post">
      <form action="#" method="get">
        id: <input type="text" name="del_id">
        delete code: <input type="password" name="del_code">
        <button type="submit" name="submit">delete</button>
      </form>
    </div>

  </body>
</html>
