<?php
class Property_Data_Push_Config{  
    
    private $my_plugin_screen_name;  
    private static $instance;  
     /*......*/  
  
    static function GetInstance()  
    {   
        if (!isset(self::$instance))  
        {  
            self::$instance = new self();  
        }  
        return self::$instance;  
    }  
      
    public function PluginMenu()  
    {  
     $this->my_plugin_screen_name = add_menu_page(  
                                      'Property Data Push Config',   
                                      'Property Data Push Config',   
                                      'manage_options',  
                                      __FILE__,   
                                      array($this, 'RenderPage')
                                      );  
    }  
      
    public function RenderPage(){  
        global $wpdb;
        $table_name = $wpdb->prefix . 'push_config';
        $row = $wpdb->get_results("SELECT * FROM $table_name");
        $number = count($row);
     ?>  
     <div class='wrap'>  
      <div class="main-content">  

    <form id="configForm" class="form-basic"> 
    <div class="form-title-row">  
            <h1>Property Data Config</h1>  
        </div>  

        <?php
            foreach($row as $value) {
               $config = json_decode($value->config);
        ?>
            <h3><?php echo $value->key_name;?></h3>

            <div class="form-row">  
                <p>URL: </p>
                <input id="property_url" name=<?php echo ''.$value->key_name.'_url';?> value="<?php echo $config->property_url ?> "></input>
            </div> 

            <div class="form-row">  
                <p>Type: </p>
                <input id="property_type" name=<?php echo ''.$value->key_name.'_type';?>  value="<?php echo $config->property_type ?>"></input>
            </div>  

            <div class="form-row">  
                <p>Status:  </p>
                <input id="property_status" name=<?php echo ''.$value->key_name.'_status';?> value="<?php echo $config->property_status ?>" ></input>
            </div>  

            <div class="form-row">  
                <p>Features:  </p>
                <input id="property_features" name=<?php echo ''.$value->key_name.'_feature';?> value="<?php echo $config->property_feature ?> "></input>
            </div>  


            <div class="form-row">  
                <p>Labels: </p>
                <input id="property_labels" name=<?php echo ''.$value->key_name.'_labels';?> value="<?php echo $config->property_labels ?> "></input>
            </div> 

            <div class="form-row">  
                <p>City: </p>
                <input id="property_city"  name=<?php echo ''.$value->key_name.'_city';?>   value="<?php echo $config->property_city ?>  "></input>
            </div>  

        <?php
            }
        ?>
        <div class="form-row">  
            <p><button id="save_endpoint" type="submit">Save</button><p> 
        </div>  
        
      </form>  
      <p><button id="add_new_endpoint" value="<?php echo $number+1; ?>">Add New Endpoint</button><p> 
      <p><button id="delete_endpoint" value="<?php echo $number; ?>">Delete Endpoint</button><p> 
  </div>  
        
     </div>  
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="/wp-content/plugins/plugin-propertyDataPush/js/script.js?ver=9"></script>
     <?php  
    }  

    public function InitPlugin()  
    {  
         add_action('admin_menu', array($this, 'PluginMenu'));  
    }  
  
} 