<h3> </h3>

@foreach($favourites as $contactRow)
    <div class="row">
        @foreach($contactRow as $contact)
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <div class="text-center">
                        @if ($contact['profile_photo'] != '')
                            <img heigth="100%" src="data:image/png;base64,{{$contact['profile_photo']}}">
                        @endif
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            First name: {{$contact['first_name']}}
                        </p>
                        <p class="card-text">
                            Last name: {{$contact['last_name']}}
                        </p>
                        <p class="card-text">
                            Email: {{$contact['email']}}
                        </p>
                        @if (isset($contact['phones']))
                            <table>
                                @foreach($contact['phones'] as $phone)
                                    <tr>
                                        <td width="150"><i class="fa fa-phone"></i> {{$phone['phone_number']}}</td>
                                        <td>
                                            @if ($phone['label'] != '')
                                                <a href="#" data-toggle="tooltip" data-placement="top" title="Label: {{$phone['label']}}">Info</a>
                                            @else
                                                <a href="#" data-toggle="tooltip" data-placement="top" title="No label">Info</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="{{route('contact.edit', $contact['id'])}}"><button type="button" class="btn btn-sm btn-outline-secondary">Edit</button></a>
                                <a href="{{route('contact.view', $contact['id'])}}"><button type="button" class="btn btn-sm btn-outline-secondary">Show details</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endforeach