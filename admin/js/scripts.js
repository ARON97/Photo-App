$(document).ready(function(){

// VARIABLES
var user_href;
var user_href_splitted;
var user_id;
var image_src;
var image_href_splitted;
var image_name;
var photo_id;


$(".modal_thumbnails").click(function(){

	$("#set_user_image").prop('disabled', false); // enabling the selection button

	$(this).addClass('selected');
	user_href = $("#user-id").prop('href'); // extracting the user id from the server
	user_href_splitted = user_href.split("="); // spliting
	user_id = user_href_splitted[user_href_splitted.length -1]; // checking the length and minus by 1

	image_src = $(this).prop("src"); // this is a pseudo variable. Pulling out the source
	image_href_splitted = image_src.split("/"); // splitting
	image_name = image_href_splitted[image_href_splitted.length -1]; // checking the length and minus by 1


	photo_id = $(this).attr("data");

	// AJAX CALL FOR SIDEBAR
	$.ajax({

			url: "includes/ajax_code.php", // setting a path for information to be sent
			data:{photo_id: photo_id},
			type: "POST",
			success:function(data) {
				// if the user image has been set. Checking for errors
				if (!data.error) {
					// what ever we get from the server is being entered into rhe modal_sidebar
					$("#modal_sidebar").html(data);
				}
			}

	});

});

// SETTING USER IMAGE WITH AJAX
$("#set_user_image").click(function(){

	$.ajax({

			url: "includes/ajax_code.php", // setting a path for information to be sent
			data:{image_name: image_name, user_id:user_id},
			type: "POST",
			success:function(data) {
				// if the user image has been set. Checking for errors
				if (!data.error) {
					// function to replace just the image
					$(".user_image_box a img").prop('src', data);
				}
			}

	});

});


/************** Edit Photo Sidebar Event Handler *******************/
$(".info-box-header").click(function(){

	$(".inside").slideToggle("fast");

	$("#toggle").toggleClass("glyphicon-menu-down glyphicon , glyphicon-menu-up glyphicon ");


});

/**** Delete function */
$(".delete_link").click(function(){

	return confirm("Are you sure you want to delete this item");



});


tinymce.init({selector:'textarea'});

});