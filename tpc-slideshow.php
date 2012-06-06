<?php
/*
Plugin Name: The Portland Company Slideshow Plugin
Plugin URI: http://www.ThePortlandCompany.com/Plugins/Slideshow
Description: This plugin allows back end users to create multiple slideshows that display posts from multiple categories which front end users can cycle through via a previous and next buttons or by selecting the position indicator icon. Text, images and video can be displayed.
Version: 1.0
Author: The Portland Company
Author URI: http://www.ThePortlandCompany.com
License: GPL2

Copyright 2010  THE PORTLAND COMPANY  (email : Us@ThePortlandCo.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$tpc_slideshow_version = "1.0"; /* Don't forget to update the Version numberr in the meta data above. */
$table_name = $wpdb->prefix . "tpc_slideshow";
$plugin_path = WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__));


// CREATES THE DATABASE
function tpc_slideshow_install() {
   global $wpdb;
   global $tpc_slideshow_version;
   $table_name = $wpdb->prefix . "tpc_slideshow";
   
   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
      
      $sql = "
			CREATE TABLE `$table_name` (
				`id` tinyint(3) NOT NULL AUTO_INCREMENT,
				`title` varchar(200) NOT NULL,
				`category` varchar(200) NOT NULL,
				`max_slides_to_display` mediumint(3) NOT NULL,
				`duration` int(6) NOT NULL,
				`speed_in` int(6) NOT NULL,
				`speed_out` int(6) NOT NULL,
				`height` int(6) NOT NULL,
				`width` int(6) NOT NULL,
					`theme` varchar(200) NOT NULL,
				`transition_effect` varchar(50) NOT NULL,
				`fade_controls` varchar(3) NOT NULL,
				`target` varchar(10) NOT NULL,
				`read_more_link_text` varchar(25) NOT NULL,
				UNIQUE KEY `id` (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;
		);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

      $rows_affected = $wpdb->insert( $table_name, array( 'time' => current_time('mysql'), 'name' => $welcome_name, 'text' => $welcome_text ) );
 
      add_option("tpc_slideshow_current_version", $tpc_slideshow_version);

   }
}

register_activation_hook(__FILE__,'tpc_slideshow_install'); // RUNS THE INSTALLATION OF THE PLUGIN


// USED FOR UPGRADING
$installed_version = get_option( "tpc_slideshow_current_version" ); // GETS THE PLUGIN VERSION

// CHECKS TO SEE IF THE CURRENT VERSION INSTALLED IS DIFFERENT FROM THE LATEST VERSION
if( $installed_version != $tpc_slideshow_version ) {

      $sql = "
			CREATE TABLE `$table_name` (
				`id` tinyint(3) NOT NULL AUTO_INCREMENT,
				`title` varchar(200) NOT NULL,
				`category` varchar(200) NOT NULL,
				`max_slides_to_display` mediumint(3) NOT NULL,
				`duration` int(6) NOT NULL,
				`speed_in` int(6) NOT NULL,
				`speed_out` int(6) NOT NULL,
				`height` int(6) NOT NULL,
				`width` int(6) NOT NULL,
				`theme` varchar(200) NOT NULL,
				`transition_effect` varchar(50) NOT NULL,
				`fade_controls` varchar(3) NOT NULL,
				`target` varchar(10) NOT NULL,
				`read_more_link_text` varchar(25) NOT NULL,
				UNIQUE KEY `id` (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;
		);";
	
	// UPDATE `Table A`
	// SET `Table A`.`text`=concat_ws('',`Table A`.`text`,`Table B`.`B-num`," from ",`Table B`.`date`,'/')
	// WHERE `Table A`.`A-num` = `Table B`.`A-num`

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);

	update_option( "tpc_slideshow_current_version", $tpc_slideshow_version );

}



// CREATE NEW SLIDESHOW
// CREATE NEW SLIDESHOW
$create_new_slideshow_button = $_POST['create-a-new-slideshow'];
$delete_this_slideshow_button = $_POST['delete-this-slideshow'];
$update_this_slideshow_button = $_POST['update-this-slideshow'];

