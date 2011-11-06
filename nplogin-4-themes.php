<?php

/**
 * @package      NpLogin
 * @contributors AnupRaj
 * @author       AnupRaj
 * @author uri   http://anupraj.com.np/
 * @license      GPL3
 * @version      0.1
 * @link         http://www.dosurfin.com/products/wp-plugins/nplogin/
 * @tags         admin, login
 * @donate link: http://anupraj.com.np/donate/
 */
/*

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
define ('NPLOGIN_GROUP', 'nplogin');
define ('NPLOGIN_PAGE', 'nplogin_admin');
define ('NPLOGIN_SECTION', 'nplogin_section');
define ('NPLOGIN_OPTIONS', 'nplogin_options');
define ('NPLOGIN_LOCAL', 'nplogin');

$nplogin_options = array ();


/**
 *
 * @global type $nplogin_options
 * @return type 
 */
function nplogin_get_options () {
	
	global $nplogin_options;
	
	if (empty ($nplogin_options)) {
		$nplogin_options = get_option (NPLOGIN_OPTIONS);
	}
	
	return $nplogin_options;
	
}


/**
 * 
 */
function nplogin () {
	
	$nplogin_options = nplogin_get_options ();

	$loginUrl = get_bloginfo('template_url'). '/login.css';
	
	// output styles
	echo '<link rel="stylesheet" type="text/css" href="' . $loginUrl . '" />';
	echo '<style>';
	


	// text colour
	if (!empty ($nplogin_options['nplogin_color'])) {
?>
	#login,
	#login label {
		color:#<?php echo $nplogin_options['nplogin_color']; ?>;
	}
<?php
	}

	// text colour
	if (!empty ($nplogin_options['nplogin_backgroundColor'])) {
?>
	html,
	body.login {
		background-color:#<?php echo $nplogin_options['nplogin_backgroundColor']; ?>;
	}
<?php
	}
	$background = $nplogin_options['nplogin_background'];
	
	if (!empty ($background)) {
?>
	.login,body.login {
		background:url(<?php echo $background; ?>) top center no-repeat;
	}
<?php
	}else{
?>
        .login,body.login {
                background:url('<?php bloginfo('template_url'); ?>/images/save_mountains.jpg') top center no-repeat;
        }
<?php
        }

	// text colour
	if (!empty ($nplogin_options['nplogin_linkColor'])) {
?>
	.login #login a {
		color:#<?php echo $nplogin_options['nplogin_linkColor']; ?> !important;
	}
<?php
	}
	
	echo '</style>';
}


/**
 * 
 */
function nplogin_url () {

    echo bloginfo ('url');
	
}


/**
 * 
 */
function nplogin_title () {
	
	$nplogin_options = nplogin_get_options ();
	
	if (empty ($nplogin_options['nplogin_poweredby'])) {
	    echo printf (__('Powered by %s', NPLOGIN_LOCAL), get_option ('blogname'));
	} else {
		echo $nplogin_options['nplogin_poweredby'];
	}
	
}


/**
 * 
 */
function nplogin_admin_add_page () {
	
	
	add_options_page ('NpLogin', 'NpLogin', 'manage_options', NPLOGIN_PAGE, 'nplogin_options');
	
}


/**
 * 
 */
function nplogin_options () {
?>
	
<style>
	.wrap {
		position:relative;
	}
	
	.nplogin_notice {
		padding:10px 20px;
		-moz-border-radius:3px;
		-webkit-border-radius:3px;
		border-radius:3px;
		background:lightyellow;
		border:1px solid #e6db55;
		margin:10px 5px 10px 0;
	}
	
	.nplogin_notice h3 {
		margin-top:5px;
		padding-top:0;
	}
	
	.nplogin_notice li {
		list-style-type:disc;
		margin-left:20px;
	}
</style>

<div class="wrap">
	<div class="icon32" id="icon-options-general"><br /></div>
	<h2>NpLogin Options</h2>
	
	<div class="nplogin_notice">
		<h3>More WordPress Goodies &rsaquo;</h3>
		<p>If you like this plugin then you may also like other wordpress themes and plugins on <a href="http://www.dosurfin.com" target="_blank">DoSurfIn.Com</a></p>
		<ul>
			<li><a href="http://twitter.com/dosurfin" target="_blank">DoSurfIn on Twitter</a></li>
			<li><a href="http://facebook.com/DoSurfInNepal" target="_blank">DoSurfIn on Facebook</a></li>
			<li><a href="http://www.dosurfin.com/" target="_blank">DoSurfIn.com</a></li>
		</ul>
	</div>
	
	<form action="options.php" method="post">
<?php	
	settings_fields (NPLOGIN_GROUP);
	do_settings_sections (NPLOGIN_PAGE);
?>
		<p class="submit">
			<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" class="button-primary" />	
		</p>
	</form>
</div>

<?php
}


/**
 * 
 */
