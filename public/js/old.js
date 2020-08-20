
    $('#roomForm input[type="file"]').val(null);
    $('#submitRoom').click(function ()
    {
        var form     = new FormData( $('#roomForm')[0] );
        var pictures = $('#roomForm input[type="file"]')
        var id       =  $('#roomId').val();

        $('#submitRoom .spinner, #submitRoom  span').toggleClass("d-none");

        pictures.each( function (i, file)
        {
            if(file.files[0] !== undefined)
                form.append( $(file).attr('name'), file.files[0] );
        })

        if( parseInt(id) == 0 || id == '')
        {
            var url  = "/client/hebergements/chambres/store";
        }
        else
        {
            var url  = "/client/hebergements/chambres/" + id;
            form.append('_method', 'PUT');
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: form,
            success: function (data)
            {
                $('#submitRoom .spinner, #submitRoom  span').toggleClass("d-none");
            },
            cache: false,
            contentType: false,
            processData: false
        });
    })

    $('.roomDetailButton').click( function ()
    {
        var details = $(this).parent().attr('data'); 
        var room    = $.parseJSON( details );

        $('#roomForm [name]').each( function (i, element)
        {
            var name = $(element).attr('name')
            if( $(element).attr('type') == 'checkbox' )
            {
                $(element).attr('checked', !!parseInt(room[name]) );
                $(element).attr('value'  , parseInt(room[name]) );
            }
            else if( $(element).attr('type') !== 'hidden' || $(element).attr('name') == 'id' )
            {
                $(element).val( room[name] );
            }
        })

        room.pictures.forEach( function (element, i)
        {
            $($('#roomForm img')[i]).attr('src', '/'+ element.path)    
            $($('#roomForm textarea')[i]).val(element.comment)
            $($('#roomForm .picId')[i]).val(element.id)
        
            console.log(i, element.id)
        })
    })