<div id="contact">
    <div class="form-group">
        <label for="email">Email :</label>
        <input type="email" class="form-control form-control-sm" id="email" name="email" value="{{ isset($contact) ? $contact->email : "" }}" required>
    </div>

    <div class="row">
        <div class="form-group col-sm-6">
            <label for="tel1">Numéro de téléphone 1 :</label>
            <input type="tel" class="form-control form-control-sm" id="tel1" name="tel1" value="{{ isset($contact) ? $contact->tel1 : "" }}" required>
        </div>
        <div class="form-group col-sm-6">
            <label for="tel2">Numéro de téléphone 2 :</label>
            <input type="tel" class="form-control form-control-sm" id="tel2" name="tel2" value="{{ isset($contact) ? $contact->tel2 : "" }}">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-sm-6">
            <label for="facebook">Nom sur facebook :</label>
            <input type="text" class="form-control form-control-sm" id="facebook" name="facebook" value="{{ isset($contact) ? $contact->facebook : "" }}">
        </div>
        <div class="form-group col-sm-6">
            <label for="instagram">Nom sur Instagram :</label>
            <input type="text" class="form-control form-control-sm" id="instagram" name="instagram" value="{{ isset($contact) ? $contact->instagram : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label for="address">Adresse :</label>
        <input type="text" class="form-control form-control-sm" id="address" name="address" value="{{ isset($contact) ? $contact->address : "" }}" required>
    </div>

    <div class="row">
        <div class="form-group col-sm-4">
            <label for="city">Ville :</label>
            <input type="text" class="form-control form-control-sm" id="city" name="city" value="{{ isset($contact) ? $contact->city : "" }}" required>
        </div>
        <div class="form-group col-sm-4">
            <label for="region">Région :</label>
            <input type="text" class="form-control form-control-sm" id="region" name="region" value="{{ isset($contact) ? $contact->region : "" }}" required>
        </div>
        <div class="form-group col-sm-4">
            <label for="country">Pays :</label>
            <input type="text" class="form-control form-control-sm" id="country" name="country" value="{{ isset($contact) ? $contact->country : "Madagascar" }}" disabled>
        </div>
    </div>
</div>