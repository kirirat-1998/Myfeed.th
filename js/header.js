$(document).ready(function () {
  console.log("ready");
  $.ajax({
    type: "GET",
    url: BASE_URL + "home/cmd.php",
    data: {
      cmd: "load-data-header",
    },
    dataType: "json",
    success: function (response) {
      if(response.status == "success"){
        $("#logout-user-group").append(`
        <div class="body-pic-profile">
          <img id="profile_img" src="${response.data[0].img_profile}">
        </div>
        <div class ="username-nav">
          <span id="user-name-nav">${response.data[0].username}</span>
        </div>`);
      }else{
        console.log("no data from cookie");
        $('#logout-user-group').remove();
        $(".body-icon-logout").remove();
      }
      
    },
  });
});
