<?php
	/*
	Plugin Name: Fake Traffic Blaster
    Plugin URI: http://faketrafficblaster.com/
    Description: Protect WordPress blogs from fake traffic.
    Version: 0.1
    Author: Hesham Zebida & Mo Osam
    Author URI: http://faketrafficblaster.com/
    Last Version update : 21 Feb 2011
    */
	
    $ftblaster_plugin_url = trailingslashit ( WP_PLUGIN_URL . '/' . dirname ( plugin_basename ( __FILE__ ) ) );
	$ftblaster_plugin_version = '0.1';
	$shortname = "ftblaster";
			
	// set up plugin actions
    //add_action( 'admin_init', 'ftblaster_requires_wordpress_version' );			// check WP version 3.0+
	add_action( 'admin_init', 'ftblaster_admin_init' );								// to register admin styles and scripts
	add_action( 'wp_enqueue_scripts', 'ftblaster_scripts_method' );					// to register scripts
	add_action( 'wp_enqueue_scripts', 'ftblaster_add_my_stylesheet' );				// load css
	
	//requires
	require_once ('include/options.php');											// load admin options
	require_once ('include/functions.php');											// load functions
		
	// ------------------------------------------------------------------------
	// REQUIRE MINIMUM VERSION OF WORDPRESS:                                               
	// ------------------------------------------------------------------------
	function ftblaster_requires_wordpress_version() {
		global $wp_version;
		$plugin = plugin_basename( __FILE__ );
		$plugin_data = get_plugin_data( __FILE__, false );

		if ( version_compare($wp_version, "3.0", "<" ) ) {
			if( is_plugin_active($plugin) ) {
				deactivate_plugins( $plugin );
				wp_die( "'".$plugin_data['Name']."' requires WordPress 3.0 or higher, and has been deactivated! Please upgrade WordPress and try again.<br /><br />Back to <a href='".admin_url()."'>WordPress admin</a>." );
			}
		}
	}

	// add admin init
	function ftblaster_admin_init() {
		global $ftblaster_plugin_url;
		$file_dir=get_bloginfo('template_directory');
		// *** add scripts here to admin page if required
		wp_enqueue_style ('ftblaster-style', $ftblaster_plugin_url."/style/admin_style.css");
	}
	/**
	*load our css
	* to the head
	*/
	function ftblaster_add_my_stylesheet() {
        
		// set globals
		global $ftblaster_plugin_url;
		
		$ftblasterStyleUrl = plugins_url('style/style.css', __FILE__); // Respects SSL, Style.css is relative to the current file
        $ftblasterStyleFile = $ftblaster_plugin_url. '/style/style.css';
		$ftblasterScriptFile = $ftblaster_plugin_url. '/js/ftblaster.js';
      
		if ( file_exists($ftblasterStyleFile) ) {

            	wp_register_style('ftblasterStyleSheets', $myStyleUrl);
            	wp_enqueue_style( 'ftblasterStyleSheets');
				wp_enqueue_script( 'ftblasterScriptFile');
        }
    }
	
	function ftblaster_scripts_method() {
		global $ftblaster_plugin_url;
		// register your script location, dependencies and version
		wp_register_script('custom_script',
		$ftblaster_plugin_url . '/js/ftblaster.js',
		array('jquery'),
		'1.0' );
		// enqueue the script
		wp_enqueue_script('custom_script');
	}
?>