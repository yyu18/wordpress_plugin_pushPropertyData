<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; ");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php')) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
}



if(isset($_POST["data"])){

    $post_name = $_POST["data"]["post"]["post_name"];
    $post_type = $_POST["data"]["post"]["post_type"];
    $post_meta = $_POST["data"]["post_meta"];

    $args = array("post_type" => $post_type,"name"=> $post_name);
    $post = get_posts( $args );
    if(empty($post)){
        $new_post_info = array();
        foreach($_POST["data"]["post"] as $key=>$value) {
            if($key==="ID") continue;
            $new_post_info[$key] = $value;
        }
        wp_insert_post($new_post_info);
        $new_post_id = get_posts( array("post_type" => $post_type,"name"=>$new_post_info["post_name"]) )[0]->ID;

        foreach($post_meta as $key=>$value) {
            update_post_meta($new_post_id,$key,$value[0]);
        }
        $response["message"] = "post created";

        echo json_encode($response);
        return;
    }
    $post_id = $post[0]->ID;
    //update_post_meta($post_id,)

    foreach($post_meta as $key=>$value) {
        update_post_meta($post_id,$key,$value[0]);
    }

    $response["message"] = "post updated";

    echo json_encode($response);
    return;
}

if(isset($_GET['data'])) {
    $response["message"] = $_GET;
    $response["error"] = false;
    
    return;
}