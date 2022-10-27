@if (session('success'))
    <div class="row">
    <div class="col-sm-12">
        <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="text-black si si-close"></i>
        </button>
        <span>{{ session('success') }}</span>
        </div>
    </div>
    </div>
@endif

@if (session('warning'))
    <div class="row">
    <div class="col-sm-12">
        <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="text-black fa fa-close"></i>
        </button>
        <span>{{ session('warning') }}</span>
        </div>
    </div>
    </div>
@endif


@if (session('error'))
    <div class="row">
    <div class="col-sm-12">
        <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="text-black fa fa-close"></i>
        </button>
        <span>{{ session('error') }}</span>
        </div>
    </div>
    </div>
@endif


@if ($errors->any())
    <div class="row">
    <div class="col-sm-12">
        <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="text-black fa fa-close"></i>
        </button>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
        
        </div>
    </div>
    </div>
@endif



@if (session('account_login_error_reason'))
    <div class="row">
    <div class="col-sm-12">
        <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="text-black fa fa-close"></i>
        </button>
        <span>Error Received : {{ session('account_login_error_reason') }}</span>
        </div>
    </div>
    </div>
@endif