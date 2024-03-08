@if ($errors->any())
    <div class="alert alert-danger d-flex justify-content-between align-items-start" style="position: relative;">
        <div>
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
        <button type="button" class="btn-close text-white" style="position: absolute; top: 0; right: 0;"
            data-bs-dismiss="alert" aria-label="Close">
            <i data-feather="x-circle"></i>
        </button>
    </div>
@endif



@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"><i
                data-feather="x-circle"></i></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"><i
                data-feather="x-circle"></i></button>
    </div>
@endif
