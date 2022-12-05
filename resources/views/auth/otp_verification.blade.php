<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

    @if (session('success'))
        <div class="alert alert-success" role="alert"> {{session('success')}}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" role="alert"> {{session('error')}}
        </div>
    @endif

@error('otp')
<span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
@enderror
<section class="login col-sm-6 m-auto mt-5">
    <form action="{{ route('otp.login') }}" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{$user_id}}" />

        <div class="mb-3">
            <label for="phone_number" class="form-label">Verification Code</label>
            <input type="number" name="otp" class="form-control" placeholder="Enter verification code">
            @error('otp')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-block">Login With OTP</button>
    </form>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if(Session::has('success'))
        toastr.options = {
        "closeButton" : true,
        "progressBar" : true,
    }
    toastr.success('{{ session('success') }}', 'Congratulations!!!');

    @endif
        @if(Session::has('error'))
        toastr.options = {
        "closeButton" : true,
        "progressBar" : true
    }
    toastr.error('{{ session('error') }}', 'Ooops!!!');

    @endif
        @if($errors->any())
        @foreach($errors->all() as $error)
        toastr.options = {
        "closeButton" : true,
        "progressBar" : true}
    toastr.error('{{ $error }}');
    @endforeach
    @endif

</script>
</body>
</html>
