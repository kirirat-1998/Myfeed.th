<?php

use OMCore\OM;
use OMCore\OMDb;

if (isset($_REQUEST['cmd'])) {
    $cmd = $_REQUEST['cmd'];
} else {
    $cmd = "";
}
   

if ($cmd == "get-list-user") {
    $DB = new OMDatabase();
    $res = array();
    $datacookie = $_COOKIE['user'];
    $data = unserialize($datacookie);
    $sql_param['user_id'] = $data['id'];
    // $offset = $_POST['offset'];
    // $perpage = $_POST['perpage'];
    $dt = "";

    // $sql = "SELECT user_id, username , firstname , lastname ,img_profile FROM user where not user_id = @user_id  limit " . $offset . "," . $perpage;
    $sql = "SELECT user_id, username , firstname , lastname ,img_profile FROM user where not user_id = @user_id" ;
    $r = $DB->query($dt, $sql, $sql_param,0, -1, "ASSOC");
    if($r >= 0){
        $res["status"] = "success";
        $res["data"] = $dt;
    }else{
        $res["status"] = "error";
        $res["error_msg"] = "QUERY ERROR";
    }
    
    echo json_encode($res);
} else if ($cmd == "send-request-friend"){
    $DB = new OMDatabase();
    
    if($_POST['action'] == 'send_request'){
        $datacookie = $_COOKIE['user'];
        $data = unserialize($datacookie);
        $sql_param = array();
        $sql_param['request_from_id'] = $data['id'];
        $sql_param['request_to_id'] = $_POST['to_id'];
        $sql_param['request_status'] = 'Pending';
        $r = $DB->executeInsert("friend_request",$sql_param);
        if($r >= 0){
            $res["status"] = "success";
            $res["data"] = $sql_param;
        }else{
            $res["status"] = "error";
            $res["error_msg"] = "QUERY ERROR";
        }
        echo json_encode($res);
    }
    
}else if($cmd == "get-relation-user"){
    $DB = new OMDatabase();
    $datacookie = $_COOKIE['user'];
    $data = unserialize($datacookie);
    $sql_param['user_id'] = $data['id'];
    $sql = "SELECT * FROM friend_request frq INNER JOIN user u  ON u.user_id = frq.request_from_id  WHERE u.user_id = @user_id" ;
    $r = $DB->query($dt, $sql, $sql_param,0, -1, "ASSOC");
    if($r >= 0){
        $res["status"] = "success";
        $res["data"] = $dt;
    }else{
        $res["status"] = "error";
        $res["error_msg"] = "QUERY ERROR";
    }
    echo json_encode($res);
}
