<!-- InstaChan-->
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

  if(!is_dir("instafolder/")){
    mkdir("instafolder/");
  }

  if(isset($_POST["new_custom_name"])){
    $config = [];
    $config["custom_name"] = $_POST["new_custom_name"];
    $config["master_code"] = password_hash($_POST["new_master_code"], PASSWORD_DEFAULT);
    $config["ppp"] = $_POST["new_ppp"];
    $config["killme"] = $_POST["new_killme"];
    $config["killdate"] = $_POST["new_killdate"];
    $config["bcolor"] = $_POST["new_bcolor"];
    file_put_contents("instaconfig.json",json_encode($config));
    unset($_POST["new_custom_name"]);
  }
 ?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <style media="screen">
      :root{
        --max_w: 900px;
        --config_w:450px;
        --thumb_w: 200px;
        --color_back: white;
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
        /* background-color: red; */
      }

      .instachan_container{
        margin: 50px auto;
        background-color: var(--color_back);
        border: 1px solid var(--color_bord);
        box-shadow: 5px 5px var(--color_bord);
        max-width: var(--max_w);
        border-radius: 20px;
      }

      .config_container{
        max-width: var(--config_w);
      }

      .form_config{
        padding: 10px;
      }

      .form_post{
        border-bottom: 1px solid var(--color_bord);
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
      }

      .btn:hover {
        cursor: pointer;
        background: var(--color_btn);
        color: white;
        border: 1px solid white;
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
        padding: 10px;
        border-top: 0;
        border-radius: 0 0 20px 20px;
      }

    </style>

    <title>InstaChan v0.1</title>
  </head>

  <body>
    <?php if(!file_exists("instaconfig.json")): ?>
    <!-- CONFIG -->
    <div class="instachan_container config_container">
      <div class="form_config">
        <h1>ʕ•ᴥ•ʔ InstaConfig</h1>
        a one file solution for image BBS.
        <hr>
        <h3>Instructions:</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <hr>
        <form class="" action="#" method="post">
          <label for="new_custom_name">Custom Name:</label><input class="line" type="text" name="new_custom_name" value="ᶘ ᵒᴥᵒᶅ InstaChan!"><br>
          <label for="new_master_code">Master Code:</label><input class="line" type="Password" name="new_master_code" value=""><br>
          <label for="new_ppp">Posts per page:</label>
          <select class="line" name="new_ppp" value="single_page">
            <option value="single_page">single page</option>
            <option value="5">5 posts/page</option>
            <option value="10">10 posts/page</option>
            <option value="20">20 posts/page</option>
            <option value="50">50 posts/page</option>
            <option value="100">100 posts/page</option>
          </select>
          <label for="new_killme">Auto Delete after # posts:</label><input class="line" type="text" name="new_killme" value=0><br>
          <label for="new_killdate">Expiration date:</label><input class="line" type="date" name="new_killdate" value="2038-01-19">
          <label for="new_bcolor">Background Color</label><input class="line" type="color" name="new_bcolor" value="#ffffff">
          <br>
          <button class="btn line" type="submit" name="button">Create BBS!</button>
        </form>
      </div>

    </div>

    <?php else: ?>
    <div class="instachan_container">

      <!-- POST FORM -->
      <div class="form_post">
        <h1>ᶘ ᵒᴥᵒᶅ InstaChan</h1>
        InstaChan a one file solution for image BBS.
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
        if(isset($_POST["del_id"])){
          foreach ($array["instadb"] as $id => $item) {
            if($_POST["del_id"] == $item["time"] && password_verify($_POST["del_code"],$item["passw"])){
              unset($array["instadb"]["$id"]);
            }
          }
          unset($_POST["del_id"]);
          file_put_contents("instadb.json",json_encode($array));
        }

        if(isset($_POST["user"]) && $_POST["user"]!=="" ){
          $post["time"] = date("YmdHis");
          $post["user"] = $_POST["user"];
          $post["passw"] = password_hash($_POST["passw"], PASSWORD_DEFAULT);
          $post["msg"] = $_POST["msg"];
          if($_FILES["img"]["error"]==UPLOAD_ERR_OK){
            $file_ext = explode(".", strtolower($_FILES["img"]["name"]));
            $file_name = $post["time"] .".". $file_ext[1];
            $file = $_FILES["img"]["tmp_name"];
            $move_ok = move_uploaded_file($file, "instafolder/".$file_name);
            $post["img_path"] = "instafolder/".$file_name;
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
        <form action="#" method="post">
          id: <input type="text" name="del_id">
          delete code: <input type="password" name="del_code">
          <button type="submit" name="submit">delete</button>
        </form>
      </div>

    <?php endif; ?>
    </div>
  </body>
</html>
