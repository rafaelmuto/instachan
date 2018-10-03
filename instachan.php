<!-- ᶘ ᵒᴥᵒᶅ InstaChan-->
<!-- a one file solution for image BBS. -->
<!-- by: rafaelmuto -->
<!-- https://github.com/rafaelmuto/instachan -->

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

  if(!isset($_GET["page"])) $_GET["page"] = 0;

  if(isset($_POST["new_custom_name"])){
    $config = [];
    $config["custom_name"] = $_POST["new_custom_name"];
    $config["custom_subname"] = $_POST["new_custom_subname"];
    $config["master_code"] = password_hash($_POST["new_master_code"], PASSWORD_DEFAULT);
    $config["ppp"] = $_POST["new_ppp"];
    $config["thumbw"] = $_POST["new_thumbw"];
    $config["theme"] = $_POST["new_theme"];
    $config["killme"] = $_POST["new_killme"];
    $config["killdate"] = $_POST["new_killdate"];
    file_put_contents("instaconfig.json",json_encode($config));
    unset($_POST["new_custom_name"]);
  }

  if(file_exists("instaconfig.json")){
    $_SESSION = json_decode(file_get_contents("instaconfig.json"),TRUE);
  }
  else{
    $_SESSION["theme"] = "vanilla";
  }

  // THEME SWITCHING:
  switch ($_SESSION["theme"]){
    case "vanilla":
      $color_back = "#ffffff";
      $color_post_odd = "#ecf0f1";
      $color_post_even = "#bdc3c7";
      $color_btn = "#e74c3c";
      $color_bord = "#7f8c8d";
      $color_background = "#ffffff";
      $color_text = "#000000";

    break;

    case "watermelon":
      $color_back = "#feffe4";
      $color_post_odd = "#a3de83";
      $color_post_even = "#a3de83";
      $color_btn = "#fa4659";
      $color_bord = "#2eb872";
      $color_background = "#fa4659";
      $color_text = "#000000";
    break;

    case "neonsunset":
      $color_back = "#e01171";
      $color_post_odd = "#ab0e86";
      $color_post_even = "#ab0e86";
      $color_btn = "#e01171";
      $color_bord = "#59057b";
      $color_background = "#0f0766";
      $color_text = "#ffffff";
    break;

  }
 ?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <style media="screen">
      :root{
        --max_w: 900px;
        --config_w:450px;
        --thumb_w: <?php echo $_SESSION["thumbw"];?>;
        --color_back: <?php echo $color_back;?>;
        --color_post_odd: <?php echo $color_post_odd;?>;
        --color_post_even: <?php echo $color_post_even;?>;
        --color_btn: <?php echo $color_btn;?>;
        --color_bord: <?php echo $color_bord;?>;
        --color_background: <?php echo $color_background;?>;
        --color_text: <?php echo $color_text;?>;
      }

      *{
        font-family: monospace;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body{
        padding: 10px;
        background-color: var(--color_background);
      }

      hr{
        border: 1px solid var(--color_bord);
      }

      .instachan_container{
        margin: 0 auto;
        background-color: var(--color_back);
        border: 1px solid var(--color_bord);
        box-shadow: 5px 5px var(--color_bord);
        max-width: var(--max_w);
        border-radius: 20px;
        color: var(--color_text);
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
        background-color: var(--color_back);
        border: 0;
        border-bottom: 1px solid var(--color_bord);
        margin-bottom: .5em;
      }

      textarea{
        background-color: var(--color_back);
        border: 1px solid var(--color_bord);
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
        color: var(--color_background);
        border: 1px solid var(--color_background);
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

      .page_index{
        text-align: center;
        border-bottom: 1px solid var(--color_bord);
        padding: 5px;
      }

      .page_index>a{
        text-decoration: none;
        color: inherit;
      }

      .del_post{
        padding: 10px;
        border-top: 0;
        border-radius: 0 0 20px 20px;
      }

    </style>

    <title><?php echo (file_exists("instaconfig.json")?$_SESSION["custom_name"]:"InstaConfig"); ?></title>
  </head>

  <body>
    <?php if(!file_exists("instaconfig.json")): ?>
    <!-- CONFIG -->
    <div class="instachan_container config_container">
      <div class="form_config">
        <h1>ʕ•ᴥ•ʔ InstaConfig</h1>
        InstaChan: a one file solution for image BBS.
        <hr>
        <h3>Instructions:</h2>
        <p>To reset InstaChan or change configs enter admin and master code in the delete form.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <hr>
        <h3>Main:</h3>
        <form class="" action="#" method="post">
          <label for="new_custom_name">Custom Name:</label><input class="line" type="text" name="new_custom_name" value="ᶘ ᵒᴥᵒᶅ InstaChan!">
          <label for="new_custom_subname">Custom Sub Name:</label><input class="line" type="text" name="new_custom_subname" value="InstaChan: a one file solution for image BBS.">
          <label for="new_master_code">Master Code:</label><input class="line" type="Password" name="new_master_code" value="">

          <h3>Behaviors:</h3>
          <label for="new_thumbw">Thumbnail Width:</label>
          <select class="line" name="new_thumbw">
            <option value="100px">Small (100px)</option>
            <option value="200px">Medium (200px)</option>
            <option value="400px">X-Large (400px)</option>
          </select>
          <label for="new_ppp">Posts per page:</label>
          <select class="line" name="new_ppp" value="single_page">
            <option value=0>single page</option>
            <option value=5>5 posts/page</option>
            <option value=10>10 posts/page</option>
            <option value=20>20 posts/page</option>
          </select>

          <h3>Theme:</h3>
          <select class="line" name="new_theme">
            <option value="vanilla">vanilla</option>
            <option value="watermelon">watermelon</option>
            <option value="neonsunset">neon sunset</option>
          </select>

          <h3>Auto Delete:</h3>
          <label for="new_killme">Delete after # posts:</label><input class="line" type="text" name="new_killme" value=999>
          <label for="new_killdate">Expiration date:</label><input class="line" type="date" name="new_killdate" value="2038-01-19">
          <button class="btn line" type="submit" name="button">Create InstaChan!</button>
        </form>
      </div>

    </div>

    <?php else: ?>
    <div class="instachan_container">

      <!-- POST FORM -->
      <div class="form_post">
        <h1><?php echo $_SESSION["custom_name"]; ?></h1>
        <?php echo $_SESSION["custom_subname"]; ?>
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
        if(isset($_POST["del_id"]) && $_POST["del_id"]=="admin" && password_verify($_POST["del_code"],$_SESSION["master_code"])){
          unlink("instaconfig.json");
          header("Location:instachan.php");
        }

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
        // BOARD FOR PPP == 0 (single page)
        if($_SESSION["ppp"]==0){
          foreach($array["instadb"] as $id => $item){
            echo '<div class="post"> <p class="post_header">#' . $id . ' id: ' . $item["time"] . ' >>> <strong>' . $item["user"] . ':</strong><br></p>';
            if($item["img_path"] != FALSE) echo '<a href="' . $item["img_path"] . '"><img class="img_thumb" src="' . $item["img_path"] . '"></a>';
            echo '<p class="post_msg">' . $item["msg"] . '</p> </div>';
          }
        }
        // BOARD FOR PPP != 0 (multy page)
        else{
          $post_count = 0;
          foreach($array["instadb"] as $id => $item){
            if(($_GET["page"]*$_SESSION["ppp"]) <= $post_count && $post_count < (($_GET["page"]*$_SESSION["ppp"])+$_SESSION["ppp"])){
              echo '<div class="post"> <p class="post_header">#' . $id . ' id: ' . $item["time"] . ' >>> <strong>' . $item["user"] . ':</strong><br></p>';
              if($item["img_path"] != FALSE) echo '<a href="' . $item["img_path"] . '"><img class="img_thumb" src="' . $item["img_path"] . '"></a>';
              echo '<p class="post_msg">' . $item["msg"] . '</p> </div>';
            }
            $post_count++;
          }
        }
        ?>
      </div>

      <!-- PAGES INDEX -->
      <?php
      if($_SESSION["ppp"]!=0){
        echo '<div class="page_index">';
        if($_GET["page"]>0){
          echo '<a href="?page=' . ($_GET["page"]-1) . '"><<a> ';
        }
        for($i = 0; $i <= round(count($array["instadb"])/$_SESSION["ppp"]); $i++){
          echo '<a href="?page=' . $i . '">' . ($i+1) . '<a> ';
        }
        if(($_GET["page"])<round(count($array["instadb"])/$_SESSION["ppp"])){
          echo '<a href="?page=' . ($_GET["page"]+1) . '">><a> ';
        }
        echo '</div>';
      }
       ?>
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
