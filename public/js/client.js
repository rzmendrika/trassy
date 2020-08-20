$(document).ready(function ()
{
    var picturePlaceholder = '/pictures/placeholder-image.png';

    // child script
    $('.btn-child').click( function ()
    {
        $('#submit-child').attr("disabled", false);
        
        $('#submit-child span').removeClass("d-none");
        $('#submit-child .spinner').addClass("d-none");

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