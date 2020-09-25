<?php
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php')) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
}
    if(isset($_POST['Property_Endpoint_1_url'])){
        $data_row_number = count($_POST)/5;
        global $wpdb;
        $table_name = $wpdb->prefix . 'push_config';
        for($i=1;$i<=$data_row_number;$i++) {
            $data = '{ 
                "property_url":"'.trim($_POST["Property_Endpoint_".$i."_url"]).'",
                "property_type":"'.trim($_POST["Property_Endpoint_".$i."_type"]).'", 
                "property_status":"'.trim($_POST["Property_Endpoint_".$i."_status"]).'",
                "property_feature":"'.trim($_POST["Property_Endpoint_".$i."_feature"]).'",
                "property_labels":"'.trim($_POST["Property_Endpoint_".$i."_labels"]).'",
                "property_city":"'.trim($_POST["Property_Endpoint_".$i."_city"]).'"
            }';

            $result = $wpdb->update($table_name, array('config' => $data),array('key_name'=>"Property_Endpoint_".$i.""));
            update_option("Property_Endpoint_".$i."",$data);        
            continue;
        }

        echo "Config Info Updated";
        return;
    }

    if(isset($_POST['createURL'])){
        global $wpdb;
        $table_name = $wpdb->prefix . 'push_config';
        $key_name = 'Property_Endpoint_'.$_POST['createURL'].'';
        $result = $wpdb->insert($table_name, array('key_name' => $key_name, 'config' => '{}'));
        if($result) {
            add_option($key_name,'');
            echo "Engpoint added, please refresh page";
            return;
        }
        echo 0;
        return;
    }

    if(isset($_POST['deleteURL'])){
        global $wpdb;
        $table_name = $wpdb->prefix . 'push_config';
        $key_name = 'Property_Endpoint_'.$_POST['deleteURL'].'';
        $result = $wpdb->delete($table_name, array('key_name' => $key_name));
        if($result) {
            delete_option($key_name);
            echo "Engpoint Deleted, please refresh page";
            return;
        }
        echo 0;
        return;
    }