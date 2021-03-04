<?php

use OMCore\OMDb;

if (isset($_REQUEST['cmd'])) {
    $cmd = $_REQUEST['cmd'];
} else {
    $cmd = "";
}

if ($cmd == "register") {
    $DB = new OMDatabase();
    $res = array();
   
    // var_dump($_FILES["file"]);

    $dir = ROOT_DIR . '/stocks/users/';

    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }

    $typeFile = explode(".", basename($_FILES["file"]["name"]));
    $newfilename = round(microtime(true)) . '.' . end($typeFile);
    move_uploaded_file($_FILES['file']['tmp_name'], $dir . $newfilename);
    

    $username = isset($_POST['username']) ? $_POST['username'] : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : "";
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $phone = isset($_POST['phone']) ? $_POST['phone'] : "";
    
    $hashed_password = HashMD5($password);
    $sql_check = "select * from user where username = @username or email = @email";
	$sql_check .= " limit 1";

	$sql_param_check = array();
	$sql_param_check['username'] = $username;
	$sql_param_check['email'] = $email;

    $ds = null;
	$r = $DB->query($ds, $sql_check, $sql_param_check, 0, -1, "ASSOC");

    if($ds != "" && $ds != null){
        $res["status"] = "error";
		$res["error_msg"] = "QUERY ERROR";
        echo json_encode($res);
    }else{
        
        $sql_params = array();
        $sql_params['username']=$username;
        $sql_params['password']=$hashed_password;
        $sql_params['firstname']=$firstname;
        $sql_params['lastname']=$lastname;
        $sql_params['email']=$email;
        $sql_params['phone']=$phone;
        $sql_params['img_profile'] = '/stocks/users/'.$newfilename;
      

        $insert_id = -1;
	    $r = $DB->executeInsert("user",$sql_params,$insert_id);
        $userData = array();
        $userData['user_id'] = $insert_id;
        $userData['status'] = $r;
        $data[]=$userData;
        $res["status"] = "success";
		$res["data"] = $data;
        
    }
    echo json_encode($res);
}

function HashMD5($data)
{
    return md5($data);
}
?>