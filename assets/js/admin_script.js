(function($){

	$(document).ready(function(){
		$('button#author_info_image').on("click", function( e ){

			e.preventDefault();


			var imageUploader = wp.media({
				'title' : 'Upload Author Image',
				'button' : {
					'text' : 'Set the Image'
				},
				'multiple' : false
			});

			imageUploader.open();

			var button = $(this);


			imageUploader.on("select", function(){

				var image = imageUploader.state().get("selection").first().toJSON();

				var link = image.url;

				button.next('input.image_er_link').val( link );

				button.parent('.widget_field').find('img').attr('src', link);

			});
			
		});

	});

}(jQuery))