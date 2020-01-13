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

                <label for="first_name">What’s your first name?:</label>
                <input type="text" class="form-control" name="first_name" value="" />
            </div>

            <div class="form-group">
                <label for="last_name">What’s your last name?:</label>
                <input type="text" class="form-control" name="last_name" value="" />
            </div>

            <div class="form-group">
                <label for="nick_name">What’s your nickname?:</label>
                <input type="text" class="form-control" name="nick_name" value="" />
            </div>
            <div class="form-group">
                <label for="dob">hen were you born?:</label>
                <input type="text" class="form-control" name="dob" value="" id="dob" />
            </div>
            <label for="gender">What’s your gender?:</label>
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="male"  >
                    <label class="form-check-label" for="inlineRadio1">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="female" >
                    <label class="form-check-label" for="inlineRadio2">Female</label>
                 </div>
            </div>
            <label for="phone">What's your phone number?:</label>
            <div class="form-group input-group phone-number-0">
                <input type="text" class="form-control phone-number" name="phone" placeholder="" aria-label="Recipient's username" aria-describedby="button-addon2">
                <select class="form-control phone-number-type" name="phone_type">
                    <option>Mobile</option>
                    <option>Home</option>
                    <option>Office</option>
                    <option>Fax</option>
                    <option>Other</option>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon-phone-number">+ (Add a another Phone Number)</button>
                </div>
            </div>
            <div><label for="phone">What's your e-mail?:</label></div>
            <div class="form-group input-group email-0">
                <input type="text" class="form-control email" name="email" placeholder="" aria-label="Recipient's email" aria-describedby="button-addon2">
                <select class="form-control email-type" name="email_type">
                    <option>Personal</option>
                    <option>Office</option>
                    <option>Other</option>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon-email">+ (Add a another E-mail)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Contact</button>
        </form>
    </div>
</div>
@endsection
