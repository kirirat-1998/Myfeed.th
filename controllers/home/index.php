<?php
// var_dump($_COOKIE['user']);
// var_dump(unserialize($_COOKIE['user']))
// $test = unserialize($_COOKIE['user']);
// var_dump($test['firstname']);
$OMPage->var["window_title"] = "home";
$PAGE_VAR["css"][] = "home";
$PAGE_VAR["js"][] = "home";

if (isset($_COOKIE['user'])) {
} else {
  header("location:" . WEB_META_BASE_URL . "login");
}
?>
<div class=body>
  <div class="row box_all">
    <div class="column">
      <div class="card">
        <h3>หัวข้อ</h3>
        <input type="text" class="title_post" id="title_post" placeholder="คุณกำลังคิดอะไรอยู่..." maxlength="50">
        <textarea class="boxpost" id="post" rows="3" maxlength="300" style="height: 130px;"></textarea>
        <div class="body_add_image">
          <div class="row image_preview" id="image_preview"></div>
          <label for="add_img" class="add_image">
            <i class="far fa-image fa-lg">
            </i>
            <span>&nbspรูปภาพ</span>
          </label>
          <input type="file" class="form-control" id="add_img" name="images[]" onchange="preview_images();" multiple accept="image/*" />

        </div>
      </div>
      <button id="submit" type="submit" name="submit_post" class="submit">โพสต์</button>
    
    </div><br>

    <div id="mypost" class="mypost">

    </div>
    <div class="message_box">
      <div id="load_data_message" class="load_data_message">
        <i class='fas fa-circle-notch fa-spin'> </i>
        กำลังโหลดข้อมูล...
      </div>
      <div id="no_data_message" class="no_data_message" style="color: #6560609a;">
        ไม่มีข้อมูลโพสต์
      </div>
    </div>
    

  </div><br>
  

</div>