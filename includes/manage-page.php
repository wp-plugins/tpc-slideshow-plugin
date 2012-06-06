<?php

function tpc_slideshow_manage_page() {
	
	$plugin_url = WP_PLUGIN_URL.'/tpc-slideshow/';
	$add_new_category_name_input = $_POST['add-new-category-name-input'];
	$update_category_name_input = $_POST['update-category-name-input'];
	
	if ( isset( $add_new_category_name_input ) ) {
		
		wp_create_category( $add_new_category_name_input );
	
	} elseif ( isset( $update_category_name_input ) ) {
		
		wp_create_category( $update_category_name_input );
	
	}

	global $successfully_added_message;
	global $successfully_deleted_message;
	global $successfully_updated_message;
	
	$get_categories = mysql_query("SELECT * FROM  `wp_terms` LIMIT 0 , 30") or die(mysql_error());
	$get_categories_again = mysql_query("SELECT * FROM  `wp_terms` LIMIT 0 , 30") or die(mysql_error());
	$get_slideshows = mysql_query("SELECT * FROM  `wp_tpc_slideshow`") or die(mysql_error());
	
	global $title;

	wp_register_style('tpc-slideshow-back-end', WP_PLUGIN_URL . '/tpc-slideshow/css/back-end.css');
	wp_enqueue_style('tpc-slideshow-back-end');
	wp_register_script('tpc-slideshow-back-end', WP_PLUGIN_URL . '/tpc-slideshow/scripts/back-end-functions.js');
	wp_enqueue_script('tpc-slideshow-back-end');
	
	echo "
		<script type='text/javascript'>
			jQuery('.add-new-category-name-select').change(function(){
			  if( jQuery(this).val() == 'Add A New Category'){
				 jQuery('.add-new-category-name-select').hide();
			  }
			});
			jQuery('.update-category-name-select').change(function(){
			  if( jQuery(this).val() == 'Add A New Category'){
				 jQuery('.update-category-name-select').hide();
			  }
			});
		</script>
	";
	
		
	echo '	
		<div class="wrap tpc-slideshow" id="sm_div">';
		
	if ( isset( $add_new_category_name_input ) && !empty( $add_new_category_name_input ) ) {

			echo '<div class="updated"><p>A new category has been added.</div></p>';
		
	} elseif ( isset( $update_category_name_input ) && !empty( $update_category_name_input ) ) {

			echo '<div class="updated"><p>A new category has been added.</div></p>';
		
	}
	
	echo $successfully_deleted_message . $successfully_added_message . $successfully_updated_message . '
			
			<h2>Create a New Slideshow</h2>
			<p>The <b><i>first</i></b> step to creating a slideshow is to create a post (AKA "Slide") in the Wordpress "Posts" section, assign it to a category of your choice, then come back here and create a slideshow from all the posts you have created (or will create) in that category.</p>
			
			<br />
			
			<form action="#" method="post">
			<table class="widefat">
				<thead>
				<tr>
					<th>Title</th>
					<th>Category</th>
					<th>Max Slides to Display</th>
					<th>Theme</th>
					<th>Transition Effect</th>
					<th>Pause Duration</th>
					<th>Speed In</th>
					<th>Speed Out</th>
					<th>Height</th>
					<th>Width</th>
					<th>Link Text</th>
					<th>Target</th>
					<th>Fade Controls</th>
					<th colspan="3"></th>
				</tr>
				</thead>
				
				<input type="hidden" name="id" value="' . $row['id'] . '" />
				
				<tbody class="plugins">
					<tr>
						<td><input type="text" name="title" value="" /></td>
						<td>

							<select name="add-new-category-name-select" class="add-new-category-name-select"> 
							';
							 
								$categories = get_categories( array( 'hide_empty' => 0 ) ); 
								foreach ($categories as $category) {
									$option = '<option value="'.$category->category_nicename.'">';
									$option .= $category->cat_name;
									$option .= '</option>';
									echo $option;
								}
							
							echo '
								<option value="Add A New Category">Add A New Category...</option>
							</select>

							<div class="add-new-category-name-div">
								<input class="add-new-category-name-input" name="add-new-category-name-input" type="text" value="" />
							</div>
							
						</td>
						<td><input type="text" style="width: 50px;" name="max-slides-to-display" value="" maxlength="3" placeholder="0" /></td>
						<td>
							<select name="theme">
	';
								if ($handle = opendir('../wp-content/plugins/tpc-slideshow/themes/')) {

									while (false !== ($file = readdir($handle))) {
										if ( $file != '.' && $file != '..' && $file != 'index.html' && $file != '.DS_Store' ) {
											echo '<option value="' . $file . '">' . ucwords(str_replace('-', ' ', $file)) . '</p>';
										}
									}

									closedir($handle);
								}

	echo '
							</select>
						</td>
						<td>
							<select name="transition-effect">
								<option value="blindX">blindX</option>
								<option value="blindY">blindY</option>
								<option value="blindZ">blindZ</option>
								<option value="cover">cover</option>
								<option value="curtainX">curtainX</option>
								<option value="curtainY">curtainY</option>
								<option value="fade">fade</option>
								<option value="fadeZoom">fadeZoom</option>
								<option value="growX">growX</option>
								<option value="growY">growY</option>
								<option value="none">none</option>
								<option value="scrollUp">scrollUp</option>
								<option value="scrollDown">scrollDown</option>
								<option value="scrollLeft">scrollLeft</option>
								<option value="scrollRight">scrollRight</option>
								<option value="scrollHorz">scrollHorz</option>
								<option value="scrollVert">scrollVert</option>
								<option value="shuffle">shuffle</option>
								<option value="slideX">slideX</option>
								<option value="slideY">slideY</option>
								<option value="toss">toss</option>
								<option value="turnUp">turnUp</option>
								<option value="turnDown">turnDown</option>
								<option value="turnLeft">turnLeft</option>
								<option value="turnRight">turnRight</option>
								<option value="uncover">uncover</option>
								<option value="wipe">wipe</option>
								<option value="zoom">zoom</option>
							</select>
						</td>
						<td><input type="text" style="width: 50px;" name="duration" value="" placeholder="0" /></td>
						<td><input type="text" style="width: 50px;" name="speed-in" value="" placeholder="0" /></td>
						<td><input type="text" style="width: 50px;" name="speed-out" value="" placeholder="0" /></td>
						<td><input type="text" style="width: 50px;" name="height" value="" placeholder="0" /></td>
						<td><input type="text" style="width: 50px;" name="width" value="" placeholder="0" /></td>
						<td><input name="read-more-link-text" type="text" value="" placeholder="Read More..." /></td>
						<td><input type="checkbox" name="target" value="_blank" /></td>
						<td>
							<select name="fade-controls">
								<option value="no">No</option>
								<option value="yes">Yes</option>
							</select>
						</td>
						<td style="text-align: right"><button name="create-a-new-slideshow" class="button-primary">Create</button></td>
					</tr>
				</table>
			</form>
						
			<br />
	';
	
	
	$num_results = mysql_num_rows( $get_slideshows ); 
	
	if ( $num_results > 0 ) { 
	echo '	
			<h3>Edit an Existing Slideshow</h3>
			
			<table class="widefat">
				<thead>
				<tr>
					<th>Title</th>
					<th>Category</th>
					<th>Max Slides to Display</th>
					<th>Theme</th>
					<th>Transition Effect</th>
					<th>Pause Duration</th>
					<th>Speed In</th>
					<th>Speed Out</th>
					<th>Height</th>
					<th>Width</th>
					<th>Link Text</th>
					<th>Target</th>
					<th>Fade Controls</th>
					<th>Shortcode</th>
					<th></th>
					<th></th>
				</tr>
				</thead>
	';

				while ($show_slideshows = mysql_fetch_array( $get_slideshows )) {
					echo '
						<form action="#" method="post">
						<tr>
							<td>
								<input type="hidden" name="id" value="' . $show_slideshows['id'] . '" />
								<p><input type="text" name="title" value="' . $show_slideshows['title'] . '" /></p>
							</td>
							
							<td>
								<select name="update-category-name-select" class="update-category-name-select"> 
									<option value="' . $show_slideshows['category'] . '">' . ucwords($show_slideshows['category']) . '</option>
		';
								 
									$categories = get_categories( array( 'hide_empty' => 0 ) ); 
									foreach ($categories as $category) {
										if( $show_slideshows['category'] != $category->category_nicename ) {
											$option = '<option value="' . $category->category_nicename . '">';
											$option .= $category->cat_name;
											$option .= '</option>';
											echo $option;
										}
									}
								
								echo '
									<option value="Add A New Category">Add A New Category...</option>
								</select>

								<div class="add-new-category-name-to-existing-slideshow-div">
									<input class="update-category-name-input" name="update-category-name-input" type="text" value="" />
								</div>
							</td>
							
							<td>
								<input type="text" style="width: 50px;" name="max-slides-to-display" value="' . $show_slideshows['max_slides_to_display'] . '" /></p>
							</td>
							
							<td>
							<select name="theme">
								<option value="' . $show_slideshows['theme'] . '">' . ucwords(str_replace('-', ' ', $show_slideshows['theme'])) . '</option>
	';
								if ($handle = opendir('../wp-content/plugins/tpc-slideshow/themes/')) {

									while (false !== ($file = readdir($handle))) {
										if ( $file != '.' && $file != '..' && $file != 'index.html' && $file != '.DS_Store' && $file != $row['theme'] && $file != $show_slideshows['theme'] ) {
											echo '<option value="' . $file . '">' . str_replace('-', ' ', ucwords($file)) . '</p>';
										}
									}

									closedir($handle);
								}

	echo '
							</select>
							</td>
							<td>
								<select name="transition-effect">
								
	';
		$transitiontypes = array('blindX','blindY','blindZ','cover','curtainX','curtainY','fade','fadeZoom','growX','growY','none','scrollUp','scrollDown','scrollLeft','scrollRight','scrollHorz','scrollVert','shuffle','slideX','slideY','toss','turnUp','turnDown','turnLeft','turnRight','uncover','wipe','zoom');
	
	foreach($transitiontypes as $type){
		echo '<option value="'.$type.'"';
		if ( $show_slideshows['transition_effect'] == $type ) {	echo ' selected'; }
		echo '>'.$type.'</option>
		';		
	}
								
	echo '
								</select>
							</td>
							<td><input type="text" style="width: 50px;" name="duration" value="' . $show_slideshows['duration'] . '" /></td>
							<td><input type="text" style="width: 50px;" name="speed-in" value="' . $show_slideshows['speed_in'] . '" /></td>
							<td><input type="text" style="width: 50px;" name="speed-out" value="' . $show_slideshows['speed_out'] . '" /></td>
							<td><input type="text" style="width: 50px;" name="height" value="' . $show_slideshows['height'] . '" /></td>
							<td><input type="text" style="width: 50px;" name="width" value="' . $show_slideshows['width'] . '" /></td>
							<td><input type="text" name="read-more-link-text" value="' . $show_slideshows['read_more_link_text'] . '" /></td>
							<td><input type="checkbox" name="target" value="_blank" ';

								if ( $show_slideshows['target'] == '_blank' ) {
														echo 'checked="checked"';
								}
							
	echo ' />
							</td>
							
							<td>
								<select name="fade-controls">
									<option value="' . $show_slideshows['fade_controls'] . '">' . ucfirst($show_slideshows['fade_controls']) . '</option>
	';
								if($show_slideshows['fade_controls'] == 'yes' ) {
									echo '<option value="no">No</option>';
								} elseif($show_slideshows['fade_controls'] == 'no' ) {
									echo '<option value="yes">Yes</option>';
								}
	
	echo '
							</td>
							<td><p class="code">[tpc_slideshow title="' . $show_slideshows['title'] . '"]</p></td>
							
							<td style="text-align: right">
								<button name="update-this-slideshow" class="button-primary">Update</button>
							</td>

							<td style="text-align: right">
								<button name="delete-this-slideshow" class="button-secondary">Delete</button>
							</td>
						</tr>
						</form>
					';
				}
		
	echo '
				</tbody>
			</table>
	';
	
	}
	
	echo '
		</div>
	';
	
}

?>