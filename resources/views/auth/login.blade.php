@extends('layouts.main')

@section('content')
    <div class="container">
        @include('layouts.flash-message')

        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <form class="form" action="{{ route('login.post') }}" method="post">
                            @csrf
                            <h3 class="text-center">Login</h3>
                            <div class="form-group">
                                <label for="email">Email:</label><br>
                                <input type="text" name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label><br>
                                <input type="text" name="password" id="password" class="form-control">
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="remember-me">
                                        <span>Remember me</span><span>
                                        <input id="remember-me" name="remember-me" type="checkbox"></span>
                                    </label>
                                    <br>
                                    <input type="submit" name="submit" class="btn btn-info btn-md" value="Login">
                                </div>
                                <div class="col-6">
                                    <div class="text-right my-auto">
                                        <a href="{{ route('register') }}">Register here</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

