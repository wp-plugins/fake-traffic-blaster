<?php
/*
	Options page
*/

// ------------------------------------------------------------------------
// PLUGIN PREFIX:                                                          
// ------------------------------------------------------------------------
// A PREFIX IS USED TO AVOID CONFLICTS WITH EXISTING PLUGIN FUNCTION NAMES.
// WHEN CREATING A NEW PLUGIN, CHANGE THE PREFIX AND USE YOUR TEXT EDITORS 
// SEARCH/REPLACE FUNCTION TO RENAME THEM ALL QUICKLY.
// ------------------------------------------------------------------------

// 'ftblaster_' prefix is derived from [wp]wordpress [author]ptions [r]reviews

// ------------------------------------------------------------------------
// REGISTER HOOKS & CALLBACK FUNCTIONS:
// ------------------------------------------------------------------------
// HOOKS TO SETUP DEFAULT PLUGIN OPTIONS, HANDLE CLEAN-UP OF OPTIONS WHEN
// PLUGIN IS DEACTIVATED AND DELETED, INITIALISE PLUGIN, ADD OPTIONS PAGE.
// ------------------------------------------------------------------------

// Set-up Action and Filter Hooks
//register_activation_hook(__FILE__, 'ftblaster_add_defaults');
//register_uninstall_hook(__FILE__, 'ftblaster_delete_plugin_options');
add_action( 'admin_init', 'ftblaster_init' );
add_action( 'admin_menu', 'ftblaster_add_options_page' );
add_filter( 'plugin_action_links', 'ftblaster_plugin_action_links', 10, 2 );

// --------------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: register_uninstall_hook(__FILE__, 'ftblaster_delete_plugin_options')
// --------------------------------------------------------------------------------------
// THIS FUNCTION RUNS WHEN THE USER DEACTIVATES AND DELETES THE PLUGIN. IT SIMPLY DELETES
// THE PLUGIN OPTIONS DB ENTRY (WHICH IS AN ARRAY STORING ALL THE PLUGIN OPTIONS).
// --------------------------------------------------------------------------------------

// Delete options table entries ONLY when plugin deactivated AND deleted
function ftblaster_delete_plugin_options() {
	delete_option('ftblaster_options');
}

// ------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: register_activation_hook(__FILE__, 'ftblaster_add_defaults')
// ------------------------------------------------------------------------------
// THIS FUNCTION RUNS WHEN THE PLUGIN IS ACTIVATED. IF THERE ARE NO THEME OPTIONS
// CURRENTLY SET, OR THE USER HAS SELECTED THE CHECKBOX TO RESET OPTIONS TO THEIR
// DEFAULTS THEN THE OPTIONS ARE SET/RESET.
//
// OTHERWISE, THE PLUGIN OPTIONS REMAIN UNCHANGED.
// ------------------------------------------------------------------------------

// Define default option settings
function ftblaster_add_defaults() {
	$tmp = get_option('ftblaster_options');
    if(($tmp['ftblaster_chk_default_options_db']=='1')||(!is_array($tmp))) {
		delete_option('ftblaster_options'); // so we don't have to reset all the 'off' checkboxes too! ( I don't think this is needed but leave for now)
		$arr = array(	"ftblaster_redirect_enable" => "",
						"ftblaster_redirect_url" => "",
						"ftblaster_redirect_cookie" => "",
						"ftblaster_chk_default_options_db" => ""
		);
		update_option('ftblaster_options', $arr);
	}
}

// ------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: add_action('admin_init', 'ftblaster_init' )
// ------------------------------------------------------------------------------
// THIS FUNCTION RUNS WHEN THE 'admin_init' HOOK FIRES, AND REGISTERS YOUR PLUGIN
// SETTING WITH THE WORDPRESS SETTINGS API. YOU WON'T BE ABLE TO USE THE SETTINGS
// API UNTIL YOU DO.
// ------------------------------------------------------------------------------

// Init plugin options to white list our options
function ftblaster_init(){
	register_setting( 'ftblaster_plugin_options', 'ftblaster_options', 'ftblaster_validate_options' );
}

// ------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: add_action('admin_menu', 'ftblaster_add_options_page');
// ------------------------------------------------------------------------------
// THIS FUNCTION RUNS WHEN THE 'admin_menu' HOOK FIRES, AND ADDS A NEW OPTIONS
// PAGE FOR YOUR PLUGIN TO THE SETTINGS MENU.
// ------------------------------------------------------------------------------

// Add menu page
function ftblaster_add_options_page() {
	add_options_page('Blaster Settings', 'Fake Traffic Blaster', 'manage_options', __FILE__, 'ftblaster_render_form');
}

// ------------------------------------------------------------------------------
// CALLBACK FUNCTION SPECIFIED IN: add_options_page()
// ------------------------------------------------------------------------------
// THIS FUNCTION IS SPECIFIED IN add_options_page() AS THE CALLBACK FUNCTION THAT
// ACTUALLY RENDER THE PLUGIN OPTIONS FORM AS A SUB-MENU UNDER THE EXISTING
// SETTINGS ADMIN MENU.
// ------------------------------------------------------------------------------

