<?php 
	/*
	Plugin Name: NertWorks Site Wide SSL
	Plugin URI: http://nertworks.com/?p=433
	Description: Plugin for forcing SSL site wide.  
	Author: Nickolas Ormond and Allen Smith
	Version: 1.05
	Author URI: http://www.nertworks.com
	*/
function check_https(){	
	if ($_SERVER["HTTPS"] == "on"){
		//SSL is on
	}
	else {
		$redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
		//$loader=plugins_url('/images/ajax-loader.gif', __FILE__);
				
		
		if (get_option('nertworks_site_wide_ssl_redirect_type')=="javascript"){
			echo '<script type="text/javascript">
					window.location = "'.$redirect.'"
				  </script>"';
		}
		if (get_option('nertworks_site_wide_ssl_redirect_type')=="wp_redirect"){
			
			wp_redirect($redirect);
		}
		if (get_option('nertworks_site_wide_ssl_redirect_type')=="PHP"){
			
			header("Location: ".$redirect);
		}
		
	}
}
if (get_option('nertworks_site_wide_ssl_dashboard_option')=="yes"){
	add_action('admin_init', 'check_https');
}
if (get_option('nertworks_site_wide_ssl_website_option')=="yes"){
	add_action('template_redirect', 'check_https');
}





function nertworks_sitewidessl_settings_page() {
	?>
	<div class="wrap">
	<?php $logo=plugins_url('/images/nertworks_logo.png', __FILE__);?>
	<a href="http://nertworks.com" target="_blank"><img src="<?php echo $logo; ?>" style="width:20%;"></a>
	<h1>Site Wide SSL</h1>
	<?php settings_errors(); ?> 

	<div class="about-text">
	 <?php _e('Options Much' ); ?>

	 </div>

	 <h2 class="nav-tab-wrapper">

	<?php $tab=$_GET['tab']; 

	if ($tab==NULL){

		$tab="general_settings";

	}

	?>	

	 <a href="?page=nertworks-site-wide-ssl/sitewidessl.php&tab=general_settings" class="nav-tab<?php if ($tab=="general_settings"){echo " nav-tab-active";}?>">

	 <?php _e( 'General Settings' ); ?>


	 <a href="?page=nertworks-site-wide-ssl/sitewidessl.php&tab=tools" class="nav-tab<?php if ($tab=="tools"){echo " nav-tab-active";}?>">

	 <?php _e( 'Tools' ); ?>

	 </a>
	 <a href="?page=nertworks-site-wide-ssl/sitewidessl.php&tab=about" class="nav-tab<?php if ($tab=="about"){echo " nav-tab-active";}?>">

	 <?php _e( 'About' ); ?>

	 </a>

	 </h2>

	 <!--Handle the Tabs-->
		
	<?php if ($tab=="general_settings"){?>
	<h3>General Settings</h3>
	<i>IMPORTANT - This plugin will redirect to an error page if do not have an SSL certificate for your website.  Ask your hosting provider to help you with this if you don't already have a certificate installed.  <br />
	If you need to purchase a certificate you can do so <a href="http://www.godaddy.com/ssl/ssl-certificates.aspx" target="_blank">here</a></i>
	
	<form method="post" action="options.php">
	<?php settings_fields( 'nertworks-sitewidessl-settings-group' ); ?>
	<?php do_settings_sections( 'nertworks-sitewidessl-settings-group' ); ?>
	<table class="form-table">
	<tr valign="top">
	<th scope="row"><strong>Type of redirection: </strong></th>
	<td>
	<select name="nertworks_site_wide_ssl_redirect_type">
	<option value="disabled"<?php if (get_option('nertworks_site_wide_ssl_redirect_type')=="disabled"){echo " selected";}?>>Disabled</option>
	<option value="javascript"<?php if (get_option('nertworks_site_wide_ssl_redirect_type')=="javascript"){echo " selected";}?>>javascript</option>
	<option value="wp_redirect"<?php if (get_option('nertworks_site_wide_ssl_redirect_type')=="wp_redirect"){echo " selected";}?>>wp_redirect</option>
	<option value="PHP"<?php if (get_option('nertworks_site_wide_ssl_redirect_type')=="PHP"){echo " selected";}?>>PHP</option>
	</td>
	</tr>
	<tr valign="top">
	<th scope="row"><strong>Enforce on Dashboard: </strong></th>
	<td>
	<select name="nertworks_site_wide_ssl_dashboard_option">
	<option value="no"<?php if (get_option('nertworks_site_wide_ssl_dashboard_option')=="no"){echo " selected";}?>>No</option>
	<option value="yes"<?php if (get_option('nertworks_site_wide_ssl_dashboard_option')=="yes"){echo " selected";}?>>Yes</option>
	</td>
	</tr>
	<tr valign="top">
	<th scope="row"><strong>Enforce on Website: </strong></th>
	<td>
	<select name="nertworks_site_wide_ssl_website_option">
	<option value="no"<?php if (get_option('nertworks_site_wide_ssl_website_option')=="no"){echo " selected";}?>>No</option>
	<option value="yes"<?php if (get_option('nertworks_site_wide_ssl_website_option')=="yes"){echo " selected";}?>>Yes</option>
	</td>
	</tr>
	
	</table>
	<?php submit_button(); ?>

	</form>
	<?php }
	if ($tab=="tools"){	
		echo '<h3>Tools</h3>';
		echo '<hr></hr>';
		echo '<h4>Test Your Server</h4>';
		$test_ssl=plugins_url('test-ssl.php', __FILE__);
		
		echo '<a href="'.$test_ssl.'" target="_blank" class="button">Run SSL Test</a><br />';
		echo '<i>Make sure you have your certificate installed prior to this test for it to successfully run.  If you need to purchase a certificate you can do so <a href="http://www.godaddy.com/ssl/ssl-certificates.aspx" target="_blank">here</a></i><br />
		<i>If you need help installing a certificate please email us at <a href="mailto::support@nertworks.com">support@nertworks.com</a>.</i>
		';
		
		echo '<div id="sitewideconsole">';
			
		echo '</div>';
		echo '<p>More Tools Soon.  Coffee Helps.</p>';
	}
	if ($tab=="about"){	
		echo 'NertWorks SiteWide SSL is meant to make enforcing SSL throughout your website simple and easy. ';
		
		echo '<strong>Methods Supported</strong>';
		echo '<li>javascript</li>';
		echo '<li>wp_redirect</li>';
		echo '<li>PHP</li>';
	}
	?>
	<hr></hr>
	<div id="donatePopipDiv">
	<i>Keep Nick and Allen awake with coffee to work on updates, features and bugs.  </i> 

	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">

	<input type="hidden" name="cmd" value="_s-xclick">

	<input type="hidden" name="hosted_button_id" value="D6FXJUCLE6RGY">

	<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">

	<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">

	</form>

	<img src="<?php echo plugins_url('/images/double_dragon.jpg', __FILE__); ?>" width="150">
	</div><!--donatePopipDiv-->
	</div>
	<?php }
	
