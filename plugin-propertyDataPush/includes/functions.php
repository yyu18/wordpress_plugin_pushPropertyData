<?php

function term_value_add($id,$name) {
    if(get_the_terms($id,$name)){
        return get_the_terms($id,$name);
    } 
    return "";
}

function property_value_check($array,$value) {
    if($array=="") {
        if($array == $value) return true;
        return false;
    }
    foreach($array as $index=>$v) {
        if($v->name==$value) return true;
    }
    return false;
}

function create_rule($rule_data) {
    return array(
        "property_url"=> $rule_data->property_url,
        "property_type"=> $rule_data->property_type,
        "property_status"=> $rule_data->property_status,
        "property_feature"=> $rule_data->property_feature,
        "property_labels"=> $rule_data->property_labels,
        "property_city"=> $rule_data->property_city
    );
}

function create_property($post_after){
    return array (
        "post" => $post_after,
        "post_meta"=>get_post_meta($post_after->ID),
        "type"=> term_value_add( $post_after->ID, 'property_type' ), 
        "status"=>term_value_add( $post_after->ID, 'property_status' ), 
        "feature"=>term_value_add( $post_after->ID, 'property_feature' ), 
        "label"=>term_value_add( $post_after->ID, 'property_label' ), 
        "city"=>term_value_add( $post_after->ID, 'property_city' ), 
        "area"=> term_value_add( $post_after->ID, 'property_area' ), 
        "state"=>term_value_add( $post_after->ID, 'property_state' )
    );
}

function is_rule_correct($property,$rule){
    return property_value_check($property["type"],$rule["property_type"])&&
    property_value_check($property["status"],$rule["property_status"])&&
    property_value_check($property["feature"],$rule["property_feature"])&&
    property_value_check($property["labels"],$rule["property_labels"])&&
    property_value_check($property["city"],$rule["property_city"]);
}

