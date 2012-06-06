<?php

function tpc_slideshow_overview_page() {

	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	
	echo '
		<div class="wrap" id="sm_div">
			<h2>Slideshow Plugin</h2>
			<p>This plugin allows back end users to create multiple slideshows that display posts from multiple categories which front end users can cycle through via previous and next buttons or by selecting the position indicator icon.</p>
			<p><a href="?page=slideshow-documentation-page">Documentation</a> on how to use this plugin can be found underneath the "Slideshow" panel (on the left of your screen).</p>
		</div>
	';
}

?>