$id = $_POST['id'];
$title = $_POST['title'];	
$update_category_name_select = $_POST['update-category-name-select'];
$update_category_name_input = $_POST['update-category-name-input'];
$add_new_category_name_select = $_POST['add-new-category-name-select'];
$add_new_category_name_input = $_POST['add-new-category-name-input'];
$max_slides_to_display = $_POST['max-slides-to-display'];
$duration = $_POST['duration'];
$speed_in = $_POST['speed-in'];
$speed_out = $_POST['speed-out'];
$height = $_POST['height'];
$width = $_POST['width'];
$theme = $_POST['theme'];
$fade_controls = $_POST['fade-controls'];
$target = $_POST['target'];
$read_more_link_text = $_POST['read-more-link-text'];
$transition_effect = $_POST['transition-effect'];


if ( isset( $create_new_slideshow_button ) ) {

	if ( $add_new_category_name_select == 'Add A New Category' && empty( $add_new_category_name_input ) ) {
	
		$successfully_added_message = '<div class="error"><p>It appears you selected to add a new category but did not enter one.</p></div>';
		
	} elseif ( $add_new_category_name_select == 'Add A New Category' && !empty( $add_new_category_name_input ) ) {
			
		$wpdb->insert( $table_name, array( 'title' => $title, 'category' => $add_new_category_name_input, 'max_slides_to_display' => $max_slides_to_display, 'duration' => $duration, 'speed_in' => $speed_in, 'speed_out' => $speed_out, 'height' => $height, 'width' => $width, 'transition_effect' => $transition_effect, 'theme' => $theme, 'fade_controls' => $fade_controls, 'target' => $target, 'read_more_link_text' => $read_more_link_text ) );
		
		$successfully_added_message = '<div class="updated"><p>You have successfully create a slideshow titled: "' . $title . '".</p></div>';
			
	} else {
			
		$wpdb->insert( $table_name, array( 'title' => $title, 'category' => $add_new_category_name_select, 'max_slides_to_display' => $max_slides_to_display, 'duration' => $duration, 'speed_in' => $speed_in, 'speed_out' => $speed_out, 'height' => $height, 'width' => $width, 'transition_effect' => $transition_effect, 'theme' => $theme, 'fade_controls' => $fade_controls, 'target' => $target, 'read_more_link_text' => $read_more_link_text ) );
		
		$successfully_added_message = '<div class="updated"><p>You have successfully create a slideshow titled: "' . $title . '".</p></div>';
			
	}

} elseif ( isset( $update_this_slideshow_button ) ) {

	if ( $update_category_name_select == 'Add A New Category' && empty( $update_category_name_input ) ) {
	
		$successfully_added_message = '<div class="error"><p>It appears you selected to add a new category but did not enter one.</p></div>';
		
	} elseif ( $update_category_name_select != 'Add A New Category' ) {
		
		$wpdb->update( $table_name, array( 'title' => $title, 'category' => $update_category_name_select, 'max_slides_to_display' => $max_slides_to_display, 'duration' => $duration, 'speed_in' => $speed_in, 'speed_out' => $speed_out, 'height' => $height, 'width' => $width, 'theme' => $theme, 'transition_effect' => $transition_effect, 'fade_controls' => $fade_controls, 'target' => $target, 'read_more_link_text' => $read_more_link_text ), array( 'id' => $id ) );
		
		$successfully_updated_message = '<div class="updated"><p>You have successfully updated the slideshow titled: "' . $title . '".</p></div>';
		
	} else {
			
		$wpdb->update( $table_name, array( 'category' => $update_category_name_input, 'max_slides_to_display' => $max_slides_to_display, 'duration' => $duration, 'speed_in' => $speed_in, 'speed_out' => $speed_out, 'height' => $height, 'width' => $width, 'transition_effect' => $transition_effect, 'theme' => $theme, 'fade_controls' => $fade_controls, 'target' => $target, 'read_more_link_text' => $read_more_link_text ), array( 'id' => $id ) );
		
		$successfully_added_message = '<div class="updated"><p>Cat: ' . $update_category_name_input . ' You have successfully updated  slideshow titled: "' . $title . '".</p></div>';
			
	}
	
} elseif ( isset( $delete_this_slideshow_button ) ) {

	$wpdb->query("DELETE FROM $table_name WHERE id = $id");
	
	$successfully_deleted_message = '<div class="updated"><p>You have deleted the slideshow titled: "' . $title . '".</p></div>';
	
}