function nplogin_init () {
	
	$vars = nplogin_get_options ();
		
	register_setting (NPLOGIN_GROUP, NPLOGIN_OPTIONS, 'nplogin_validate');
	add_settings_section (NPLOGIN_SECTION, __('Login Screen Settings', NPLOGIN_LOCAL), 'nplogin_section_validate', NPLOGIN_PAGE);

	add_settings_field (
		'nplogin_background',
		__('Background Image Url:', NPLOGIN_LOCAL),
		'nplogin_form_text',
		NPLOGIN_PAGE,
		NPLOGIN_SECTION,
		array (
			'id' => 'nplogin_background',
			'value' => $vars,
			'default' => '',
			'description' => __('URL path to image to use for background. You can upload your image with the media uploader', NPLOGIN_LOCAL),
		)
	);

	add_settings_field (
		'nplogin_poweredby',
		__('Powered by:', NPLOGIN_LOCAL),
		'nplogin_form_text',
		NPLOGIN_PAGE,
		NPLOGIN_SECTION,
		array (
			'id' => 'nplogin_poweredby',
			'value' => $vars,
			'default' => 'Powered by DoSurfIn',
			'description' => '',
		)
	);

	add_settings_field (
		'nplogin_backgroundColor',
		__('Page Background Color:', NPLOGIN_LOCAL),
		'nplogin_form_text',
		NPLOGIN_PAGE,
		NPLOGIN_SECTION,
		array (
			'id' => 'nplogin_backgroundColor',
			'value' => $vars,
			'default' => 'eeeeee',
			'description' => __('6 digit hex color code', NPLOGIN_LOCAL),
		)
	);
	
	add_settings_field (
		'nplogin_color',
		__('Text Color:', NPLOGIN_LOCAL),
		'nplogin_form_text',
		NPLOGIN_PAGE,
		NPLOGIN_SECTION,
		array (
			'id' => 'nplogin_color',
			'value' => $vars,
			'default' => 'ffffff',
			'description' => __('6 digit hex color code', NPLOGIN_LOCAL),
		)
	);
	
	add_settings_field (
		'nplogin_linkColor',
		__('Text Link Color:', NPLOGIN_LOCAL),
		'nplogin_form_text',
		NPLOGIN_PAGE,
		NPLOGIN_SECTION,
		array (
			'id' => 'nplogin_linkColor',
			'value' => $vars,
			'default' => 'ffffff',
			'description' => __('6 digit hex color code', NPLOGIN_LOCAL),
		)
	);
	
}


/**
 *
 * @param type $fields
 * @return type 
 */
function nplogin_validate ($fields) {

	// colour validation
	$fields['nplogin_color'] = str_replace ('#', '', $fields['nplogin_color']);
	//$fields['nplogin_color'] = str_pad ('f', 6, $fields['nplogin_color'], STR_PAD_RIGHT);
	$fields['nplogin_color'] = substr ($fields['nplogin_color'], 0, 6);
	
	// background colour validation
	$fields['nplogin_backgroundColor'] = str_replace ('#', '', $fields['nplogin_backgroundColor']);
	//$fields['nplogin_backgroundColor'] = str_pad ('f', 6, $fields['nplogin_backgroundColor'], STR_PAD_RIGHT);
	$fields['nplogin_backgroundColor'] = substr ($fields['nplogin_backgroundColor'], 0, 6);
	
	// colour validation
	$fields['nplogin_linkColor'] = str_replace ('#', '', $fields['nplogin_linkColor']);
	//$fields['nplogin_linkColor'] = str_pad ('f', 6, $fields['nplogin_linkColor'], STR_PAD_RIGHT);
	$fields['nplogin_linkColor'] = substr ($fields['nplogin_linkColor'], 0, 6);
	
	// clean image urls
	$fields['nplogin_background'] = esc_url_raw ($fields['nplogin_background']);
	
	// sanitize powered by message
	$fields['nplogin_poweredby'] = esc_html ($fields['nplogin_poweredby']);
	$fields['nplogin_poweredby'] = strip_tags ($fields['nplogin_poweredby']);
	
	return $fields;
	
}


/**
 *
 * @param type $fields
 * @return type 
 */
function nplogin_section_validate ($fields) {
	
	return $fields;
	
}


/**
 *
 * @param type $args 
 */
function nplogin_form_text ($args) {
	
	// defaults
	$id = '';
	$value = '';
	$description = '';
	
	// set values
	if (!empty ($args['value'][$args['id']])) {
		$value = $args['value'][$args['id']];
	} else {
		if (!empty ($args['default'])) {
			$value = $args['default'];				
		}
	}
	
	if (!empty ($args['description'])) {
		$description = $args['description'];
	}
	
	$id = $args['id'];
?>
	<input type="text" id="<?php echo $id; ?>" name="<?php echo NPLOGIN_OPTIONS; ?>[<?php echo $id; ?>]" value="<?php echo $value; ?>" class="regular-text"/>
<?php
	if (!empty ($description)) {
		echo '<br /><span class="description">' . $description . '</span>';
	}
	
}


add_action ('admin_init', 'nplogin_init');
add_action ('admin_menu', 'nplogin_admin_add_page');
add_action ('login_head', 'nplogin');
add_filter ('login_headerurl', 'nplogin_url');
add_filter ('login_headertitle', 'nplogin_title');
