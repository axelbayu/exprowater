@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div style="max-width:420px;margin:2rem auto;">
    <h2 style="margin-bottom:8px;">Masuk ke Exprowater</h2>
    <p style="color:#6a8fa8;margin-bottom:16px;">Silakan masukkan kredensial Anda.</p>

    <div class="card" style="padding:1rem;">
        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="form-group" style="margin-bottom:10px;">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <div class="form-group" style="margin-bottom:10px;">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required
                       class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}">
                @if($errors->has('password'))
                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:8px;">
                <label style="font-size:13px;color:#6a8fa8;"><input type="checkbox" name="remember"> Ingat saya</label>
                <button type="submit" class="btn btn-primary">Masuk</button>
            </div>
        </form>
    </div>
</div>
@endsection
