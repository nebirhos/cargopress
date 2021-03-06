<?php

// Theme options adapted from "A Theme Tip For WordPress Theme Authors"
// http://literalbarrage.org/blog/archives/2007/05/03/a-theme-tip-for-wordpress-theme-authors/

$themename = "Cargopress";
$shortname = "cgp";

// Create theme options

$options = array (
  array(	"name" => __('Custom logo','cargopress'),
    "desc" => __('Link to an image (it will be resized to 200x60px). If no image is specified, the blog name is used','cargopress'),
    "id" => $shortname."_custom_logo",
    "std" => "",
    "type" => "text"),
);

function mytheme_add_admin() {
  global $themename, $shortname, $options, $blog_id;
  $page ='';

	if (isset($_GET["page"]) && !empty($_GET["page"])) $page = $_GET["page"];
  if ( $page == basename(__FILE__) ) {
    $action = '';
    if (isset($_REQUEST["action"]) && !empty($_REQUEST["action"])) $action = $_REQUEST["action"];
    if ( 'save' == $action ) {
			check_admin_referer('cargopress-theme-options');
      foreach ($options as $value) {
        if (CARGOPRESS_MB) {
          if (isset($_REQUEST[ $value['id'] ])) {
            update_blog_option( $blog_id, $value['id'], $_REQUEST[ $value['id'] ] );
          }
          else {
            update_blog_option( $blog_id, $value['id'], $value['std'] );
          }
        } 
        else {
          if (isset($_REQUEST[ $value['id'] ])) {
            update_option( $value['id'], $_REQUEST[ $value['id'] ] );
          }
          else {
            update_option( $value['id'], $value['std'] );
          }
        }
      }
      header("Location: themes.php?page=theme-options.php&saved=true");
      die;
    }
    else if( 'reset' == $action ) {
			check_admin_referer('cargopress-reset');
      foreach ($options as $value) {
				if (CARGOPRESS_MB) {
					delete_blog_option( $blog_id, $value['id'] );
				}
				else {
					delete_option( $value['id'] );
				}
			}
      header("Location: themes.php?page=theme-options.php&reset=true");
      die;
    }
    else if ( 'resetwidgets' == $action ) {
			check_admin_referer('cargopress-reset-widgets');
      update_option('sidebars_widgets',NULL);
      header("Location: themes.php?page=theme-options.php&resetwidgets=true");
      die;
    } 
  }
  add_theme_page($themename." Options", "Cargopress Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

function mytheme_admin() {
  global $themename, $shortname, $options;

  if (isset($_REQUEST["saved"]) && !empty($_REQUEST["saved"])) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.__('settings saved.','cargopress').'</strong></p></div>';
  if (isset($_REQUEST["reset"]) && !empty($_REQUEST["reset"])) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.__('settings reset.','cargopress').'</strong></p></div>';
  if (isset($_REQUEST["resetwidgets"]) && !empty($_REQUEST["resetwidgets"])) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.__('widgets reset.','cargopress').'</strong></p></div>';
?>
<div class="wrap">
<?php if ( function_exists('screen_icon') ) screen_icon(); ?>
<h2><?php echo $themename; ?> Options</h2>

<form method="post" action="">
	<?php wp_nonce_field('cargopress-theme-options'); ?>
	<table class="form-table">
    <?php foreach ($options as $value) { 
      switch ( $value['type'] ) {
      case 'text':
		?>
		<tr valign="top"> 
			<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo __($value['name'],'cargopress'); ?></label></th>
			<td>
				<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if (CARGOPRESS_MB) {if ( get_blog_option( $blog_id, $value['id'] ) != "") { echo get_blog_option( $blogid, $value['id'] ); } else { echo $value['std']; }} else {if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; }} ?>" />
				<?php echo __($value['desc'],'cargopress'); ?>
			</td>
		</tr>
		<?php break;

      case 'select':
		?>
		<tr valign="top">
			<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo __($value['name'],'cargopress'); ?></label></th>
			<td>
				<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
        <?php foreach ($value['options'] as $option) { ?>
        <option<?php if(CARGOPRESS_MB){ if ( get_blog_option($blog_id, $value['id']) == $option) { echo ' selected="selected"'; } elseif (!get_option($value['id']) && $value['std'] == $option) { echo ' selected="selected"'; }} else { if ( get_option( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif (!get_option($value['id']) && $value['std'] == $option) { echo ' selected="selected"'; }} ?>><?php echo $option; ?></option>
        <?php } ?>
        </select>
			</td>
		</tr>
		<?php break;

      case 'textarea':
		  $ta_options = $value['options'];
		?>
		<tr valign="top"> 
			<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo __($value['name'],'cargopress'); ?></label></th>
			<td><textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="<?php echo $ta_options['rows']; ?>"><?php
				if (CARGOPRESS_MB)
				{
					if( get_blog_option($blog_id, $value['id']) != "") 
					{
						echo __(stripslashes(get_blog_option($blog_id, $value['id'])),'cargopress');
					}
					else
					{
						echo __($value['std'],'cargopress');
					}
				} 
				else
				{ 
					if( get_option($value['id']) != "") 
					{
						echo __(stripslashes(get_option($value['id'])),'cargopress');
					}
					else
					{
						echo __($value['std'],'cargopress');
					}
				}	
				?></textarea><br /><?php echo __($value['desc'],'cargopress'); ?></td>
		</tr>
		<?php break;

      case 'radio':
		?>
		<tr valign="top"> 
			<th scope="row"><?php echo __($value['name'],'cargopress'); ?></th>
			<td>
				<?php
				foreach ($value['options'] as $key=>$option)
				{
					if (CARGOPRESS_MB)
					{
						$radio_setting = get_blog_option($blog_id, $value['id']);						
					}
					else
					{
						$radio_setting = get_option($value['id']);						
					}
					if($radio_setting != '')
					{
						if (CARGOPRESS_MB)
						{
							if ($key == get_blog_option($blog_id, $value['id']) ) 
							{
								$checked = "checked=\"checked\"";
							}
							else
							{
								$checked = "";
							}
						}
						else
						{
							if ($key == get_option($value['id']) ) 
							{
								$checked = "checked=\"checked\"";
							}
							else
							{
								$checked = "";
							}
						}
					}
					else
					{
						if($key == $value['std'])
						{
							$checked = "checked=\"checked\"";
						}
						else
						{
							$checked = "";
						}
					}
				?>
				<input type="radio" name="<?php echo $value['id']; ?>" id="<?php echo $value['id'] . $key; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><label for="<?php echo $value['id'] . $key; ?>"><?php echo $option; ?></label><br />
				<?php 
				} ?>
			</td>
		</tr>
		<?php break;

		case 'checkbox':
		?>
		<tr valign="top"> 
			<th scope="row"><?php echo __($value['name'],'cargopress'); ?></th>
			<td>
				<?php
					if(get_option($value['id'])){
						$checked = "checked=\"checked\"";
					}else{
						$checked = "";
					}
				?>
				<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
				<label for="<?php echo $value['id']; ?>"><?php echo __($value['desc'],'cargopress'); ?></label>
			</td>
		</tr>
		<?php break;

		default:
      break;
	}
}
?>
	</table>
	<p class="submit">
		<input class="button-primary" name="save" type="submit" value="<?php _e('Save changes','cargopress'); ?>" />    
		<input type="hidden" name="action" value="save" />
	</p>
</form>

<form method="post" action="">
	<?php wp_nonce_field('cargopress-reset'); ?>
	<p class="submit">
		<input class="button-secondary" name="reset" type="submit" value="<?php _e('Reset','cargopress'); ?>" />
		<input type="hidden" name="action" value="reset" />
	</p>
</form>

<form method="post" action="">
	<?php wp_nonce_field('cargopress-reset-widgets'); ?>
	<p class="submit">
		<input class="button-secondary" name="reset_widgets" type="submit" value="<?php _e('Reset Widgets','cargopress'); ?>" />
		<input type="hidden" name="action" value="resetwidgets" />
	</p>
</form>

<p><?php _e('For more information about this theme, visit the <a href="http://github.com/nebirhos/cargopress">GitHub page</a>.', 'cargopress'); ?></p>
</div>

<?php
}
add_action('admin_menu' , 'mytheme_add_admin'); 
?>
