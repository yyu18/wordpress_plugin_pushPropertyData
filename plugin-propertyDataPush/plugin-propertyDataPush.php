<?php
/**
 * Plugin Name:       Property Data Push
 * Description:       Property Data Push
 * Version:           1.0.0
 * Author:            Hubert Yu
 * Text Domain:       my-basics-plugin
 */
require_once(ABSPATH.'wp-content/plugins/plugin-propertyDataPush/admin/class_property_data_push.php');
require_once(ABSPATH.'wp-content/plugins/plugin-propertyDataPush/admin/class_init_push_property.php');
require_once(ABSPATH.'wp-content/plugins/plugin-propertyDataPush/includes/functions.php');
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

$Property_Data_Push_Config = Property_Data_Push_Config::GetInstance();  
$Property_Data_Push_Config->InitPlugin();

register_activation_hook( __FILE__, 'my_plugin_create_db' );
function my_plugin_create_db() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'push_config';

	$sql = "CREATE TABLE $table_name (
        id MEDIUMINT NOT NULL AUTO_INCREMENT,
		key_name varchar(128) NOT NULL UNIQUE,
		config JSON,
        config_status BOOLEAN,
        PRIMARY KEY (id)
	) $charset_collate;";

    dbDelta( $sql );
}

register_deactivation_hook( __FILE__, 'my_plugin_drop_db' );
function my_plugin_drop_db() {
    global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'push_config';

    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);
}

add_action( 'save_post', 'push_property_data', 10, 2 );
function push_property_data($post_ID, $post_after){
    global $wpdb;
    $table_name = $wpdb->prefix . 'push_config';
    $row = $wpdb->get_results("SELECT * FROM $table_name WHERE config_status=true");
    if(!$row) return;
    $request_count = count($row);

    foreach($row as $value) {
        $rule_data = json_decode($value->config);
        $rule = create_rule($rule_data);
        $property = create_property($post_after);
        if( is_rule_correct($property,$rule)) {
            $url = $rule["property_url"];
            $response = wp_remote_post( $url, array(
                'method'      => 'POST',
                'timeout'     => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking'    => true,
                'headers'     => array(),
                'body'        => array(
                    'data' => $property,
                ),
                'cookies'     => array()
                )
            );

            if ( is_wp_error( $response ) ) {
                $error_message = $response->get_error_message();
                echo "<pre>Something went wrong: $error_message</pre>";
                continue;
            } 
        continue;
        }
    }
}
?> 