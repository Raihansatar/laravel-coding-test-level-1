@if ($message = Session::get('success'))
    <div class="alert alert-custom alert-success fade show" role="alert">
        <div class="alert-text">{{ $message }}</div>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-custom alert-danger fade show" role="alert">
        <div class="alert-text">{{ $message }}</div>
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="alert alert-custom alert-warning fade show" role="alert">
        <div class="alert-text">{{ $message }}</div>
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="alert alert-custom alert-info fade show" role="alert">
        <div class="alert-text">{{ $message }}</div>
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-custom alert-danger fade show mb-5" role="alert">
        <div class="alert-text">
            <ul class="pb-0 mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
