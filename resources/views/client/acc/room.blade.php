<div class="row">
    <!-- col properties -->
    <div class="form-group col-6">
        <label for="types">Type :</label>
        <select class="form-control form-control-sm" name="category_id" value="{{ isset($room) ? $room->category_id : 1 }}">
            @foreach( $roomCategories as $category )
                <option value="{{ $category->id }}" {{ isset($room) && $room->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-6">
        <label for="stars">Nb de lits :</label>
        <input type="number" class="form-control form-control-sm" name="bed_numbers" min="0" value="{{ isset($room) ? $room->bed_numbers : 1 }}">
    </div>

    <div class="form-group col-12">
        <label for="price">Loyer :</label>
        <div class="input-group input-group-sm border border-grey">
            <input type="number" min="0" class="form-control form-control-sm" name="price" min="0" value="{{ isset($room) ? $room->price : 0 }}">
            <div class="input-group-append">
                <span class="input-group-text bg-blue">Ariary</span>
            </div>
        </div>
    </div>

    <div class="form-group col-6">
        <label>Toilette :</label>
        <select class="form-control form-control-sm" name="wc">
            <option value="0" {{ isset($room) && $room->wc == 0 ? 'selected' : '' }} >Non</option>
            <option value="1" {{ isset($room) && $room->wc == 1 ? 'selected' : '' }} >oui</option>
            <option value="2" {{ isset($room) && $room->wc == 2 ? 'selected' : '' }} >séparée</option>
        </select>
    </div>

    <div class="form-group col-6">
        <label>Douche :</label>
        <select class="form-control form-control-sm" name="shower"  >
            <option value="0" {{ isset($room) && $room->shower == 0 ? 'selected' : '' }} >Non</option>
            <option value="1" {{ isset($room) && $room->shower == 1 ? 'selected' : '' }} >oui</option>
            <option value="2" {{ isset($room) && $room->shower == 2 ? 'selected' : '' }} >séparée</option>
        </select>
    </div>

    <div class="col-6 mb-2">
        <div class="custom-control custom-checkbox mr-sm-2">
            <input type="checkbox" class="custom-control-input" id="tv" name="tv" {{ isset($room) && $room->tv ? 'checked' : '' }}>
            <label class="custom-control-label" for="tv">TV</label>
        </div>
    </div>

    <div class="col-6 mb-2">
        <div class="custom-control custom-checkbox mr-sm-2">
            <input type="checkbox" class="custom-control-input" id="safe" name="safe" {{ isset($room) && $room->safe ? 'checked' : '' }}>
            <label class="custom-control-label" for="safe">Coffre fort</label>
        </div>
    </div>

    <div class="col-6 mb-2">
        <div class="custom-control custom-checkbox mr-sm-2">
            <input type="checkbox" class="custom-control-input" id="kitchen" name="kitchen" {{ isset($room) && $room->kitchen ? 'checked' : '' }}>
            <label class="custom-control-label" for="kitchen">Cuisine</label>
        </div>
    </div>
    <input type="hidden" id="child-id" name="id"  value="{{ isset($room) ? $room->id : '' }}">
    <!-- col properties end -->
</div>
