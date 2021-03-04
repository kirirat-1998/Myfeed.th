<?php

use OMCore\OM;
use OMCore\OMDb;

if (isset($_REQUEST['cmd'])) {
    $cmd = $_REQUEST['cmd'];
} else {
    $cmd = "";
}

date_default_timezone_set('Asia/Bangkok');  

if ($cmd == "logout") {
    setcookie("user", '', time() - 86400, "/");
    $result['status'] = "success";
    echo json_encode($result);
} else if ($cmd == "get-data-cookie") {
    $datacookie = $_COOKIE['user'];
    $data = unserialize($datacookie);
    echo json_encode($data);
} else if ($cmd == 'get-data-post') {
    $DB = new OMDatabase();
    $res = array();
    $sql_param = array();
    $datacookie = $_COOKIE['user'];
    $data = unserialize($datacookie);
    $offset = $_GET['offset'];
    $perpage = $_GET['perpage'] + 1;
    $sql_param['user_id'] = $data['id'];

    $dt1 = "";
    $sql = "SELECT * FROM data_post dp inner join user u on u.user_id = dp.user_id where u.user_id=@user_id order by post_id desc limit " . $offset . "," . $perpage;
    $r1 = $DB->query($dt1, $sql, $sql_param, 0, -1, "ASSOC");
    for ($i = 0; $i < count($dt1); $i++) {
        $sql_param_img['post_id'] = $dt1[$i]['post_id'];
        $sql = "SELECT * FROM img_post where post_id = @post_id";
        $r1 = $DB->query($dt_img, $sql, $sql_param_img, 0, -1, "ASSOC");
        $dt1[$i]["post_img"] = $dt_img;
        $time_post = $dt1[$i]['time_post'];
        $time_ago = timeAgo($time_post);
        $dt1[$i]["time_ago"] =  $time_ago;
        
    }
    if ($r1 >= 0) {
        $res["data"] = $dt1;
    } else {
        $res["status"] = "error";
        $res["error_msg"] = "QUERY ERROR";
    }
    echo json_encode($res);
} else if ($cmd == 'load-data-header') {
    $DB = new OMDatabase();
    $res = array();
    if (isset($_COOKIE['user'])) {
        $datacookie = $_COOKIE['user'];
        $data = unserialize($datacookie);
        $sql_param['user_id'] = $data['id'];
        $sql = "SELECT * FROM user where user_id =@user_id";
        $r1 = $DB->query($dt, $sql, $sql_param, 0, -1, "ASSOC");
        if ($r1 >= 0) {
            $res["data"] = $dt;
            $res["status"] = "success";
        } else {
            $res["status"] = "error";
            $res["error_msg"] = "QUERY ERROR";
        }
        echo json_encode($res);
    } else {
        $res["status"] = "Nodata";
        echo json_encode($res);
    }
} else if ($cmd == 'add-multi-img') {
    $dir = ROOT_DIR . 'stocks/post_img/';

    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
    $DB = new OMDatabase();
    $res = array();
    $sql_param = array();

    $datacookie = $_COOKIE['user'];
    $dataCook = unserialize($datacookie);
    $id = $dataCook['id'];
    $title = isset($_POST['title']) ? $_POST['title'] : "";
    $post = isset($_POST['post']) ? $_POST['post'] : "";
    $date = isset($_POST['date']) ? $_POST['date'] : "";
    $total_files = isset($_POST['total_files']) ? $_POST['total_files'] : "";

    $sql_param['user_id'] = $id;
    $sql_param['title'] = $title;
    $sql_param['post'] = $post;
    $sql_param['time_post'] = $date;
    $insert_id = -1;
    $r = $DB->executeInsert("data_post", $sql_param, $insert_id);

    $dataDetail = array();
    $dataDetail['post_id'] = $insert_id;
    $dataDetail['title'] =  $title;
    $dataDetail['post'] =  $post;
    $dataDetail['time_post'] =  $date;
    $dataDetail['img_profile'] = $dataCook['img_profile'];
    $dataDetail['username'] = $dataCook['username'];
    if ($total_files != 0) {

        for ($count = 0; $count < $total_files; $count++) {
            $sql_param2 = array();
            $typeFile = substr( $_FILES['files']["type"][$count],6);
            $newfilename = date("Ymdhis_") . rand(round(microtime(true)), round(microtime(true)) * 1000) . '.' . $typeFile;
            move_uploaded_file($_FILES['files']['tmp_name'][$count], $dir . $newfilename);
            $sql_param2['post_id'] = $insert_id;
            $sql_param2['post_img'] = '/stocks/post_img/' . $newfilename;
            $r2 = $DB->executeInsert("img_post", $sql_param2);
            $data_img = $sql_param2['post_img'];
            $dataArray[$count]['post_img'] = $data_img;
        }

        $dataDetail['post_img'] = $dataArray;
    } else {
        $dataDetail['post_img'] = [];
    }
    $time_ago = timeAgo($date);
    $dataDetail['time_ago'] = $time_ago;
    $dataAll[] = $dataDetail;
    $res["data"] = $dataAll;
    $res["status"] = "success";
    echo json_encode($res);
}else{
    $post_id = $_POST['post_id'];
    $res = null;
    $DB	= new OMDatabase();
    $sql_params["post_id"] = $post_id;
    $sql = "DELETE dp.* ,imp.* FROM data_post dp left join img_post imp on dp.post_id = imp.post_id WHERE dp.post_id = @post_id";
    $r = $DB->execute($sql,$sql_params);
    if($r >= 0){
        $res["status"] = "success";
        $res["data_postId"] = $post_id;
    }else{
        $res["status"] = "error";
        $res["error_msg"] = "QUERY ERROR";
    }
    echo json_encode($res);
}