// CREATE AN ADMINISTRATION PAGE BENEATH THE "SETTINGS" PANEL IN WORDPRESS
// CREATE AN ADMINISTRATION PAGE BENEATH THE "SETTINGS" PANEL IN WORDPRESS
add_action('admin_init', 'tpc_slideshow_admin_init');
add_action('admin_menu', 'tpc_slideshow_admin_menu');

function tpc_slideshow_admin_init() {

	/* Register our stylesheet. */
	wp_register_style('tpc-slideshow-back-end', WP_PLUGIN_URL . '/tpc-slideshow/back-end.css');

}
    
function tpc_slideshow_admin_menu() {

	/* Register our plugin page */
	add_menu_page( 'Slideshow Overview', 'Slideshow', 'manage_options', 'slideshow-overview-page', 'tpc_slideshow_overview_page', $icon_url, $position );
	// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	
	add_submenu_page( 'slideshow-overview-page', 'Overview', 'Overview', 'manage_options', 'slideshow-overview-page', 'tpc_slideshow_overview_page');
	// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
	
	add_submenu_page( 'slideshow-overview-page', 'Manage', 'Manage', 'manage_options', 'tasks-manage-page', 'tpc_slideshow_manage_page');
	
	add_submenu_page( 'slideshow-overview-page', 'Documentation', 'Documentation', 'manage_options', 'tasks-documentation-page', 'tpc_slideshow_documentation_page');

   
	/* Using registered $page handle to hook stylesheet loading */
	add_action('admin_print_styles-' . $page, 'tpc_slideshow_admin_styles');

}


// CREATES THE OVERVIEW PAGE
include_once('includes/overview-page.php');


// CREATES THE MANAGE PAGE
include_once('includes/manage-page.php');


// CREATES THE DOCUMENTATION PAGE
include_once('includes/documentation-page.php');


// THIS CODE IS TO BE INCLUDED IN THE HEAD OF THE TEMPLATE AND IT HELPS ENSURE THE SLIDESHOW DOESN'T APPEAR TEMPORARILY UNSTYLE DURING THE PAGE LOAD
function tpc_slideshow_externals() {
	
	echo "
		<script type='text/javascript'>
			jQuery('html').hide()
			jQuery(document).ready(function() {
				jQuery('html').show();
			});
		</script>		
	";

}

add_action('wp_head', 'tpc_slideshow_externals'); // THIS ADDS THE CODE WITHIN THE tpc_slideshow_externals FUNCTION INTO THE HEAD OF THE WEBSITES THEME.


