<?php
    use OMCore\OMDb;

    if (isset($_REQUEST['cmd'])) {
        $cmd = $_REQUEST['cmd'];
    } else {
        $cmd = "";
    }


    if ($cmd == "login"){
        $DB = new OMDatabase();
        $username  = isset($_POST['username']) ? $_POST['username'] : "";
        $password = isset($_POST['password']) ? $_POST['password'] : "";
        $hashed_password = HashMD5($password);

        $sql_check = "select * from user where username = @username and password = @password";
        $sql_check .= " limit 1";

        $sql_param_check = array();
        $sql_param_check['username'] = $username;
        $sql_param_check['password'] = $hashed_password;

        $dt = null;
        $res = $DB->query($dt, $sql_check, $sql_param_check, 0, -1, "ASSOC");
        if ($res > 0) {
            $user = array(
                'id' => $dt[0]['user_id'],
                'username' => $dt[0]['username'],
                'img_profile'=> $dt[0]['img_profile']
            );
        
            $simple_string = serialize($user);
            setcookie("user", $simple_string , time() + 36000, "/");
            $result['status']="success";
            $result['data']=$dt;
            // $value = base64_encode($simple_string)
            // var_dump($value);
            // $token = createToken();
            // $session = createSessionID();
            
            // exit();
            // $sql_param_insert = array();
            // $sql_param_insert['session'] = $session;
            // $sql_param_insert['token'] = $token;
            // $sql_param_insert['user_id'] = $user["id"];
            // $r = $DB->executeInsert('auth_tokens', $sql_param_insert);
            // setcookie("XXXX")   
        } else {
          $result['status']="error";
        }
        echo json_encode($result);
    }
   else if ($cmd == "logout"){
    setcookie("user", '' , time() - 86400, "/");
    $result['status']="success";
        echo json_encode($result);
    }

     
    function HashMD5($data)
    {
        return md5($data);
    }

    function createToken()
    {
        $string = "kjpPIHEI92384yj23l7yGL2jhfiuh98fhjhl9film";

        return substr(str_shuffle($string), 0, 16);
    }

    function createSessionID()
    {
        $string = "kashjfipLKJHSofe7haiohcjbl7iuel9hiasb873b38hfo";

        return base64_encode(substr(str_shuffle($string), 0, 30));
    }


    function createCookie($data, $serial, $token)
    {
        setcookie("user", $data, time() + 31556926, "/");
        setcookie("session", $serial, time() + 31556926, "/");
        setcookie("token", $token, time() + 31556926, "/");
        return true;
    }
?>
