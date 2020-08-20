

    <!-- Modal -- pictures -->
    <div class="modal fade" id="picModal" tabindex="-1" role="dialog" aria-labelledby="picModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title" id="picModalLabel">Types de l'hébergement</h5>
                </div>
                <div class="modal-body bg-pink">
                    <div class="form-group">
                        <div class="row justify-content-center" id="picModalContent"></div>
                    </div>
                </div>
                
                {{-- Template image upload | hidden --}}
                <div class="col-lg-3 col-6 text-center pic-up picture-uploads d-none">
                    <div class="border border-grey mb-2 pic-upload">
                        <img src="" alt="" class="img-fluid">
                        <label class="btn bg-blue btn-block mb-0">
                            Choisir une image
                        </label>
                        <textarea class="form-control" row="2" placeholder="Dites quelque chose"></textarea>
                        <input type="hidden" value="" name="" >
                    </div>
                </div>

                <div class="modal-footer bg-blue">
                    <div class="row" style="width:100%">
                        <div class="col-8 pl-0">
                            <i class="fa fa-exclamation-triangle text-warning"></i><small class="text-white"> Les fichiers ne doivent pas dépasser 500Kb</small>
                        </div>
                        <div class="col-4 text-right">
                            <button type="button" class="btn bg-pink btn-pic-end" data-dismiss="modal">Terminer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
