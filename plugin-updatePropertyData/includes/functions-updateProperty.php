<?php
//create new post info
function new_post_info($data) {
    $new_post_info = array();
    foreach($data as $key=>$value) {
        if($key==="ID") continue;
        $new_post_info[$key] = $value;
    }
    return $new_post_info;
}