@extends('layout')

@section('content')
    @if (isset($message['result']))
        <div class="alert alert-{{$message['result']}}" id="messageBox">
            <p class="msg"> {{ $message['message'] }}</p>
        </div>
    @endif
    <h1 class="mt-5">Welcome {{$user->name}} <a href="{{route('logout')}}" class="btn btn-primary my-2">Logout</a></h1>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
            <h2 class="jumbotron-heading">Contact list</h2>
            <p class="lead text-muted">Rest contact list API DEMO!</p>
            <p>
                <a href="{{route('contact.new')}}" class="btn btn-primary my-2">Add new contact</a>
            </p>
            </div>
            <div class="col-md-6">
                @include('contacts._js_search')
            </div>
        </div>
    </div>
    <main role="main">
        <div class="album py-5 bg-light">
            <div class="container">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="allContacts-tab" data-toggle="tab" href="#allContacts" role="tab" aria-controls="allContacts" aria-selected="true">All contacts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="favourites-tab" data-toggle="tab" href="#favourites" role="tab" aria-controls="favourites" aria-selected="false">Favourites</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="allContacts" role="tabpanel" aria-labelledby="allContacts-tab">
                        @include('contacts._all_contacts')
                    </div>
                    <div class="tab-pane fade" id="favourites" role="tabpanel" aria-labelledby="favourites-tab">
                        @include('contacts._favourites')
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection