<?php $i = $start ?>
@if( isset($pictures) )

    @foreach( $pictures as $picture )
        <div class="col-lg-3 col-6 text-center picture-uploads">
            <div class="border border-white mb-2 pic-upload">
                <img src="{{ url($picture->path) }}" alt="" class="img-fluid">
                <label class="btn bg-blue btn-block mb-0">
                    Choisir une image<input type="file" accept="image/*" class="d-none pic-file" name="{{ 'pic_'. $i }}">
                </label>
                <textarea class="form-control" row="2" placeholder="Dites quelque chose"></textarea>
                <input type="hidden" value="{{ json_encode($picture) }}" name="" >
            </div>
        </div>

        <?php $i++ ?>
    @endforeach

@endif

@for( $j= $i; $j < $number + $start; $j++ )

    <div class="col-lg-3 col-6 text-center picture-uploads">
        <div class="border border-white mb-2 pic-upload" >
            <img src="{{ url('pictures/placeholder-image.png') }}" alt="" class="img-fluid">
            <label class="btn bg-blue btn-block mb-0">
                Choisir une image<input type="file" accept="image/*" class="d-none pic-file" name="{{ 'pic_'. $j }}">
            </label>
            <textarea class="form-control" row="2" placeholder="Dites quelque chose" name="{{ 'comment_'. $j }}"></textarea>
            <input type="hidden" value="{{ $type }}" name="{{ 'type_'. $j }}">
            <input type="hidden" value="0" name="{{ 'id_'  . $j }}" class="picId">
        </div>
    </div>

@endfor
<div class="col-12">
    <div class="alert alert-warning mb-0">
        <i class="fa fa-exclamation-triangle text-warning"></i><span class=""> Les fichiers ne doivent pas dépasser 500Kb</span>
    </div>
</div>
