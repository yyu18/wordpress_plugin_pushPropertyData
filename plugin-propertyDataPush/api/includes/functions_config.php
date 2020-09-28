<?php
//Get header Authorization
function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }
//get access token from header 
function getBearerToken() {
    $headers = getAuthorizationHeader();
    // HEADER: Get the access token from the header
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

//update config data
function update_config_data($request){
    $id = $request["id"];
    $data = create_config_data($request);

    global $wpdb;
    $table_name = $wpdb->prefix . 'push_config';
    $result = $wpdb->update($table_name, array('config' => $data),array('id'=>$id));
    update_option("Property_Endpoint_".$id."",$data); 
    echo 1;
    return;
}

function create_config_data($request) {
    return '{ 
        "property_url":"'.trim($request["url"]).'",
        "property_type":"'.trim($request["type"]).'", 
        "property_status":"'.trim($request["status"]).'",
        "property_feature":"'.trim($request["feature"]).'",
        "property_labels":"'.trim($request["labels"]).'",
        "property_city":"'.trim($request["city"]).'"
    }';
}

//create config endpoint
function create_config($request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'push_config';
    $key_name = 'Property_Endpoint_'.$request["data"].'';

    $row = $wpdb->get_results("SELECT * FROM $table_name WHERE key_name = '$key_name'");
    if(!$row) {
        $result = $wpdb->insert($table_name, array('key_name' => $key_name, 'config' => '{}','config_status'=>true));
        if($result) {
            add_option($key_name,'');
            echo 1;
            return;
        }
        echo 0;
        return;
    }
    $id = $row[0]->id;
    $wpdb->update($table_name,array('config_status'=>true),array('id'=>$id));
    echo 1;
    return;
}

//delete config endpoint
function delete_config($request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'push_config';
    $key_name = 'Property_Endpoint_'.$request["data"].'';
    $id = $request["data"];
    $row = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$id'");
    if(!$row) {
        echo 1;
        return;
    }

    $wpdb->update($table_name,array('config_status'=>false),array('id'=>$id));

    echo 1;
    return;
}

//error handler
function error_handler() {
    $response["message"] = "method not allowed";
    echo json_encode($response);
    return;
}    