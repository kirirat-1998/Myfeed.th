<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('system/common.php');


// if(isset($_COOKIE[COOKIE_LOGIN_NAME])){
// 	header("Location: ".WEB_META_BASE_URL."register");
// 	exit();
// }else{
// 	$_controllerPath = ROOT_DIR ."controllers/". OMCore\OMRoute::path() . '.php';
// }


$_controllerPath = ROOT_DIR ."controllers/". OMCore\OMRoute::path() . '.php';

// echo "config: " .WEB_INDEX_PAGE;
// echo "<br />";
// $smarty->assign("WINDOW_TITLE" ,"test naja");

if(is_file($_controllerPath)) {

	include TMPL_DIR .'core/master.tpl';

}else{
	http_response_code(404);
	OMCore\OMRoute::notFound();
	// $smarty  = new OMPage();
	// $smarty->display('404');
}

?>