//Adding the CSS File
add_action( 'wp_enqueue_scripts', 'nertworks_sitewidessl_stylesheet' );

/**
* Enqueue plugin style-file
*/
function nertworks_sitewidessl_stylesheet() {
	// Respects SSL, Style.css is relative to the current file
	wp_register_style( 'prefix-style', plugins_url('style.css', __FILE__) );
	wp_enqueue_style( 'prefix-style' );
}


// create custom plugin settings menu
add_action('admin_menu', 'nertworks_create_sitewidessl_menu');

function nertworks_create_sitewidessl_menu() {
	//create new top-level menu
	add_menu_page('NertWorks Site Wide SSl', 'NW SiteWideSSL', 'administrator', __FILE__, 'nertworks_sitewidessl_settings_page',plugins_url('/images/icon16.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'register_nertworks_sitewidessl_settings' );
}

register_activation_hook(__FILE__, 'nertworks_sitewidessl_plugin_activate');
add_action('admin_init', 'nertworks_sitewidessl_redirect');


function nertworks_sitewidessl_plugin_activate() {
	add_option('nertworks_sidewidessl_plugin_do_activation_redirect_popup', true);
	update_option('nertworks_site_wide_ssl_redirect_type', 'disabled');
	update_option('nertworks_site_wide_ssl_dashboard_enabled', 'no');
	update_option('nertworks_site_wide_ssl_website_enabled', 'no');

}

function nertworks_sitewidessl_redirect() {
	if (get_option('nertworks_sidewidessl_plugin_do_activation_redirect_popup', false)) {
		delete_option('nertworks_sidewidessl_plugin_do_activation_redirect_popup');
		if(!isset($_GET['activate-multi']))
		{
			wp_redirect("?page=nertworks-site-wide-ssl/sitewidessl.php&tab=general_settings");
		}
	}
}	
function register_nertworks_sitewidessl_settings() {
	//register our settings
	register_setting( 'nertworks-sitewidessl-settings-group', 'nertworks_site_wide_ssl_redirect_type' );
	register_setting( 'nertworks-sitewidessl-settings-group', 'nertworks_site_wide_ssl_dashboard_option' );
	register_setting( 'nertworks-sitewidessl-settings-group', 'nertworks_site_wide_ssl_website_option' );
}
	