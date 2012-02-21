<?php
/*
	plugin functions
*/

// actions
	add_action('wp_head', 'ftblaster_ie_redirect_java');			// redirect IE users
	add_action('init', 'ftblaster_ie_redirect_php');				// redirect IE users


//**********************************
//******** Add our fundtions *******
//**********************************

// ******************************
// IE redirect
// ******************************
function ftblaster_ie_redirect_java(){
	$options = get_option('ftblaster_options');
	
	if (isset($options['ftblaster_redirect_url']) != '') {
			// get redirect URL
			$ftblaster_ie_url = $options['ftblaster_redirect_url'];
		}
	
	if (!is_admin()) { // avoid being kicked out!
	
		If (isset($options['ftblaster_redirect_enable']) != '') { // if redirect is enable, then print our script
		?>

<!--[if IE]>
<script type="text/javascript">
if (!readCookie(cookieName) && !ftReferrer()) { Action('<?php if ($ftblaster_ie_url !='') {
																	echo $ftblaster_ie_url;
																	} else {
																		echo 'http://faketrafficblaster.com/fake/'; } ?>'); }
</script>
<![endif]-->
      

<?php
		}
	}
}

// ******************************
// Another way to
// redirect fake traffic
// this time we will use cookies
// ******************************
function ftblaster_ie_redirect_php(){
	$options = get_option('ftblaster_options');
	
	// get cookie name
	if (isset($options['ftblaster_redirect_cookie']) != '') {$ftblaster_cookie = $options['ftblaster_redirect_cookie'];}
	else {$ftblaster_cookie = 'blog_newvisitor';}
	
	// get redirect url
	if (isset($options['ftblaster_redirect_url']) != '') {$ftblaster_ie_url = $options['ftblaster_redirect_url'];}
	else {$ftblaster_ie_url = 'http://faketrafficblaster.com/fake/';}
	
	if (!is_admin()) { // avoid being kicked out!
	
		If (isset($options['ftblaster_redirect_enable']) != '') { // check if redirect is enabled
			
    			if (!isset($_COOKIE[$ftblaster_cookie])) { // check if there if there is already a cookie, if not set it!
        		
					// set our cookie
					setcookie($ftblaster_cookie, 1, time()+356, COOKIEPATH, COOKIE_DOMAIN, false);
					//setcookie($ftblaster_cookie, 1, time()+3600, "/", str_replace('http://www','',get_bloginfo('url')) );
    			
					if (!isset($_COOKIE[$ftblaster_cookie])) { // if this is not a real visitor
				
						// Send 'Em Away :)
						//wp_redirect($ftblaster_ie_url); exit();
					}
				}
		}
	}

}
?>