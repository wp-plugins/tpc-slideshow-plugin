jQuery(document).ready(function() {

	jQuery(".add-new-category-name-to-existing-slideshow-div").hide();

	jQuery(".update-category-name-select").change(function() {
		if(jQuery(this).find("option:selected").val() == "Add A New Category") {
			jQuery(".add-new-category-name-to-existing-slideshow-div").show();
		} else {
			jQuery(".add-new-category-name-to-existing-slideshow-div").hide();
		}
	});

	jQuery(".add-new-category-name-div").hide();

	jQuery(".add-new-category-name-select").change(function() {
		if(jQuery(this).find("option:selected").val() == "Add A New Category") {
			jQuery(".add-new-category-name-div").show();
		} else {
			jQuery(".add-new-category-name-div").hide();
		}
	});
	
});