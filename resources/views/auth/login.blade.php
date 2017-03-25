@extends('layouts.app')

@section('content')
    @include('layouts.header', ['title' => 'Login', 'login' => ' is-active'])

    <div class="container">
        <div class="section">
            <form role="form" class="column is-offset-one-quarter is-one-third" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}

                <label for="email" class="label">E-Mail Address</label>

                <div class="control">
                    <input id="email" type="email" class="input{{ $errors->has('email') ? ' is-danger' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help is-danger">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>

                <label for="password" class="label">Password</label>
                <div class="control">
                    <input id="password" type="password" class="input{{ $errors->has('password') ? ' is-danger' : '' }}" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help is-danger">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>

                <div class="level">
                    <div class="level-left">
                        <p class="control">
                            <label class="checkbox">
                                <input type="checkbox">
                                Remember me
                            </label>
                        </p>
                    </div>

                    <button type="submit" class="button is-primary">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
