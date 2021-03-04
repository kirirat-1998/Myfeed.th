$(document).ready(function () {
  console.log("ready");
  $("#notMatch").hide();
  $("#shortPass").hide();
  $("#notEmail").hide();
  $("#notTel").hide();

  $("#username").keyup(function () {
    let input = $("#username").val();
    $("#username").val(checkSpace(input));
    borderInput("#username");
  });

  $("#password").blur(function () {
    
    var password = $("#password").val();
    var confirmPassword = $("#confirmPassword").val();
    
    if (password != confirmPassword || password.length == 0) {
      $("#confirmPassword,#password").css("border", "1px solid red");
    } else {
      $("#confirmPassword,#password").css("border", "1px solid ced4da;");
    }

    if (password.length < 6) {
      $("#shortPass").show();
      $("#password").css("border", "1px solid red");
    } else {
      $("#shortPass").hide();
      $("#password").css("border", "1px solid #ced4da;");
    }
  });

  $("#confirmPassword").blur(function () {
    var password = $("#password").val();
    var confirmPassword = $("#confirmPassword").val();
    if (password != confirmPassword) {
      $("#confirmPassword,#password").css("border", "1px solid red");
      $("#notMatch").show();
    } else {
      $("#confirmPassword,#password").css("border", "1px solid #ced4da;");
      $("#notMatch").hide();
    }

    if (password.length < 6) {
      $("#shortPass").show();
      $("#password").css("border", "1px solid red");
    } else {
      $("#shortPass").hide();
      $("#password").css("border", "1px solid #ced4da;");
    }
  });

  $("#firstname").blur(function () {
    borderInput("#firstname");
  });
  $("#lastname").blur(function () {
    borderInput("#lastname");
  });

  $("#email").keyup(function () {
    let input = $("#email").val();
    $("#email").val(checkSpace(input));
    if (checkEmail(this.value)) {
      $("#notEmail").hide();
      $("#email").css("border", "1px solid #ced4da;");
    } else {
      $("#notEmail").show();
      $("#email").css("border", "1px solid red");
    }
  });
  $("#tel").blur(function () {
    if (checkTel(this.value)) {
      $("#notTel").hide();
      $("#tel").css("border", "1px solid #ced4da;");
    } else {
      $("#notTel").show();
      $("#tel").css("border", "1px solid red");
    }
  });

  $("#tel").keyup(function (e) {
    let input = $("#tel").val();
    let value = input.replace(/[^0-9]/gi, "");
    $("#tel").val(value);
  });
  $(':input[type="submit"]')
    .prop("disabled", true)
    .addClass("submit_dis")
    .removeClass("submit");
  $("input").bind("click keyup change", function () {
    if (
      $("#username").val() &&
      $("#password").val() &&
      $("#confirmPassword").val() &&
      $("#firstname").val() &&
      $("#lastname").val() &&
      $("#sortpicture").val()&&
      checkEmail($("#email").val()) &&
      checkTel($("#tel").val()) != "" &&
      $("#password").val() == $("#confirmPassword").val() &&
      $("#password").val().length >= 6
    ) {
      $(':input[type="submit"]')
        .prop("disabled", false)
        .addClass("submit")
        .removeClass("submit_dis");
    } else {
      $(':input[type="submit"]')
        .prop("disabled", true)
        .addClass("submit_dis")
        .removeClass("submit");
    }
  });

  $("#confirmPassword").keyup(function () {
    if ($("#password").val() != $("#confirmPassword").val()) {
      $("#confirmPassword,#password").css("border", "1px solid red");
      // console.log('error')
    }
  });

  $(':input[type="submit"]').click(insertUserData);

  $("#sortpicture").change(function () {
    console.log(this.files);
    readURLimage(this);
  });
  
  });
  
  function readURLimage(input) {
    console.log(input.files);
    if (input.files && input.files[0]) {
      var reader = new FileReader();
  
      reader.onload = function (e) {
        $("#blah").attr("src", e.target.result);
      };
  
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }
  

function checkSpace(value) {
  return value.replace(/(^\s+|\s+$)/g, "");
}

function checkEmail(value) {
  var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
  return testEmail.test(value);
}

function checkTel(value) {
  var testTel = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;
  return testTel.test(value);
}

function borderInput(keyword) {
  var input = $(keyword).val();
  if (input == "") {
    $(keyword).css("border", "1px solid red");
  } else {
    $(keyword).css("border", "1px solid #ced4da;");
  }
}

function insertUserData() {
    var file_data = $("#sortpicture").prop("files")[0];
    var form_data = new FormData();
    var username = $("#username").val().toLowerCase();
    var password = $("#password").val();
    var firstname = $("#firstname").val();
    var lastname = $("#lastname").val();
    var email = $("#email").val();
    var phone = $("#tel").val();

    form_data.append("file", file_data);
    form_data.append("cmd", "register");
    form_data.append("username", username);
    form_data.append("password", password);
    form_data.append("firstname", firstname);
    form_data.append("lastname", lastname);
    form_data.append("email", email);
    form_data.append("phone", phone);
    $.ajax({
      url: BASE_URL + "register/cmd.php",
      method: "POST",
      data: form_data,
      dataType: "json",
      contentType: false,
      processData: false,
    success: function(result){
                if(result.status == "success" ){
                    console.log('result>>>',result);
                    console.log("Succes");
                    // alert ("ลงทะเบียนเรียบร้อย");
                    // Swal.fire('ลงทะเบียนเรียบร้อย')
                    swal({
                      title: "ลงทะเบียนเรียบร้อย",
                      icon: "success",
                      button: "ตกลง",
                    });
                    setTimeout(function () {
                      window.location.href = BASE_URL + "login";
                    }, 2000);
                }else{
                  swal({
                    title: "Username หรือ E-mail ได้มีการลงทะเบียนไว้แล้ว กรุณาลองใหม่",
                    button: "ตกลง",
                  });
                  // alert ("Username หรือ E-mail ได้มีการลงทะเบียนไว้แล้ว กรุณาลองใหม่");
                  console.log("Error");
                }
            }
    });
        
  }

