<div class="col-md-4 mb-3">
    <label for="phone_number">Phone number</label>
    <input type="hidden" value="{{$phone['id']}}" name="phone_id[]">
    <input class="form-control" id="phone_number" name="phone_number[]" @if (isset($phone['phone_number'])) value="{{$phone['phone_number']}}" @endif>
    <div class="invalid-feedback">
        Please enter a valid phone number
    </div>
</div>

<div class="col-md-4 mb-3">
    <label for="label">Label</label>
    <input type="label" class="form-control" id="label" name="label[]" @if (isset($phone['label'])) value="{{$phone['label']}}" @endif>
</div>

<div class="col-md-4 mb-3">
    <br>
    <a href="{{route('delete.phone', ['contactId' => $contact['id'], 'phoneId' => $phone['id']])}}"><button type="button" class="btn btn-sm btn-outline-secondary">Delete</button></a>
</div>