// Render the Plugin options form
function ftblaster_render_form() {
	?>
	<div class="wrap columns-2">
		
		<!-- Display Plugin Icon, Header, and Description -->
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>Fake Traffic Blaster Settings</h2>
		<p>Get rid of fake traffic.</p>
        
        <!-- options div -->
        <div id="post-body-content" style="float:left;">

		<!-- Beginning of the Plugin Options Form -->
		<form method="post" action="options.php">
			<?php settings_fields('ftblaster_plugin_options'); ?>
			<?php $options = get_option('ftblaster_options'); ?>

			<!-- Table Structure Containing Form Controls -->
			<!-- Each Plugin Option Defined on a New Table Row -->
			<table class="form-table">
            
            	<!-- Checkbox Buttons One -->
				<tr valign="top">
					<th scope="row">Redirect</th>
					<td>
						<!-- First checkbox button -->
						<label><input name="ftblaster_options[ftblaster_redirect_enable]" type="checkbox" value="1" <?php if (isset($options['ftblaster_redirect_enable'])) { checked('1', $options['ftblaster_redirect_enable']); } ?> /> Enable?</label><br />


					</td>
				</tr>
                
                 <!-- Textbox Control 
				<tr>
					<th scope="row">Set Cookie Name</th>
					<td>
						<input type="text" size="57" name="ftblaster_options[ftblaster_redirect_cookie]" value="<?php echo $options['ftblaster_redirect_cookie']; ?>" />
					</td>
				</tr>
                -->
                
                 <!-- Textbox Control -->
				<tr>
					<th scope="row">Redirect URL (http://)</th>
					<td>
						<input type="text" size="57" name="ftblaster_options[ftblaster_redirect_url]" value="<?php echo $options['ftblaster_redirect_url']; ?>" />
					</td>
				</tr>
                
				<!--
                <tr><td colspan="2"><div style="margin-top:10px;"></div></td></tr>
				<tr valign="top" style="border-top:#dddddd 1px solid;">
					<th scope="row">Database Options</th>
					<td>
						<label><input name="ftblaster_options[ftblaster_chk_default_options_db]" type="checkbox" value="1" <?php if (isset($options['ftblaster_chk_default_options_db'])) { checked('1', $options['ftblaster_chk_default_options_db']); } ?> /> Restore defaults upon plugin deactivation/reactivation</label>
						<br /><span style="color:#666666;margin-left:2px;">Only check this if you want to reset plugin settings upon Plugin reactivation</span>
					</td>
				</tr>
                -->
			</table>
            
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
        </div>


			<!-- sidebar stuff -->
            <div id="poststuff" class="postbox ftblaster_admin">
            	
                
                <?php /* <div class="handlediv" title="Click to toggle"><br></div> */ ?>
				<h3 class="hndle"><span>Awesome!</span></h3>
				
                <div class="inside">
                
                	<?php if (ftblaster_fb_list_rss()) {echo ftblaster_fb_list_rss;} // FamousBloggers RSS display ?>
                    <?php if (ftblaster_admin_links()) {echo ftblaster_admin_links;} // Extra admin links ?>

                
                	<!-- Twitter follow us button -->
            		<div style="margin: auto;">
						<a href="https://twitter.com/FamousBloggers"
            			class="twitter-follow-button"
            			data-show-count="true"
       		    	 	data-lang="en"
            			data-size="normal">Follow @FamousBloggers</a>
						<script>!function(d,s,id)
							{var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id))
								{js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}
								(document,"script","twitter-wjs");
						</script>
					</div>       
			
            </div>        
            </div>
            </div>
            <!-- end of sidebar stuff -->
            <div class="clear"><br></div>

	</div>
	<?php	
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function ftblaster_validate_options($input) {
	 // strip html from textboxes
	$input['ftblaster_redirect_url'] = wp_filter_nohtml_kses($input['ftblaster_redirect_url']); // Sanitize textarea input (strip html tags, and escape characters)
	
	//$input['ftblaster_redirect_cookie'] = wp_filter_nohtml_kses($input['ftblaster_redirect_cookie']); // Sanitize textarea input (strip html tags, and escape characters)
	return $input;
}

// Display a Settings link on the main Plugins page
function ftblaster_plugin_action_links( $links, $file ) {

	if ( $file == plugin_basename( __FILE__ ) ) {
		$posk_links = '<a href="'.get_admin_url().'options-general.php?page=fake-traffic-blaster.php">'.__('Settings').'</a>';
		// make the 'Settings' link appear first
		array_unshift( $links, $posk_links );
	}

	return $links;
}

// FB RSS
function ftblaster_fb_list_rss() {
	include_once(ABSPATH.WPINC.'/rss.php'); // path to include script
	$feed = fetch_rss('http://feeds.feedburner.com/FamousBloggers'); // specify feed url
	$items = array_slice($feed->items, 0, 5); // specify first and last item
	
	if (!empty($items)) : ?>
        <div class="ftblaster_fb_rss">
        	<ul>
				<?php foreach ($items as $item) : ?>
					<li><p><a href="<?php echo $item['link']; ?>" title="<?php echo $item['description']; ?>" target="_blank"><?php echo $item['title']; ?></a></p></li>
				<?php endforeach; ?>
			</ul>              
 		</div>
	<?php endif;
}

// Extra links for the plugin page
function ftblaster_admin_links() { ?>
	
        <div class="ftblaster_admin_link">
            <ul>
				
                <li>
                	<a href="http://wordpress.org/extend/plugins/fake-traffic-blaster/" title="" target="_blank">Rate the plugin 5★ on WordPress.org</a>
				</li>
                
                <li class="ftblaster_blog">
                	<a href="http://faketrafficblaster.com/" title="Fake Traffic Blaster" target="_blank">Blog about it and link to the plugin site</a>
				</li>
                
                <li class="ftblaster_paypal">
                		<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=W8HG4NZHB2RZ8" title="Fake Traffic Blaster" target="_blank" rel="nofollow">
                    		Please, consider making a donation. Thanks!
						</a>
					
				</li>
			
            </ul>              
 		</div>
        
        <div class="clear"></div>
<?php
}
?>