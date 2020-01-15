@extends('base')
@section('header')
    @parent
@endsection
@section('main')
<div class="row">
<div class="col-sm-12">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div>
  @endif
</div>
<div class="col-sm-12">
    <h1 class="display-3">Contacts</h1>
    <div>
        <a style="margin: 19px;" href="{{ route('contacts.create')}}" class="btn btn-primary">New contact</a>
    </div>
  <table id="selectedColumn" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
    <thead>
        <tr>
          <th class="th-sm">ID</th>
          <th class="th-sm">Name</th>
          <th class="th-sm">Nickname</th>
          <th class="th-sm">Date of Birth</th>
          <th class="th-sm">Gender</th>
          <th class="th-sm" colspan = 3>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contacts as $contact)
        <tr class="row-{{$contact->id}}">
            <td>{{$contact->id}}</td>
            <td>{{$contact->first_name}} {{$contact->last_name}}</td>
            <td>{{$contact->nick_name}}</td>
            <td>{{$contact->dob}}</td>
            <td>{{$contact->gender}}</td>
            <td>
                <a class="btn btn-primary view" data-contact="{{$contact->id}}">View</a>
            </td>
            <td>
                <a href="{{ route('contacts.edit',$contact->id)}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
                <form action="{{ route('contacts.destroy', $contact->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <a class="btn btn-danger delete" data-contact="{{$contact->id}}" >Delete</a>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
</div>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete this item?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" data-contact="">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Contact Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
    @section('scripts')
        <script type="text/javascript">
            function deleteContact(id)
            {
                console.log('delete ' + id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
                console.info('Ajax Call: Delete contact');
                let urlToDelete = '{{ route("contacts.destroy", ":id") }}';
                urlToDelete = urlToDelete.replace(':id', id);
                $.ajax({
                    type:'DELETE',
                    url:urlToDelete,
                    success:function(data){
                        console.log('Ajax Call: Delete contact - success');
                        $(".row-"+id).remove();

                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.error('Ajax Call: Delete contact - Error '+errorThrown);
                    }
                });
            }
            $(document).ready(function () {
                $('.delete').each(function()
                {
                    $(this).click(function(event){
                        event.preventDefault();
                        $('#deleteModal').modal('show');
                        $('#deleteModal .btn-danger').data('contact',$(this).data("contact"));
                        $('#deleteModal .btn-danger').click(function(){
                            deleteContact($(this).data("contact"));
                            $('#deleteModal').modal('hide');
                        });
                    });
                });
                $('.view').each(function()
                {
                    $(this).click(function(event){
                        event.preventDefault();
                        $('#showModal').modal('show');
                    });
                });
            });
        </script>
    @stop
