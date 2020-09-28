<?php
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php')) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
}

if(file_exists(ABSPATH.'wp-content/plugins/plugin-propertyDataPush/api/includes/functions_config.php')){
    require_once(ABSPATH.'wp-content/plugins/plugin-propertyDataPush/api/includes/functions_config.php');
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; ");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];
parse_str(file_get_contents("php://input"),$request);

switch ($method) {
    case 'PUT':
      update_config_data($request);
      break;
    case 'POST':
      create_config($request);  
      break;
    case 'DELETE':
      delete_config($request);  
      break;
    default:
      error_handler($request);
      break;
  }