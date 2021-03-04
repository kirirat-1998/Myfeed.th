$(document).ready(function () {
  console.log("ready");

  get_listUser();
  $(document).on("click", ".request_button", function () {
    var to_id = $(this).data("userid");
    add_freind_request(to_id);
  });
  get_relation_user();


});

function add_freind_request(data) {
  console.log(data);
  var action = "send_request";
  if (data > 0) {
    $.ajax({
      url: BASE_URL + "friend/cmd.php",
      type: "POST",
      data: {
        cmd: "send-request-friend",
        to_id: data,
        action: action,
      },
      beforeSend: function () {
        console.log("sendind");
        $("#request_button_" + data).attr("disabled", "disabled");
        // $("#request_button_" + data).html(
        //   '<i class="fa fa-circle-o-notch fa-spin"></i> Sending...'
        // );
      },
      success: function (res) {
        console.log(res);
        console.log("request");
        $("#request_button_" + data).html(
          '<i class="fa fa-clock-o" aria-hidden="true"></i> Request Send'
        );
      },
    });
  }
}
function get_listUser() {
  $.ajax({
    url: BASE_URL + "friend/cmd.php",
    type: "POST",
    data: {
      cmd: "get-list-user",
    },
    dataType: "json",
    success: function (res) {
      if (res.status == "success") {
        var listfriend = build_listUser(res.data);
        $("#list-friend").append(listfriend);
      } else {
        console.log("error");
      }
    },
  });
}

function build_listUser(data) {
  var html = "";
  for (i in data) {
    html += `
        <div class="wrapper-box">
            <div class = "group-list">
                <div class="row">
                    <div class="col-md-1 col-sm-3 col-xs-3 img_pro">
                        <img class = "img_profile_list_friend" src ="${data[i].img_profile}"></img>
                    </div>
                    <div class="col-md-7 col-sm-6 col-xs-5 name_fl">
                        ${data[i].firstname}&nbsp&nbsp${data[i].lastname}
                    </div>
                    <div class="col-md-4 col-sm-3 col-xs-4 box_button">
                        <button type="button" name="request_button" class="btn btn-primary request_button" id="request_button_${data[i].user_id}" data-userid=
                        ${data[i].user_id}><i class="fa fa-user-plus"></i> Add Friend</button>
                    </div>
                </div>
            </div>
        </div>
        `;
  }
  //   for (i in data.data) {
  //     html += `
  //         <div class="wrapper-box">
  //             <div class = "group-list">
  //                 <div class="row">
  //                     <div class="col-md-1 col-sm-3 col-xs-3 img_pro">
  //                         <img class = "img_profile_list_friend" src ="${data.data[i].img_profile}"></img>
  //                     </div>
  //                     <div class="col-md-7 col-sm-6 col-xs-5 name_fl">
  //                         ${data.data[i].firstname}&nbsp&nbsp${data.data[i].lastname}
  //                     </div>
  //                     <div class="col-md-4 col-sm-3 col-xs-4 box_button">
  //                         <button type="button" name="request_button" class="btn btn-primary request_button" id="request_button_${data.data[i].user_id}" data-userid=
  //                         ${data.data[i].user_id}><i class="fa fa-user-plus"></i> Add Friend</button>
  //                     </div>
  //                 </div>
  //             </div>
  //         </div>
  //         `;
  //   }
  return html;
}

function get_relation_user() {
  console.log("get rela friend");
  $.ajax({
    type: "GET",
    url: BASE_URL + "friend/cmd.php",
    data: {
      cmd: "get-relation-user",
    },
    dataType: "json",
    success: function (res) {
      for (i in res.data) {
        console.log(res.data[i].request_id);
        $("#request_button_" + res.data[i].request_to_id).html(
          '<i class="fa fa-clock-o" aria-hidden="true"></i> Request Send'
        );
        $("#request_button_" + res.data[i].request_to_id).attr(
          "disabled",
          "disabled"
        );
      }
    },
  });
}
