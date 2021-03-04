$(document).ready(function () {
  console.log("ready");
  $("#username").keyup(function () {
    let input = $("#username").val();
    $("#username").val(checkSpace(input));
    borderInput("#username");
  });

  $("#password").blur(function () {
    borderInput("#password");
  });
  $(':input[type="submit"]')
    .prop("disabled", true)
    .addClass("submit_dis")
    .removeClass("submit");
  $("input").keyup(function () {
    if ($("#username").val() && $("#password").val() != "") {
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
  
  let input = document.getElementById("password");
  input.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
      event.preventDefault();
      document.getElementById("sub_login").click();
    }
  });
  $(':input[type="submit"]').click(postLoginData);
});

function postLoginData(){
  var username = $("#username").val().toLowerCase();
  var password = $("#password").val();
  $.ajax({
    url: BASE_URL + "login/cmd.php",
    method: "post",
    data: {
      cmd: "login",
      username: username,
      password: password,
    },
    dataType: "json",
    success: function (result) {
      console.log("result",result);
      if(result.status == "success"){
        location.reload();
        window.location.href = BASE_URL + "home";
      }else{
        Swal.fire({
          icon: 'error',
          text: 'Username หรือ Password ผิดกรุณาลองใหม่',
        })
      }
    },
  });
}
function borderInput(keyword) {
  var input = $(keyword).val();
  if (input == "") {
    $(keyword).css("border", "1px solid red");
  } else {
    $(keyword).css("border", "1px solid #ced4da;");
  }
}
function checkSpace(value) {
  return value.replace(/(^\s+|\s+$)/g, "");
}