@extends('tamotech.layout.index')
@section('title')
   Env
@endsection
@section('content')
    {!! createBtn($createRoute,__("buttons.key")) !!}
    <div class="card p-4">
        <form id="form" method="post"
              action="{{ route('env.update',1) }}">
            @csrf
            @method('PUT')
            <div class="row">
                @foreach($envs as $key => $env)
                    <div class="col-6  mb-3">
                        <div class="row">
                            <div class="col-10">
                                <label for="TextInput" class="form-label"> {{ $key }}</label>
                                <input type="text" name="{{$key}}" class="form-control"
                                       value="{{ $env }}">
                            </div>
                            <div class="col-2 mt-4">
                                <button type="button" class="btn btn-danger deleteButton" delete-route="{{route('env.destroy',[1,'key'=>$key])}}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-12 modal-footer">
                <button class="btn btn-primary" type="submit">{{__("buttons.save")}}</button>
            </div>
        </form>
    </div>

@endsection
@section('js')
<script>
    $(document).on('click', '.deleteButton', function (e) {
        e.preventDefault()
        {{--if(!checkInternetConnection()){--}}
        {{--    validToster("{{ __('auth.no_internet') }}")--}}
        {{--    return;--}}
        {{--}--}}
        let buttonObj = $(this);
        let deleteRoute = buttonObj.attr("delete-route");
        swal.fire({
            title: "{{__('buttons.Are You Sure')}}",
            text: "{{__('buttons.You Can not to rollback')}}",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "{{__('buttons.accept')}}",
            cancelButtonText: "{{__('buttons.cancel')}}",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: deleteRoute,
                    type: 'DELETE',
                    beforeSend: function () {
                    },
                    complete: function () {
                    },
                    success: function (data) {
                        // handleSuccessResponce(data);
                        Swal.fire({
                            icon: 'success',
                            title: "{{__('buttons.Deleted successfully')}}",
                            confirmButtonText: "{{__('buttons.close')}}",
                        });
                        // reloadDataTable();
                    },
                    error: function (errorObj, errorText, errorThrown) {
                        // handleErrorResponce(errorObj);
                    }
                });
            }
        });
    });
</script>
@endsection
