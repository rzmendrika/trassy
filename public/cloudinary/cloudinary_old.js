var files = 0;
var uploadedNb = 0;
var pictures = [] ;

$(document).ready( function () 
{
	if( $.fn.cloudinary_fileupload !== undefined ) 
	{
		$("input.cloudinary-fileupload[type=file]").cloudinary_fileupload();
	}

	$(document).on('change', '.cloudinary-fileupload', function ()
	{
		files = this.files;
	})

	$('.cloudinary-fileupload')
	.bind('cloudinarydone', function(e, data)
	{
		var path     = data.result.public_id;
		var type     = $(this).parent('label').attr('data');
		var child    = $(this).parent('label').attr('data-child');
        var container = $(this).parent('label').attr('data-container');

		var pic = {
			'type' : type,
			'child': child,
			'path' : path,
		}
		pictures.push(pic);

		uploadedNb++;
		if( uploadedNb === files.length )
		{
			uploadedNb = 0;
			var route = $('#url').val();
			
			$.post({
				url : route,
				data: { pictures: JSON.stringify(pictures) },
				success: function (response) 
				{
					$(container).find('.spinner-border').remove();
					$(container).find('.opac').removeClass('opac');
					$('#progress-bar').parent('.progress').hide();

					var length = $(container).find('.pic-thumb').length;
					var badge  = $('button[data-target="'+ container +'"]').find('.badge').text(length);

					response.data.pictures.forEach( function (pic, i) 
					{
						var thumb  = $('.pic-thumb.pic-temp')[i];
			            $(thumb).find('img').attr('src', pic.path);
			            $(thumb).find('button').attr('data', pic.id);
					})

					setTimeout( function () 
					{
			        	$('.pic-temp').removeClass('pic-temp');
					}, 500)
				},
				error: function (response)
				{
					console.log(response)
				}
			});
		}
	})
	.bind('fileuploadstart', function(e, data)
	{
		var that = $(this);
		$('.alert').alert('close');
		setTimeout( function () 
		{
	        var container = that.parent('label').attr('data-container');

			var i = 0;
			var interval = setInterval( function () 
			{
				if (files.item(i) !== null) 
				{
					var thumb  = $('.pic-thumb.d-none').clone();
		        	var reader = new FileReader();

			        reader.onload = function(e) 
			        {
			            $(thumb).find('img').attr('src', e.target.result);
			        };
		        	reader.readAsDataURL(files.item(i));

			        $(thumb).removeClass('d-none');
			        $(thumb).addClass('pic-temp');
			        $(container).find('.row').prepend( $(thumb) );
		        	
		        	i++;
				}
				else
				{
					clearInterval(interval);
				}
			}, 100);

		}, 100)

		var progress = $('#progress-bar');

		$(progress).attr('aria-valuenow', '0');
		$(progress).css('width', '0%');
		$(progress).parent('div').insertAfter( $(this).parent('label').parent('div') );
		$(progress).parent('div').show();
	})
	.bind('cloudinaryprogressall', function(e, data)
	{
		var progress = $('#progress-bar');
		var uploaded = Math.max(0, Math.round( (data.loaded * 100.0) / data.total) - 5);

		$(progress).attr('aria-valuenow', uploaded);
		$(progress).css('width', uploaded + '%');
	})
	.bind('cloudinaryalways', function(e, data)
	{
		if(data.textStatus == 'error')
		{
			$('#progress-bar').parent().hide();
			$('#erreur').toast("show");
			$('#pic-parent').find('.spinner').parent().remove();
		}
	})

	$(document).on('click', '.pic-thumb .btn-delete', function ()
	{
		$(this).children('i').removeClass('fa fa-trash');
		$(this).children('i').addClass('spinner-border spinner-border-sm');
		$(this).next('img').css('opacity', '0.4');

		var thumb = $(this).parent();
		var route  = $('#url').val() + '/' + $(this).attr('data');
        
        $.ajax({
            url: route,
            type: 'DELETE',
            success: function (response)
            {
                if( response.status == 'done' )
                {
                    thumb.fadeOut(500, function () 
                    {
						var length = $(thumb).parent().find('.pic-thumb').length - 1;
                        var id     = thumb.parent().parent().parent().attr('id');

                        thumb.remove();
                        $('button[data-target="#'+ id +'"]').find('.badge').text(length)
                    });
                }
            },
            error: function (response) {
                console.log(response);
            }
        })
	})

	var refreshPictureAccess = function ()
	{
		
	}
})