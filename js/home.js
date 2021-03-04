$(document).ready(function () {
  console.log("ready");
  var limit = 5;
  var start = 0;
  var action = "inactive";

  $("#submit").click(async function () {
    var form_data = new FormData();
    var title_post = $("#title_post").val();
    var post = $("#post").val();
    var target = $("#image_preview");
    var count_img = target.find(".img-responsive").length;
    console.log(count_img);
    if (count_img != 0) {
      for (var i = 0; i < count_img; i++) {
        let tag = target.find(".img-responsive")[i];
        let img_src = $(tag).attr("src");
        await fetch(img_src)
          .then((res) => res.blob())
          .then((blob) => {
            const file = new File([blob], "pic.png", blob);
            console.log(file);
            form_data.append("files[]", file);
          });
      }
    }
    form_data.append("total_files", count_img);
    if (title_post != "" && title_post != null && post != "" && post != null) {
      var datetime = new Date();
      var date = formatdata(datetime);
      console.log("form_data>>>", form_data);
      form_data.append("date", date);
      form_data.append("title", title_post);
      form_data.append("post", post);
      form_data.append("cmd", "add-multi-img");
      $.ajax({
        url: BASE_URL + "home/cmd.php",
        method: "POST",
        data: form_data,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (response) {
          console.log(response);
          if (response.status == "success") {
            var htmlBuild = add_post(response);
            $("#mypost").prepend(htmlBuild);
            $("#post").val("");
            $("#title_post").val("");
            $("#image_preview").empty();
            $("#add_img").val("");
            $("#no_data_message").hide();

            initEventDeletePost();
          } else {
            console.log("error");
          }
        },
      });
    } else {
      Swal.fire("กรุณาใส่ข้อความ");
    }
  });

  initEventDeletePost();
  function loadData(limit, start) {
    $.ajax({
      type: "GET",
      url: BASE_URL + "home/cmd.php",
      data: {
        cmd: "get-data-post",
        offset: start,
        perpage: limit,
      },
      dataType: "json",
      success: function (response) {
        console.log("res_load", response.data);
        var dataArray = response.data;
        var arrayLength = dataArray.length;
        if (arrayLength == 0) {
          console.log("NO data");
          $("#load_data_message").hide();
        } else {
          $("#no_data_message").hide();
          var data = { data: [] };
          data.data = response.data.splice(0, limit);
          var htmlBuild = add_post(data);
          $("#mypost").append(htmlBuild);
          if (arrayLength > limit) {
            $("#load_data_message").show();
            action = "inactive";
          } else {
            $("#load_data_message").hide();
            action = "active";
          }
          initEventDeletePost();
        }
      },
    });
  }

  if (action == "inactive") {
    action = "active";
    loadData(limit, start);
  }

  $(window).scroll(function () {
    if (
      $(window).scrollTop() + $(window).height() > $("#mypost").height() &&
      action == "inactive"
    ) {
      action = "active";
      start = start + limit;
      setTimeout(function () {
        loadData(limit, start);
      }, 1000);
    }
  });
});

function initEventDeletePost() {
  $(".delete-post").unbind("click");
  $(".delete-post").click(function () {
    swal({
      title: "คุณแน่ใจที่จะลบโพสต์นี้ใช่ไหม?",
      icon: "warning",
      buttons: true,
      buttons: ["ยกเลิก", "ตกลง"],
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        console.log("delete");
        var post_id = $(this).attr("postid");
        console.log(post_id);
        $.ajax({
          url: BASE_URL + "home/cmd.php",
          type: "POST",
          data: {
            cmd: "delete-post-data",
            post_id: post_id,
          },
          dataType: "json",
          success: function (response) {
            if (response.status == "success") {
              swal("โพสต์ถูกลบแล้ว", {
                icon: "success",
              });
              console.log(response.data);
              $("#card" + response.data_postId).remove();
            }
            console.log("error");
            console.log(response);
          },
        });
      }
    });
  });
}

function add_post(dataRes) {
  var html = "";
  for (i in dataRes.data) {
    html += `
  <div class="card" id =card${dataRes.data[i].post_id}>
    <div class="col">
      <div class="box_title">
        ${dataRes.data[i].title}
      </div>
    </div>
    <div class="col">
      <div class="linepost"></div>
    </div>
    <div class="col">
      <div class="box_post">
        ${dataRes.data[i].post}
      </div>
    </div>
    <div class="col">
      <div id = "img_post" class="img_post">`;
    let data_img = dataRes.data[i].post_img;
    for (x in data_img) {
      html += `<img class="img-responsive" src="${
        BASE_URL + dataRes.data[i].post_img[x].post_img
      }">`;
    }
    html += `
      </div>
    </div>
      <div class="post_detail">
        <div class="post_detail">
          <div class="post_ago">
            <div class="timeago" ">
              ${dataRes.data[i].time_ago}
            </div>
          </div>
          <div class="post_on">
            <i class="far fa-calendar-alt fa-lg"></i>&nbsp
            ${dataRes.data[i].time_post}
          </div>
          <div class="post_by">
            <img width="25" src="${
              BASE_URL + dataRes.data[i].img_profile
            }" alt="">
            <a>&nbsp${dataRes.data[i].username}</a>
          </div>
        </div>
      </div>
        <div class="btn-group">
          <button type="button" class="btn_dropdown dotIcon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-ellipsis-h"></i>
        </button>
      <div class="dropdown-menu dropdown-menu-right">
        <button class="dropdown-item delete-post" postId= ${
          dataRes.data[i].post_id
        } >ลบโพสต์</button>
      </div>
    </div>
  </div>`;
  }
  return html;
}

function formatdata(datetime) {
  dformat =
    [datetime.getFullYear(), datetime.getMonth() + 1, datetime.getDate()].join(
      "-"
    ) +
    " " +
    [datetime.getHours(), datetime.getMinutes(), datetime.getSeconds()].join(
      ":"
    );
  return dformat;
}

function preview_images() {
  var total_file = document.getElementById("add_img").files.length;
  console.log("preview");
  console.log("totle", total_file);
  for (let i = 0; i < total_file; i++) {
    $("#image_preview").append(
      "<div class='preview_img'id='preview_img' style='position: relative;'>" +
        " <img id=" +
        i +
        " width = '150px'class='img-responsive' src='" +
        URL.createObjectURL(event.target.files[i]) +
        "'>" +
        ` <button id="delete_img" class='delete_img' style="position: absolute; top: 11px; right: 12px;"><img src="${BASE_URL}stocks/svg/clear-black.png" alt="" class="delete_but"></button>` +
        "</div>"
    );
  }
  $(".delete_img").click(function () {
    $(this).parents(".preview_img").remove();
  });
}
