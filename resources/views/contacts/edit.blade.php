@extends('base')
@section('header')
    @parent
@endsection

@section('main')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <h1 class="display-3">Update a contact</h1>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br />
        @endif
        <form method="post" action="{{ route('contacts.update', $contact->id) }}">
            @method('PATCH')
            @csrf
            <div class="form-group">

                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" name="first_name" value={{ $contact->first_name }} />
            </div>

            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" name="last_name" value={{ $contact->last_name }} />
            </div>

            <div class="form-group">
                <label for="nick_name">NickName:</label>
                <input type="text" class="form-control" name="nick_name" value={{ $contact->nick_name }} />
            </div>
            <div class="form-group">
                <label for="dob">DOB:</label>
                <input type="text" class="form-control" name="dob" value={{ $contact->dob }} id="dob" />
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="male" {{ ($contact->gender == 1)? 'checked' : '' }} >
                    <label class="form-check-label" for="inlineRadio1">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="female"{{ ($contact->gender == 0)? 'checked' : ''}} >
                    <label class="form-check-label" for="inlineRadio2">Female</label>
                 </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
