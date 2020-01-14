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
        <form method="post" action="{{ route('contacts.update', $contact->id) }}" name="contact">
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
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadioMale" value="male"  >
                    <label class="form-check-label" for="inlineRadio1">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadioFemale" value="female" >
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

@section('scripts')
    <script type="text/javascript">
        function initInput()
        {
            IMask(
                document.getElementById('dob'),
                {
                    mask: Date,
                    /*pattern: 'd{-}`m{-}`Y',*/
                    min: new Date(1930, 0, 1),
                    max: new Date(2020, 0, 1),
                    lazy: false
                });
            document.querySelectorAll('.phone-number').forEach(function(input) {
                IMask(
                    input, {
                        mask: '00000000'
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
        function fillInformation(data)
        {
            console.log(data.contact);
            $("input[name=first_name]").val(data.contact.first_name);
            $("input[name=last_name]").val(data.contact.last_name);
            $("input[name=nick_name]").val(data.contact.nick_name);
            $("input[name=dob]").val(data.contact.dob);
            ( data.contact.gender === 1)? $('#inlineRadioMale').prop('checked',true) : $('#inlineRadioFemale').prop('checked',true);
            for (let telephone = 1; telephone < data.contact.telephones.length;telephone++)
            {
                $('#button-addon-phone-number').click();
            }
            $('.phone-number').each(function(index){
                $( this ).val(data.contact.telephones[index].phone_number);
            });
            $('.phone-number-type').each(function(index){
                $( this ).val(data.contact.telephones[index].category);
            });

            for (let email = 1; email < data.contact.emails.length;email++)
            {
                $('#button-addon-email').click();
            }
            $('.email').each(function(index){
                $( this ).val(data.contact.emails[index].email);
            });
            $('.email-type').each(function(index){
                $( this ).val(data.contact.emails[index].category);
            });

        }
        function loadData()
        {
            console.info('Ajax Call: Load contact information');
            console.info('Ajax Call- Resource: ' +  "{{ route('contacts.show',$contact->id) }}");
            $.ajax({
                type:'GET',
                url:"{{ route('contacts.show',$contact->id) }}",
                success:function(data){
                    console.log('Ajax Call: Load contact information - success');
                    console.log('Ajax Call: Data ' + JSON.stringify(data) );
                    fillInformation(data);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.error('Ajax Call: Load contact information - Error '+errorThrown);
                }
            });
        }
        function submitForm(form)
        {
            let first_name = $("input[name=first_name]").val();
            let last_name = $("input[name=last_name]").val();
            let nick_name = $("input[name=nick_name]").val();
            let dob = $("input[name=dob]").val();
            let gender = $("input[name=gender]").val();
            let phone_numbers = [];
            let phone_numbers_type = [];
            let emails = [];
            let emails_type = [];
            $('.phone-number').each(function(){
                    phone_numbers.push($(this).val());
                }
            );
            $('.phone-number-type').each(function(){
                    phone_numbers_type.push($(this).val());
                }
            );
            $('.email').each(function(){
                    emails.push($(this).val());
                }
            );
            $('.email-type').each(function(){
                    emails_type.push($(this).val());
                }
            );
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            console.info('Ajax Call: Update contact');
            console.info('Ajax Call: Update contact - data');
            let dataToUpdate = {first_name:first_name, last_name:last_name, nick_name:nick_name,dob:dob,gender:gender,phone_numbers:phone_numbers,phone_numbers_type:phone_numbers_type,emails:emails,emails_type:emails_type};
            console.log(dataToUpdate);
            $.ajax({
                type:'PUT',
                url:"{{ route('contacts.update',$contact->id) }}",
                data:dataToUpdate,
                success:function(data){
                    console.log('Ajax Call: Update contact - success');
                    window.location.replace("{{ route('contacts.index') }}")
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.error('Ajax Call: Update contact - Error '+errorThrown);
                }
            });
        }
        $(document).ready(function () {
            initInput();
            /*Code that handles the multiple phone numbers*/
            let phoneNumberCount = 0;
            let phoneNumberInputs = 1;
            $('#button-addon-phone-number').click(function()
            {
                phoneNumberCount++;
                if (phoneNumberInputs<=4)
                {
                    phoneNumberInputs++;
                    let newPhoneDivClass = 'phone-number-'+phoneNumberCount;
                    let newPhoneButtonClass = 'button-remove-phone-'+phoneNumberCount;
                    $('.phone-number-0').after('<div class="form-group input-group '+newPhoneDivClass+'">\n' +
                        '   <input type="text" class="form-control phone-number" name="phone_'+phoneNumberCount+'" placeholder="" aria-label="Recipient\'s username" aria-describedby="button-addon2">\n' +
                        '       <select class="form-control phone-number-type" name="phone_type_'+phoneNumberCount+'">\n' +
                        '           <option>Mobile</option>\n' +
                        '           <option>Home</option>\n' +
                        '           <option>Office</option>\n' +
                        '           <option>Fax</option>\n' +
                        '           <option>Other</option>\n' +
                        '       </select>\n' +
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
            /*Code that handle multiple email*/
            let emailNumberCount = 0;
            let emailNumberInputs = 1;
            $('#button-addon-email').click(function()
            {
                emailNumberCount++;
                if (emailNumberInputs<=4)
                {
                    emailNumberInputs++;
                    let newEmailDivClass = 'email-'+emailNumberCount;
                    let newEmailButtonClass = 'button-remove-email-'+emailNumberCount;
                    $('.email-0').after('<div class="form-group input-group '+newEmailDivClass+'">\n' +
                        '              <input type="text" class="form-control email" name="email_'+emailNumberCount+'" placeholder="" aria-label="Recipient\'s username" aria-describedby="button-addon2">\n' +
                        '    <select class="form-control email-type" name="email_type_'+emailNumberCount+'">\n' +
                        '       <option>Personal</option>\n' +
                        '       <option>Office</option>\n' +
                        '       <option>Other</option>\n' +
                        '    </select>\n' +
                        '              <div class="input-group-append">\n' +
                        '                  <button class="btn btn-outline-secondary '+newEmailButtonClass+'" number="'+emailNumberCount+'" type="button" id="remove-email-'+emailNumberCount+'" >- (Remove Email)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>\n' +
                        '              </div>\n' +
                        '          </div>');
                    $('.'+newEmailButtonClass).click(function()
                    {
                        emailNumberInputs--;
                        $('.'+newEmailDivClass).remove();
                    });
                    initInput();
                }
                else
                {
                    alert('You only can add up to 5 emails.')
                }
            });
            $("form[name='contact']").validate({
                rules: {
                    first_name: "required",
                    last_name: "required",
                    nick_name: "required",
                    dob:"required",
                    gender:"required",
                    phone:{
                        required:true,
                        minlength:8,
                        maxlength:8,
                    },
                    phone_1:{
                        required:true,
                        minlength:8,
                        maxlength:8,
                    },
                    phone_2:{
                        required:true,
                        minlength:8,
                        maxlength:8,
                    },
                    phone_3:{
                        required:true,
                        minlength:8,
                        maxlength:8,
                    },
                    phone_4:{
                        required:true,
                        minlength:8,
                        maxlength:8,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    email_1: {
                        required: true,
                        email: true
                    },
                    email_2: {
                        required: true,
                        email: true
                    },
                    email_3: {
                        required: true,
                        email: true
                    },
                    email_4: {
                        required: true,
                        email: true
                    },
                },
                // Specify validation error messages
                messages: {
                    first_name: "Please enter your first name",
                    last_name: "Please enter your last name",
                    nick_name: "Please enter your nickname",
                    dob: "Please enter your date of birth",
                    gender: "Please enter your gender",
                    phone: {
                        required:"Please enter your phone number",
                        minlength: "Your phone number must have 8 digits",
                        maxlength: "Your phone number must have 8 digits",
                    },
                    phone_1: {
                        required:"Please enter your phone number",
                        minlength: "Your phone number must have 8 digits",
                        maxlength: "Your phone number must have 8 digits",
                    },
                    phone_2: {
                        required:"Please enter your phone number",
                        minlength: "Your phone number must have 8 digits",
                        maxlength: "Your phone number must have 8 digits",
                    },
                    phone_3: {
                        required:"Please enter your phone number",
                        minlength: "Your phone number must have 8 digits",
                        maxlength: "Your phone number must have 8 digits",
                    },
                    phone_4: {
                        required:"Please enter your phone number",
                        minlength: "Your phone number must have 8 digits",
                        maxlength: "Your phone number must have 8 digits",
                    },
                    email: "Please enter a valid email address",
                    email_1: "Please enter a valid email address",
                    email_2: "Please enter a valid email address",
                    email_3: "Please enter a valid email address",
                    email_4: "Please enter a valid email address"
                },
                submitHandler: function(form) {
                    //form.submit();
                    submitForm(form);
                }
            });
            loadData();
        });
    </script>
@stop
