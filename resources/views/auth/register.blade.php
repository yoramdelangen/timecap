@extends('layouts.app')

@section('content')
    @include('layouts.header', ['title' => 'Register', 'register' => ' is-active'])

    <div class="container">
        <div class="section">
            <form role="form" class="column is-one-third" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}

                <label for="name" class="label">Name</label>
                <div class="control">
                    <input id="name" type="text" class="input{{ $errors->has('name') ? ' is-danger' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                    @if ($errors->has('name'))
                        <span class="help is-danger">
                            {{ $errors->first('name') }}
                        </span>
                    @endif
                </div>

                <label for="email" class="label">E-Mail Address</label>
                <div class="control">
                    <input id="email" type="email" class="input {{ $errors->has('email') ? ' is-danger' : '' }}" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>

                <label for="password" class="label">Password</label>
                <div class="control">
                    <input id="password" type="password" class="input{{ $errors->has('password') ? ' is-danger' : '' }}" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>

                <label for="password-confirm" class="label">Confirm Password</label>
                <div class="control">
                    <input id="password-confirm" type="password" class="input" name="password_confirmation" required>
                </div>

                <div class="control">
                    <button type="submit" class="button is-primary">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