// THIS CODE IS TO BE INCLUDED WHEREVER THE SHORTCODE OR PHP IS PLACED.
function tpc_slideshow_front_end( $title ) {

	global $table_name;
	global $plugin_path;
	
	extract( shortcode_atts( array( 'title' => $title, ), $title ) );

	$result = mysql_query("SELECT * FROM $table_name WHERE title = '$title'");

	while ( $row = mysql_fetch_array( $result ) ) {
		$category = $row['category'];
		$max = $row['max_slides_to_display'];
		$theme = $row['theme'];
		$duration = $row['duration'];
		$speed_in = $row['speed_in'];
		$speed_out = $row['speed_out'];
		$height = $row['height'];
		$width = $row['width'];
		$transition = $row['transition_effect'];
		$fade_controls_option = $row['fade_controls'];
		$target = $row['target'];
		$read_more_link_text = $row['read_more_link_text'];
		wp_register_style('tpc-slideshow-front-end', WP_PLUGIN_URL . '/tpc-slideshow/themes/' . $theme . '/styles.css');
		wp_enqueue_style('tpc-slideshow-front-end');
		wp_register_script('tpc-slideshow-front-end', WP_PLUGIN_URL . '/tpc-slideshow/scripts/front-end-functions.js');
		wp_enqueue_script('tpc-slideshow-front-end');
	}
	
	if ( $fade_controls_option == 'yes' ) {
		$fade_controls = 'fade-';
	}
	
	// IF THE TITLE IN THE SHORT CODE OR FUNCTION DOESNT EXIST IN THE DATBASE THEN DONT DISPLAY THE CODE AT ALL.
	if (mysql_num_rows(mysql_query("SELECT * FROM $table_name WHERE title = '$title'"))) {
					
	echo '

		<div class="tpc-slideshow-container-">		
		
			<input class="duration" type="hidden" value="' . $duration . '">
			<input class="speed-in" type="hidden" value="' . $speed_in . '">
			<input class="speed-out" type="hidden" value="' . $speed_out . '">
			<input class="transition" type="hidden" value="' . $transition . '">
				
			<!-- BEGINNING OF CONTROLS -->
			<div class="' . $fade_controls . 'controls">
			
				<span class="pause-button">Pause</span>
				<span class="control previous-button">Previous</span>
				<span class="control next-button">Next</span>
				
			</div><!-- END OF CONTROLS -->
	';
				query_posts('category_name=' . $category . '&posts_per_page=' . $max );
	
				$counter = 0;
	
				echo '<div class="slides">';
	
					while (have_posts()) : the_post();
	
						echo '<div class="slide">';
								
							echo '<span class="slideshow-the-excerpt">';
								the_excerpt();
							echo '</span>';
								
							echo '<a class="slideshow-read-more-link" target="' . $target . '" href="';
								the_permalink();
							echo '">' . $read_more_link_text . '</a>';
								
							echo '<span class="slideshow-the-content">';
								the_content();
							echo '</span>';
							
							echo '<span class="slideshow-the-title">';
								the_title();
							echo '</span>';
							
							echo '<span class="slideshow-the-author">';
								the_author();
							echo '</span>';
							
							echo '<span class="slideshow-the-featured-image">';
								the_post_thumbnail( full ); // Integrate the option to use thumbnail, medium or large sizes or define the values themselves using array( 'width', 'height' )
							echo '</span>';

						echo '</div><!-- END OF SLIDE CLASS -->';
		
						$counter++;

					endwhile;

				echo '
				
				</div><!-- END OF SLIDE INNER -->
				
';

			//IF PAGINATION IS ON IN USER SETTINGS (to be created)
			echo '<div class="pagination-container">';
		
				// WHEN HOVERED OVER, THE CLASS 'PAGINATOR-HOVER' IS ADDED BY SLIDESHOW.JS LOCATED IN THE SCRIPTS DIRECTORY FOR THIS PLUGIN, THIS CAN BE USED FOR STYLING PURPOSES.
				for ( $i = $counter; $i > 0; $i-- ) {
					echo '
						<span class="paginator" role="' . ($i-1) . '">
						
							<span class="slide-number">' . $i . '</span>
						
							<span class"pagination-thumbanil">';
					
	
					while (have_posts()) : the_post();
	
						$key = "Thumbnail";
						echo get_post_meta($post->ID, $key, true); 

					endwhile;
					
					echo '
							</span>
							
						</span>
					';
				}

			echo '</div>
				
			</div><!-- END OF SLIDE SHOW -->
	';
	
	}
	
	wp_reset_query();
	
}

add_shortcode('tpc_slideshow', 'tpc_slideshow_front_end'); // GENERATES THE SHORTCODE [tpc_slideshow]