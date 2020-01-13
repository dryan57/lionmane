@extends('base')
@section('header')
    @parent
@endsection

@section('main')
<div class="row">
 <div class="col-sm-8 offset-sm-2">
    <h1 class="display-3">Add a contact</h1>
  <div>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('contacts.store') }}">
          @csrf
          <div class="form-group">
              <label for="first_name">What’s your first name?:</label>
              <input type="text" class="form-control" name="first_name"/>
          </div>

          <div class="form-group">
              <label for="last_name">What’s your last name?:</label>
              <input type="text" class="form-control" name="last_name"/>
          </div>
          <div class="form-group">
             <label for="nick_name">What’s your nickname?:</label>
             <input type="text" class="form-control" name="nick_name"/>
          </div>

          <div class="form-group">
              <label for="dob">When were you born?:</label>
              <input type="text" class="form-control" name="dob" id="dob"/>
          </div>
          <label for="gender">What’s your gender?:</label>
          <div class="form-group">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="male">
                <label class="form-check-label" for="inlineRadio1">Male</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="female">
                <label class="form-check-label" for="inlineRadio2">Female</label>
              </div>
          </div>
          <label for="phone">What's your phone number?:</label>
          <div class="form-group input-group phone-number-0">
              <input type="text" class="form-control phone-number" name="phone" placeholder="" aria-label="Recipient's username" aria-describedby="button-addon2">
              <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" id="button-addon-phone-number">+ (Add a another Phone Number)</button>
              </div>
          </div>
          <label for="phone">What's your e-mail?:</label>
          <div class="form-group input-group mb-0">
              <input type="text" class="form-control email" name="email" placeholder="" aria-label="Recipient's email" aria-describedby="button-addon2">
              <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" id="button-addon-email">+ (Add a another E-mail)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
              </div>
          </div>
          <button type="submit" class="btn btn-primary-outline" id="btn-submit">Add contact</button>
      </form>
  </div>
</div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function initInput()
        {
            IMask(
                document.getElementById('dob'),
                {
                    mask: Date,
                    min: new Date(1990, 0, 1),
                    max: new Date(2020, 0, 1),
                    lazy: false
                });
            document.querySelectorAll('.phone-number').forEach(function(input) {
                IMask(
                    input, {
                        mask: '0000-0000'
                    })
            });
            document.querySelectorAll('.email').forEach(function(input){
                IMask(
                    input,
                    {
                        mask: /^\S*@?\S*$/
                    });
            });


        }
        $(document).ready(function () {
            initInput();
            let phoneNumberCount = 0;
            let phoneNumberInputs = 0;
            $('#button-addon-phone-number').click(function()
            {
                phoneNumberCount++;
                if (phoneNumberInputs<=4)
                {
                    phoneNumberInputs++;
                    let newPhoneDivClass = 'phone-number-'+phoneNumberCount;
                    let newPhoneButtonClass = 'button-remove-phone-'+phoneNumberCount;
                    $('.phone-number-0').prepend('<div class="form-group input-group '+newPhoneDivClass+'">\n' +
                        '              <input type="text" class="form-control phone-number" name="phone" placeholder="" aria-label="Recipient\'s username" aria-describedby="button-addon2">\n' +
                        '              <div class="input-group-append">\n' +
                        '                  <button class="btn btn-outline-secondary '+newPhoneButtonClass+'" number="'+phoneNumberCount+'" type="button" id="remove-phone-'+phoneNumberCount+'" >- (Remove Phone Number)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>\n' +
                        '              </div>\n' +
                        '          </div>');
                    $('.'+newPhoneButtonClass).click(function()
                    {
                        phoneNumberInputs--;
                        $('.'+newPhoneDivClass).remove();
                    });
                    initInput();
                }
                else
                {
                    alert('You only can add up to 5 phone numbers.')
                }
            });
        });
    </script>
@stop
