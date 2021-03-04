<?php
mb_internal_encoding("UTF-8");

// Define WEB_META_BASE_URL
$HTTP_REFERER = isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:'http://' . @$_SERVER["SERVER_NAME"] . '/';
list($HTTP_PROTOCAL) = explode(':', $HTTP_REFERER);
if(empty($HTTP_PROTOCAL)) $HTTP_PROTOCAL = 'http';

define("WEB_REWRITE_BASE",  "");
define("WEB_META_BASE_URL",  $HTTP_PROTOCAL."://" . @$_SERVER["SERVER_NAME"] .WEB_REWRITE_BASE. "/");
define("BASE_API",  "http://prospect-api.orisma.alpha/");
define("WEB_META_BASE_API",  BASE_API."v1/");
define("WEB_META_BASE_API_DOC",  BASE_API."doc/");
define("WEB_APP_CALL_API",  WEB_META_BASE_URL."service/call_api.php");
define("WEB_INDEX_PAGE",  "index");
define("LANG",  "");
define("WEB_META_BASE_LANG",  "");


define("COOKIE_DOMAIN", "." . @$_SERVER["SERVER_NAME"] );
define("ENCRYPT_INIT_KEY", "13579defabc12345");
define("ENCRYPT_INIT_VECTOR", "de12fa890c79b387");
define("MONGO_HOST", "localhost");
define("MONGO_PORT", "27017");
define("MONGO_DB", "SCB15B-PROSPECT");
define("ENABLE_LANG", false);
define("UID_LIFE_TIME", time() + 10*60*1000);
define("LIMIT_EXPORT_DATA", 3);


define("COOKIE_LOGIN_NAME", "USER_DATA" );


?>