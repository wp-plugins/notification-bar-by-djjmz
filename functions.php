<?php
	function nnd_custom_css() {
		echo "<style type=\"text/css\">
		#barwrap {
		margin-bottom: 30px;
		}
		.bar{
		text-align: center;
		padding: 8px;
		padding-top: 0px;
		background-color: #".esc_html(get_option('nnd_backgroundcolor')).";
		max-height: 100px;
		position: fixed;
		top: 0px;
		left: 0px;
		right: 0px;
		color: #".esc_html(get_option('nnd_textcolor')).";
		border-bottom: thick ridge #".esc_html(get_option('nnd_bordercolor')).";
		-webkit-box-shadow:  0px 2px 13px 0.5px #".esc_html(get_option('nnd_shadowcolor')).";
		box-shadow:  0px 2px 13px 0.5px #".esc_html(get_option('nnd_shadowcolor')).";
		display: none;
		z-index: 3008;
		}
		#text{
		/* top: 8px; */ 
		}
		#ok{
		float: right;
		margin-top: 6px;
		margin-right: 10px;
		font-size: 25px;
		}
		#ok a {
		color: #".esc_html(get_option('nnd_textcolor'))."; 
		text-decoration: none;
		}
		</style>\r\n";
	}
	function nnd_js_load()
	{
		wp_register_script('nnd_js', plugins_url( '/js/freenbar.min.js', __FILE__ ));
		wp_enqueue_script('jquery');
		wp_enqueue_script('nnd_js');
	}
	function nnd_custom_html() {
		echo '<div id="barwrap">
		<div class="bar">
		<span id="text">'.esc_html(get_option('nnd_text')).'</span>
		<span id="ok"><a href="#">✔</a></span>
		</div>
		</div>';
	}
	function nnd_add_menu() {
		add_options_page('NND Settings', 'NND Settings', 'manage_options', 'nnd_settings', 'nnd_settings' );
	}
	function nnd_settings() {
		$message = '';
		if(isset($_POST['change'])){
			if(!empty($_POST['backgroundcolor']) and !empty($_POST['textcolor']) and !empty($_POST['bordercolor']) and !empty($_POST['shadowcolor']) and !empty($_POST['text'])){
				if(nnd_color_check(sanitize_text_field($_POST['backgroundcolor'])) == true and nnd_color_check(sanitize_text_field($_POST['textcolor'])) == true and nnd_color_check(sanitize_text_field($_POST['bordercolor'])) == true and nnd_color_check(sanitize_text_field($_POST['shadowcolor'])) == true){
					$backgroundcolor = (get_option('nnd_backgroundcolor', null) !== null);
					$textcolor = (get_option('nnd_textcolor', null) !== null);
					$bordercolor = (get_option('nnd_bordercolor', null) !== null);
					$shadowcolor = (get_option('nnd_shadowcolor', null) !== null);
					$text = (get_option('nnd_text', null) !== null);
					if ($backgroundcolor and $textcolor and $bordercolor and $shadowcolor and $text) {
						update_option('nnd_backgroundcolor', sanitize_text_field($_POST['backgroundcolor']));
						update_option('nnd_textcolor', sanitize_text_field($_POST['textcolor']));
						update_option('nnd_bordercolor', sanitize_text_field($_POST['bordercolor']));
						update_option('nnd_shadowcolor', sanitize_text_field($_POST['shadowcolor']));
						update_option('nnd_text', preg_replace('#[^\p{L}\p{N} .!?():]+#u', '', sanitize_text_field($_POST['text'])));
						} else {
						add_option('nnd_backgroundcolor', sanitize_text_field($_POST['backgroundcolor']));
						add_option('nnd_textcolor', sanitize_text_field($_POST['textcolor']));
						add_option('nnd_bordercolor', sanitize_text_field($_POST['bordercolor']));
						add_option('nnd_shadowcolor', sanitize_text_field($_POST['shadowcolor']));
						add_option('nnd_text', preg_replace('#[^\p{L}\p{N} .!?():]+#u', '', sanitize_text_field($_POST['text'])));
					}
					$message = 'Settings updated!';
				}
				else{
					$message = 'Invalid values!';
				}
			}
			else{
				$message = 'Invalid values!';
			}
		}
		echo '<div class="wrap">
		<div class="metabox-holder has-center-sidebar"> 
		<div id="post-body">
		<div id="post-body-content">
		<div class="postbox">
		<div class="inside">
		<div align="center">
		<h3>'.$message.'</h3>
		<form method="post" action = "">
		Background color:<br>
		<input name="backgroundcolor" type="text" value="'.get_option('nnd_backgroundcolor').'"/><br>
		Text color:<br>
		<input name="textcolor" type="text" value="'.get_option('nnd_textcolor').'"/><br>
		Border color:<br>
		<input name="bordercolor" type="text" value="'.get_option('nnd_bordercolor').'"/><br>
		Shadow color:<br>
		<input name="shadowcolor" type="text" value="'.get_option('nnd_shadowcolor').'"/><br>
		Text*:<br>
		<input name="text" type="text" value="'.get_option('nnd_text').'"/><br>
		<input type="submit" name="change" value="Change">
		</form><br>
		* Allowed characters: .?!():<br>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="5NTQ9DTFUDX5L">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>';	
	}	
	function nnd_color_check($color){
		if(preg_match('/^[a-f0-9]{6}$/i', $color)) 
		return true;
		else 
		return false;
	}
