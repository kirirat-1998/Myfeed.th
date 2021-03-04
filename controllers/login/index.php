<?php
$OMPage->var["window_title"] = "login";
$PAGE_VAR["css"][] = "login";
$PAGE_VAR["js"][] = "login";

if (isset($_COOKIE['user'])){
    header("location:" . WEB_META_BASE_URL . "home");
}
?>

<div>
    <div class="container_over">
        <div class="header_login">
            เข้าสู่ระบบ
        </div>
    

            <div id="body_login" class="body_login">
                <div class="row">
                    <div class="col">
                        <div class="input_title">
                            username
                        </div>
                        <input id="username" type="text" class="input_login" maxlength="30">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="input_title">
                            password
                        </div>
                        <input id="password" type="password" class="input_login" minlength="6" maxlength="15">
                    </div>
                </div>
                <button id = "sub_login"type="submit" class="submit">เข้าสู่ระบบ</button>
                <div class="new_account">ยังไม่ได้เป็นสมาชิกใช่หรือไม่ <a href="<?= WEB_META_BASE_URL ?>register" class="create_account">สมัครใหม่</a>

                </div>

            </div>
        
    </div>
</div>
