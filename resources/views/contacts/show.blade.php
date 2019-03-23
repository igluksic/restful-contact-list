@extends('layout')

@section('content')
    <h1>Contact overwiev</h1>
        <div class="row">
            <div class="col-md-6 mb-3">
                @if($contact['profile_photo'] != '') <img heigth="100%" src="data:image/png;base64,{{$contact['profile_photo']}}"> @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="first_name">First name</label>
                {{$contact['first_name']}}
            </div>
            <div class="col-md-6 mb-3">
                <label for="last_name">Last name</label>
                {{$contact['last_name']}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="email">Email</label>
                {{$contact['email']}}

            </div>

            <div class="col-md-6 mb-3">
                <label for="favourite">Favourite</label>
                @if ($contact['favourite'])
                    <i class="fa fa-check fa-2" aria-hidden="true"></i>
                @else
                    <i class="fa fa-times fa-2" aria-hidden="true"></i>
                @endif
            </div>
        </div>
        <hr class="mb-4">
        <div class="row" id="add_more">
            <div class="col-md-12 mb-3">
                Phone numbers
            </div>
            @foreach ($contact['phones'] as $phone)
                <div class="col-md-6 mb-3">
                    {{$phone['phone_number']}}
                </div>
                <div class="col-md-6 mb-3">
                    {{$phone['label']}}
                </div>
            @endforeach
        </div>

        <hr class="mb-4">
        <a href="{{route('homepage')}}"><button class="btn btn-primary btn-lg btn-block">Back to homepage</button></a>
@endsection