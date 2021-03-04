
$(document).ready(function () {
  console.log("ready");
  $('#logout').click(function (e) { 
    e.preventDefault();
    $.ajax({
      url: BASE_URL + "home/cmd.php",
      method: "get",
      data: {
        cmd: "logout",

      },
      dataType: "json",
      success: function (result) {
        console.log("result",result);
        if(result.status == "success"){
          location.reload();
          window.location.href = BASE_URL + "login";
        }else{
          console.log("error");
        }
      },
    });
  });
});