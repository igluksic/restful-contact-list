@extends('layout')

@section('content')
    @include('contacts._js_add_phone_box')
    <h1>Edit contact</h1>
    <form class="needs-validation" method="post" action="{{route('contact.edit.post', $contact['id'])}}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-6 mb-3">
                @if($contact['profile_photo'] != '') <img heigth="100%" src="data:image/png;base64,{{$contact['profile_photo']}}"> @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="first_name">First name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="" value="{{$contact['first_name']}}" required="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                <div class="invalid-feedback">
                    Valid first name is required.
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="last_name">Last name</label>
                <input type="text" class="form-control" id="last_name" placeholder="" value="{{$contact['last_name']}}" required="" name="last_name">
                <div class="invalid-feedback">
                    Valid last name is required.
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="you@example.com" required="" name="email" value="{{$contact['email']}}">
                <div class="invalid-feedback">
                    Please enter a valid email address.
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <input value="1" type="checkbox" id="favourite" name="favourite" @if ($contact['favourite']) checked @endif>
                <label for="favourite">Favourite</label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 mb-3">
                <label for="profile_photo">Profile photo, load only if you want to change</label>
                <input type="file" name="profile_photo" id="profile_photo">
            </div>
        </div>
        <hr class="mb-4">
        <div class="row" id="add_more">
            @foreach ($contact['phones'] as $phone)
                @include('contacts._phone_entry', $phone)
            @endforeach
            @include('contacts._phone_entry_blank')
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary" id="add_form_field">+</button>
        <hr class="mb-4">
        <a href="{{route('contact.delete', $contact['id'])}}"><button type="button" class="btn btn-sm btn-outline-secondary" onclick="return confirm('The contact will be deleted! Are you sure?')">Delete contact</button></a>
        <hr class="mb-4">
        <button class="btn btn-primary btn-lg btn-block" type="submit">Save changes</button>
        <hr class="mb-4">
        <a href="{{route('homepage')}}"><button class="btn btn-primary btn-lg btn-block" type="submit">Cancel</button></a>
    </form>
@endsection