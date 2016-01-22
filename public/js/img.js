$(document).ready(function($){

	images = new Array();
	$(document).on('change','.coverimage',function(){
		 files = this.files;
		 $.each( files, function(){
			 file = $(this)[0];
			 if (!!file.type.match(/image.*/)) {
	        	 var reader = new FileReader();
	             reader.readAsDataURL(file);
	             reader.onloadend = function(e) {
	            	img_src = e.target.result; 
	            	html = "<div style='width:150px;height:220px;float: left;margin: 0 10px 10px 0;'>" +
					"<input style='width:150px;' class='form-control' value='' name='image'>" +
					"<input type='hidden' type='text' value='' name='titre_image_"+i+"'>" +
					"<img class='img-thumbnail' style='width:120px;margin:20px;' src='"+img_src+"'></div>";

	            	$('#image_container').append( html );
	             };
        	 } 
		});
	});

});