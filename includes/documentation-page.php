<?php

function tpc_slideshow_documentation_page() {
	$screen = get_current_screen();
	$screen->add_help_tab( array( 'id' => $screen->id, 'title' => __('My Title'),'content' => __('My content') ) );
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

	echo '
		<div class="wrap" id="sm_div">
			<h2>Slideshow Documentation</h2>
			<h3 id="documentation">Documentation</h3>
			
		<div id="poststuff" class="metabox-holder">
			<div class="postbox">
				<h3 class="hndle"><span>How do I add a slideshow to a page?</span></h3>
				<div class="inside">
					<p>To display a slideshow on a particular page, copy the following "shortcode" and paste it into the page you want it to display on:</p>
					<p class="code">[tpc_slideshow title="<i><b>name-of-your-slideshow</b></i>"]</p>
				</div>
			</div>
			
			<div class="postbox">
				<h3 class="hndle"><span>What does "maximum number of slides" mean?</span></h3>
				<div class="inside">
					<p>Every slideshow requires you to create a "slide". If you have created 10 slides, for example, and you only want to show the last 5 then you enter that number in the "Maximum number of slides" field.</p>
				</div>
			</div>
			
			<div class="postbox">
				<h3 class="hndle"><span>How do I add a slide to my newly created slideshow?</span></h3>
				<div class="inside">
					<p>To add a new slideshow simply create a new post and assign it to a category of your choice. If you are not familiar with what a "Post" is, or how to create a category to put that post in, please refer to <a href="http://codex.wordpress.org/Writing_Posts">Wordpress documentation</a>.</p>
				</div>
			</div>
			
			<div class="postbox">
				<h3 class="hndle"><span>How do I link a slide?</span></h3>
				<div class="inside">
					<p>Linking a slide to a particular post or page should be done when editing the post. For example, if you have an image you want linked to that post, you must add the link as you normally would when inserting an image.</p>
				</div>
			</div>
			
			<div class="postbox">
				<h3 class="hndle"><span>How do I change the order of the slides?</span></h3>
				<div class="inside">
					<p>Slides are ordered by the date they were created, if you would like to change their order you must visit the "Posts" section of Wordpress and edit the date there.</p>
				</div>
			</div>
		</div>
						
			<br />
			
			<h3>Developer Notes</h3>
			<div id="poststuff" class="metabox-holder">
			<div class="postbox">
				<h3 class="hndle"><span>PHP Code</span></h3>
				<div class="inside">
					<p>If you are a developer you may use the following PHP code:</p>
					<p class="code">&#60;?php tpc_slideshow_front_end("<i><b>title-of-your-slideshow</b></i>"); ?&#62;</p>
				</div>
			</div>
			
			<div class="postbox">
				<h3 class="hndle"><span>Styling and Themeing</span></h3>
				<div class="inside">
					<p>If you want to change the default style of the slideshow by adding or creating your own, you may deposit it into the <span class="code">wp-content/plugins/tpc-slideshow/themes</span> directory. You must also change the URL to the stylesheet in <span class="code">wp-content/plugins/tpc-slideshow/tpc-slideshow.php</span> within the <span class="code">tpc_slideshow_externals()</span> PHP function.</p>
					<p>If you choose to create a custom theme it must be valid by ensuring these steps are taken:</p>
					<p>1. The theme must be placed in the themes directory using all lowercase, no special characters, dashes instead of spaces or underscores (Ex. example-theme).</p>
					<p>The stylesheet must be in the root of the directory and names "styles.css".</p>
				</div>
			</div>

			
			<div class="postbox">
				<h3 class="hndle"><span>Roadmap</span></h3>
				<div class="inside">
					<p>For those who are fans of this plugin here is a <i>"roadmap"</i> of our plans to enhance this plugin:</p>
					<p>1. Currently users must go to the "Posts" section to create a slide, we will be implementing the visual editor with the media upload icons and the categories panel into this page for a simplified experience. Though they will still be "Posts" and will still be addable/editable in the "Posts" section.</p>
					<p>2. Add a delete confirmation alert prior to allowing the user to delete a slideshow.</p>
					<p>3. Integrate thumbnails option for position indicators.</p>
					
					<br />
					
					<p>Have an idea or feature request? <a href="mailto:us@theportlandco.com">Tell us!</a></p>
				</div>
			</div>
			
			<div class="postbox">
				<h3 class="hndle"><span>Contributers</span></h3>
				<div class="inside">
					<p>Spencer Hill - Lead PHP, CSS & Wordpress Developer</p>
					<p>Brandon Selway - Lead Javascript Developer</p>
				</div>
			</div>
		</div>
	';

}

?>