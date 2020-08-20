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
		files    = this.files;
		pictures = [] ;
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
                        thumb.remove();
                    });

                    refreshPictureAccess();
                }
            },
            error: function (response) {
                console.log(response);
            }
        })
	})

	$(document).on('fileuploadstart', '.cloudinary-fileupload', function(e, data)
	{
		var progress = $('#progress-bar');

		$(progress).attr('aria-valuenow', '2');
		$(progress).css('width', '2%');
		$(progress).parent('div').show();
	})

	$(document).on('cloudinaryprogressall', '.cloudinary-fileupload', function(e, data)
	{
		var progress = $('#progress-bar');
		var uploaded = Math.max(0, Math.round( (data.loaded * 100.0) / data.total) - 5);

		$(progress).attr('aria-valuenow', uploaded);
		$(progress).css('width', uploaded + '%');
	})

	$(document).on('cloudinaryalways', '.cloudinary-fileupload', function(e, data)
	{
		if(data.textStatus == 'error')
		{
			$('#progress-bar').parent().hide();
			$('#toast-erreur').toast("show");
			$('#pic-parent').find('.spinner').parent().remove();
		}
	})

	$(document).on('cloudinarydone', '.cloudinary-fileupload', function(e, data)
	{
		var path     = data.result.public_id;
		var type     = $(this).parent('label').attr('data');
		var child    = $(this).parent('label').attr('data-child');

		var pic = {
			'type' : type,
			'child': child,
			'path' : path,
		}
		pictures.push(pic);

		uploadedNb++;
		if( uploadedNb === files.length )
		{
			$(this).remove();
			uploadedNb = 0;
			var route  = $('#url').val();
			
			$.post({
				url : route,
				data: { pictures: JSON.stringify(pictures) },
				success: function (response) 
				{
                    refreshPictureAccess();
					$('#progress-bar').parent('.progress').hide();
					response.data.pictures.forEach( function (pic, i) 
					{
						var thumb  = $('.pic-thumb.d-none').clone();
			            $(thumb).find('img').attr('src', pic.path);
			            $(thumb).find('button').attr('data', pic.id);
			            $(thumb).removeClass('d-none');
			            
			            $(thumb).insertAfter( $('.show.tab-pane .content-add') );
					})
				},
				error: function (response)
				{
					console.log(response)
				}
			});
		}
	})

	$(document).on('click', '.content-add.error', function ()
	{
		$('#toast-erreur').toast('show');
	})

	$('.tab-link').click( function ()
	{
		setTimeout( function ()
		{
			refreshPictureAccess();
		}, 200);
	})

	var refreshPictureAccess = function ()
	{
		var route  = $('#url').val() + '/tag';
		
		$('.cloudinary-fileupload').remove();
		$.get(route, function (response)
		{
			$('.cloudinary-fileupload').remove();
			if( response.data.now == response.data.max || response.data.tag == '' )
			{
				$('.content-add').addClass('error');
			}
			else
			{
				$('.content-add').removeClass('error');
				$('#tabContent .active .content-add label').append($(response.data.tag));
				$('.cloudinary-fileupload').val(null);
				$("input.cloudinary-fileupload[type=file]").cloudinary_fileupload();
			}
			$('.alert span').text(response.data.now);
		})
	}
})

