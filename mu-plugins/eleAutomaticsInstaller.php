<?php
/**
 * Plugin Name: Your Plugin Name Here
 * Description: Short description of your plugin here.
 * Author:      your name here
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

// Basic security, prevents file from being loaded directly.
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/* Prefix your custom functions!
 *
 * Function names must be unique in PHP.
 * In order to make sure the name of your function does not
 * exist anywhere else in WordPress, or in other plugins,
 * give your function a unique custom prefix.
 * Example prefix: wpr20151231
 * Example function name: wpr20151231__do_something
 *
 * For the rest of your function name after the prefix,
 * make sure it is as brief and descriptive as possible.
 * When in doubt, do not fear a longer function name if it
 * is going to remind you at once of what the function does.
 * Imagine you’ll be reading your own code in some years, so
 * treat your future self with descriptive naming. ;)
 */

/**
 * Pass your custom function to the wp_rocket_loaded action hook.
 *
 * Note: wp_rocket_loaded itself is hooked into WordPress’ own
 * plugins_loaded hook.
 * Depending what kind of functionality your custom plugin
 * should implement, you can/should hook your function(s) into
 * different action hooks, such as for example
 * init, after_setup_theme, or template_redirect.
 * 
 * Learn more about WordPress actions and filters here:
 * https://developer.wordpress.org/plugins/hooks/
 *
 * @param string 'wp_rocket_loaded'         Hook name to hook function into
 * @param string 'yourprefix__do_something' Function name to be hooked
 */


class AutoWPInstance {
    public $configdata;	
    public $checksum;
	public function __construct() {
        //$this->configdata = file_get_contents(plugin_dir_path(__FILE__).'data.json');
        $this->configdata = json_decode(file_get_contents('http://json.testing.threeelements.de/data.json'), true);
        //$this->checksum = md5_file ( );
	}

function first_init(){

    flush_rewrite_rules(); 
}


function plugin_activation( $plugin ) {
    if( ! function_exists('activate_plugin') ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    if( ! is_plugin_active( $plugin ) ) {
    
        activate_plugin( $plugin );
        
        _log('plugin', 'activate_plugin', $plugin);
    }
}

function add_custom_option( $option ) {
    
    if( ! function_exists('add_option') ) {
        require_once ABSPATH . 'wp-admin/includes/option.php';
    }

    if(get_option($option ['key'])){
        update_option($option ['key'], $option['value']);
        _log('option', 'update_option', $option ['key']);
   }
   else {
    add_option($option ['key'], $option['value']);
    _log('option', 'add_option', $option ['key']);
   }

}

 function eleAutomatics_deactivate_plugins() {
    
    $plugins_array = array (
        'akismet/akismet.php', 
        'hello.php'
    );
    if ( is_plugin_active($plugins_array) ) {
        deactivate_plugins($plugins_array);  
        _log('plugin', 'deactivate_plugins', 'test');  
    }
    delete_plugins($plugins_array);  
    _log('plugin', 'delete_plugins', 'test');
  
}
/* activate pugins */
 function eleAutomatics_activate_plugins() {

    $plugins = $this->configdata;
    foreach ($plugins['plugins']  as $plugin) {
        $this->plugin_activation( $plugin['path'].'/'.$plugin['file']);
   
    }
  
}
/* activate themes */
function eleAutomatics_activate_themes() {

    $themes  = $this->configdata;
    foreach ($themes['themes']  as $theme) {
        themes_activation( $theme['path'].'/'.$theme['file']);
   
    }
  
} 
/* skizze */

}

function eleAutmaticsAutoCreater_activate(){
    #$awpi = new AutoWPInstance();
    print_r('start_import');
    if(!get_option('eleAutomaticInit')){
        add_option( 'eleAutomaticInit', '0', '', 'yes' );
        $string = file_get_contents(plugin_dir_path(__FILE__).'data.json');
        $options = json_decode($string, true);

        foreach ($options['options']  as $option) {
            add_custom_option($option);
        }
        
    }
    else {
        add_option( 'eleAutomaticInit', '1', '', 'yes' );
    }
    $string = file_get_contents(plugin_dir_path(__FILE__).'data.json');
    $options = json_decode($string, true);

    foreach ($options['options']  as $option) {

        add_custom_option($option);
    }
}
function eleAutmaticsAutoCreaterInstall(){
$awpi = new AutoWPInstance();
$awpi->plugin_activation('eleAutomaticsAutoInstaller/eleAutomaticsAutoInstaller.php');
$awpi->eleAutomatics_deactivate_plugins();
$awpi->eleAutomatics_activate_plugins();

}
add_action( 'wp_install', 'eleAutmaticsAutoCreaterInstall' );
add_action( 'admin_init', 'eleAutmaticsAutoCreaterInstall' );


/* Skizze Adminpage & first Init PopUp */



 
?>

