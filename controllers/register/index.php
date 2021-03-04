<?php
$OMPage->var["window_title"] = "Register";
$PAGE_VAR["css"][] = "register";
$PAGE_VAR["js"][] = "register";
?>


<div class="container_over">
    <div class="head_register">
        ลงทะเบียน
    </div>
    <div class="line"></div>
    <!-- image body -->
    <div class="body_register">
        <div class="body_image">
            <img width="30px" id="blah" src="<?= WEB_META_BASE_URL ?>stocks/svg/profile-user.png" alt="your image" class="show_image" />
            <label for="sortpicture" class="custom_upload">
                <img src="<?= WEB_META_BASE_URL ?>stocks/svg/photo-camera.png" width="25px" />
            </label>
            <input type='file' id="sortpicture" accept="image/*" />
        </div>
        <!-- register body -->
        <div class="register_title">
            ข้อมูลสำหรับเข้าสู่ระบบ
        </div>
        <div class="row">
            <div class="col-sm">

                <div class="input_title">
                    username
                </div>
                <input id="username" type="text" class="input_register" maxlength="30">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 box_pass">
                <div class="input_title">
                    password

                </div>
                <div>
                    <input id="password" type="password" class="input_register_small" minlength="6" maxlength="15">
                </div>
                <div id="shortPass" class="shortPass">รหัสผ่านสั้นเกินไป (6-15)</div>
            </div>
            <div class="col-sm-6 box_conpass">
                <div class="input_title">
                    confirmPassword
                </div>
                <div>
                    <input id="confirmPassword" type="password" class="input_register_small" minlength="6" maxlength="15">
                </div>
                <div id="notMatch" class="notMatch">รหัสผ่านไม่ตรงกัน</div>
            </div>
        </div>
        <!-- qrwrqwrqwrwqrrqwrqwr -->
        <div class="register_title">


            ข้อมูลส่วนตัว
            <div class="row">
                <div class="col-sm-6 box_fname">
                    <div class="detail_title">
                        FirstName
                    </div>
                    <input id="firstname" type="text" class="input_register_small">
                </div>
                <div class="col-sm-6 box_lname">
                    <div class="detail_title">
                        LastName
                    </div>
                    <input id="lastname" type="text" class="input_register_small">
                </div>
            </div>
            ข้อมูลการติดต่อ
            <div class="row">
                <div class="col-sm-6 box_mail">
                    <div id="notEmail" class="notEmail">
                        อีเมลไม่ถูกต้อง
                    </div>
                    <div class="detail_title">
                        E-mail
                    </div>
                    <div>
                        <input id="email" type="e-mail" class="input_register">
                    </div>
                </div>
                <div class="col-sm-6 box_phone">
                    <div id="notTel" class="notTel">เบอร์โทรไม่ถูกต้อง</div>
                    <div class="detail_title">
                        Phone Number
                    </div>

                    <div>
                        <input id="tel" type="tel" class="input_register" maxlength="10">
                    </div>
                </div>
            </div>
        </div>
        <!-- qwrewgtqegwrgwrgwrg -->
    </div>
    <button type="submit" class="submit">สมัครสมาชิก</button>

    <div id="register_success" class="register_success">
        <div class="register_body">
            <div class="register_message">
                บันทึกข้อมูลเสร็จสิ้น
            </div>
            <div class="suc_body">
                <button id="suc_button" class="suc_button">
                    ตกลง
                </button>
            </div>
        </div>
    </div>

</div>
</div>

<!-- 
<div class="register_title">
    <div class="row">
        <div class="col-6">
            ข้อมูลส่วนตัว
        </div>
        <div class="col-6">
            ข้อมูลการติดต่อ
        </div>
    </div>
</div>

<div class="row">
    <div class="col-3">
        <div class="input_title">
            FirstName
        </div>
        <input id="firstname" type="text" class="input_register_small">
    </div>
    <div class="col-3">
        <div class="input_title">
            LastName
        </div>
        <input id="lastname" type="text" class="input_register_small">
    </div>
    <div class="col-6">
        <div id="notEmail" class="notEmail">
            อีเมลไม่ถูกต้อง
        </div>
        <div class="input_title">
            E-mail
        </div>
        <div>
            <input id="email" type="e-mail" class="input_register">
        </div>
        <div id="notTel" class="notTel">เบอร์โทรไม่ถูกต้อง</div>
        <div class="input_title">
            Phone Number
        </div>

        <div>
            <input id="tel" type="tel" class="input_register" maxlength="10">
        </div>

    </div> -->