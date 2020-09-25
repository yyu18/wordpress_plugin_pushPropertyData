<?php
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php')) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
}
class Init_Push_Property{
    public function create_db () {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'push_config';
    
        $sql = "CREATE TABLE $table_name (
            key_name varchar(128) NOT NULL UNIQUE,
            config JSON 
        ) $charset_collate;";
    
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    private function drop_db () {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'push_config';
    
        $sql = "DROP TABLE IF EXISTS $table_name;";
        $wpdb->query($sql);
    }
}

function sayhello() {
    echo 'hello';
}