function timeAgo($timestamp)  
 {    
      $time_ago = strtotime($timestamp);  
      $current_time = time(); 
      $time_difference = $current_time - $time_ago;  
      $seconds = $time_difference;  
      $minutes      = round($seconds / 60 );           // value 60 is seconds  
      $hours           = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec  
      $days          = round($seconds / 86400);          //86400 = 24 * 60 * 60;  
      $weeks          = round($seconds / 604800);          // 7*24*60*60;  
      $months          = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
      $years          = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60  
      if($seconds <= 60)  
      {  
     return "เมื่อสักครู่";  
   }  
      else if($minutes <=60)  
      {  
     if($minutes==1)  
           {  
       return "1 นาที";  
     }  
     else  
           {  
       return "$minutes นาที";  
     }  
   }  
      else if($hours <=24)  
      {  
     if($hours==1)  
           {  
       return "ชั่วโมงที่ผ่านมา";  
     }  
           else  
           {  
       return "$hours ชม.";  
     }  
   }  
      else if($days <= 7)  
      {  
     if($days==1)  
           {  
       return "เมื่อวานนี้";  
     }  
           else  
           {  
       return "$days วันที่ผ่านมา";  
     }  
   }  
      else if($weeks <= 4.3) 
      {  
     if($weeks==1)  
           {  
       return "สัปดาห์ที่ผ่านมา";  
     }  
           else  
           {  
       return "$weeks สัปดาห์ที่ผ่านมา";  
     }  
   }  
       else if($months <=12)  
      {  
     if($months==1)  
           {  
       return "เดือนที่แล้ว";  
     }  
           else  
           {  
       return "$months เดือนที่แล้ว";  
     }  
   }  
      else  
      {  
     if($years==1)  
           {  
       return "ปีที่แล้ว";  
     }  
           else  
           {  
       return "$years ปีที่แล้ว";  
     }  
   }  
 }  



// if ($total_files != 0) {

//     for ($count = 0; $count < count($_FILES['files']["name"]); $count++) {
//         $sql_param2 = array();
//         $typeFile = explode(".", $_FILES['files']["name"][$count]);
//         $extension = end($typeFile);
//         $newfilename = rand(100000000, 999999999) . '.' . $extension;
//         move_uploaded_file($_FILES['files']['tmp_name'][$count], $dir . $newfilename);
//         // $sql_param2['post_id_img'] = $post_id;
//         $sql_param2['post_id_img'] = $insert_id;
//         $sql_param2['post_img'] = '/stocks/post_img/' . $newfilename;
//         $r2 = $DB->executeInsert("img_post", $sql_param2);
//         $data_img = $sql_param2['post_img'];
//         $dataArray[] = $data_img;
//     }
//     $datacookie = $_COOKIE['user'];
//     $dataCook = unserialize($datacookie);
   
//     // for ($count = 0; $count < count($dt3); $count++) {
//     //     $data_img = $dt3[$count]['post_img'];
//     //     $dataArray[] = $data_img;
//     // }
//     $dataDetail['post_id'] = $insert_id;
//     $dataDetail['title'] =  $title;
//     $dataDetail['post'] =  $post;
//     $dataDetail['time_post'] =  $date;
//     $dataDetail['img_profile'] = $dataCook['img_profile'];
//     $dataDetail['username'] = $dataCook['username'];
//     $dataDetail['post_img'] = $dataArray;
//     $dataAll[] = $dataDetail;
//     var_dump($dataAll);

//     if ($r3 >= 0) {
//         $res["data"] = $dataAll;
//         $res["status"] = "success";
//     } else {
//         $res["status"] = "error";
//         $res["error_msg"] = "QUERY ERROR";
//     }
// } else {
//     $sql_param['user_post_id'] = $id;
//     $sql = "SELECT * FROM data_post inner join user on user.user_id = data_post.user_post_id where user_post_id=@user_post_id order by time_post desc limit 1";
//     $r3 = $DB->query($dt4, $sql, $sql_param, 0, -1, "ASSOC");
//     $dt4[0]['post_img'] = "0";
//     if ($r3 >= 0) {
//         $res["data"] = $dt4;
//         $res["status"] = "success";
//     } else {
//         $res["status"] = "error";
//         $res["error_msg"] = "QUERY ERROR";
//     }
// }

// echo json_encode($res);
