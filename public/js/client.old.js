$(document).ready(function ()
{
    var row;
    var picturePlaceholder = '/pictures/placeholder-image.png';

    $('.delete-trigger').click(function ()
    {
        row   = $(this).parent().parent();

        var data  = $.parseJSON( row.attr('data') );
        var body  = $('#delete-text' ).val().replace('%r', data.name);
        var title = $('#delete-title').val().replace('%r', data.name);

        $('#deleteModal .modal-title').html( title );
        $('#deleteModal .modal-body' ).html( body );
    });

    $('.confirm-delete').click( function ()
    {
        var id     = $.parseJSON( row.attr('data') ).id;
        var route  = $('#delete-route').val().replace('%r', id);

        $.ajax({
            url: route,
            type: 'DELETE',
            success: function (response)
            {
                if( response.status == 'done' )
                {
                    row.fadeOut(500, function () {
                        row.remove();
                    });
                }
            },
            error: function (response) {
                console.log(response);
            }
        })
    })

    // show pictures before upload
    $(document).on('change', ".pic-file",  function()
    {
        var input = this;
        var img   = $(input).parent().prev();

        if (input.files && input.files[0] && input.files[0].size < 520000)
        {
            var reader = new FileReader();
            reader.onload = function(e) {
                img.attr('src', e.target.result);

                var data  = $.parseJSON( $(input).attr('data') );
                data.path = e.target.result;
           
                $(input).attr('data', JSON.stringify(data));
            };

            reader.readAsDataURL(input.files[0]); // convert to base64 string

            img.parent().removeClass('border-danger');
            img.parent().addClass('border-grey');
            img.prev('span').remove(); // remove error
        }   
        else
        {
            img.parent().addClass('border-danger');
            img.parent().removeClass('border-grey');
            img.attr('src', picturePlaceholder);

            if( img.prev('span').length === 0 )
                img.before('<span class="alert alert-danger p-2 pt-1" role="alert" style="position: absolute; width: 70%; right: 19px"><small>Fichier trop lourd.</small><span class="close" style="cursor: pointer" data-dismiss="alert" aria-label="Close" aria-hidden="true">&times;</span></span>');
        }
    });

    
    $(document).on('change', ".current-picture-uploads textarea",  function()
    {
        var input    = $(this).prev('label').children('input');
        var data     = $.parseJSON( $(input).attr('data') );
        data.comment = $(this).val();
   
        $(input).attr('data', JSON.stringify(data));
    });

    $('.btn-pic-end').click( function ()
    {
        $('#files').append( $('.current-picture-uploads input[type="file"]') );
        $('.current-picture-uploads').remove();
    })

    $('.btn-submit').click( function (e)
    {
        var inputs = $("#files").find('.pic-file');
        var hidden = $('input[type="hidden"]').first();

        inputs.each( function (i, input)
        {
            var clone = hidden.clone();
            var data  = $.parseJSON( $(input).attr('data') );
            data.path = '';
            data.name = 'pic_file_' + i;

            $(input).attr('name', data.name);

            $(clone).val( JSON.stringify(data) );
            $(clone).attr('name', 'pic_' + i );

            $('#files').append( $(clone) );
        })

        $("#form").submit();
    })

    // child script
    $('.btn-child').click( function ()
    {
        $('#submit-child').attr("disabled", false);
    	
        if( $(this).hasClass('btn-add-child') )
    	{
    		var url = $('#child-url').val() + '/create';
    	}
    	else
    	{
    		var url = $('#child-url').val() + '/' + $(this).attr('data') + '/edit';
    	}

		$('#child-form').html("");
		$('#child-form').prev().removeClass('d-none');
    	$.get(url, function (response)
    	{
			$('#child-form').prev().addClass('d-none');
    		$('#child-form').html(response);
    	})
    })

    $('#submit-child').click( function ()
    {
        var form     = new FormData( $('#child-form')[0] );
        var pictures = $('#child-form input[type="file"]');
        var id       = $('#child-id').val();

        $('#submit-child span').toggleClass("d-none");
        $('#submit-child').attr("disabled", true);

        pictures.each( function (i, file)
        {
            if(file.files[0] !== undefined)
                form.append( $(file).attr('name'), file.files[0] );
        })

        $('#child-form input[type="checkbox"]').each( function (i, input)
        {
        	form.set( $(input).attr('name'), $(input).is(":checked") ? 1 : 0 )
        })

        if( parseInt(id) == 0 || id == '')
        {
            var url  = $('#child-url').val();
            form.append( 'parent_id', $('#id').val() );
        }
        else
        {
            var url  = $('#child-url').val() + '/' + id;
            form.append('_method', 'PUT');
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: form,
            success: function (response)
            {
                $('#submit-child').attr("disabled", false);
                $('#submit-child span').toggleClass("d-none");
        
                var category = $('#child-form [name="category_id"] option:selected').text();
                if( parseInt(id) == 0 || id == '')
                {
                    createRoom(response.data.room.id, category, response.data.room.bed_numbers);
                }
                else
                {
                    updateRoom(response.data.room.id, category, response.data.room.bed_numbers);
                }

                $('#childDetailsModal').modal('hide');

            },
            cache: false,
            contentType: false,
            processData: false
        });
    })

    // ************************** //
    // script pour l'hébergement  //
    // ************************** //
    
        var createRoom = function (room_id, category, bed_numbers)
        {
            var model = $('#rooms .model').clone();

            $(model).children('.btn-child').attr('data', room_id);
            $(model).children('.btn-child').text(category + ' (' + bed_numbers + ')');
            $(model).removeClass('d-none');
            $(model).removeClass('model');

            $('#rooms').append( $(model) );
        }

        var updateRoom = function (room_id, category, bed_numbers)
        {
            var model = $('#rooms [data="'+ room_id +'"]');

            $(model).attr('data', room_id);
            $(model).text(category + ' (' + bed_numbers + ')');
        }

        $(document).on('click', '.btn-room-delete', function () 
        {
            var id     = $(this).prev().attr('data');
            var route  = $('#child-url').val() + '/' + id;
            var that   = $(this);

            that.children('span').toggleClass('d-none');
            
            $.ajax({
                url: route,
                type: 'DELETE',
                success: function (response)
                {
                    if( response.status == 'done' )
                    {
                        that.parent().fadeOut(500, function () {
                            that.parent().remove();
                        });
                    }
                },
                error: function (response) {
                    console.log(response);
                }
            })
        })
    // ************************** //
});