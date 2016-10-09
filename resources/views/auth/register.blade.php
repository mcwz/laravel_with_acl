@extends('layouts.main')

@section('title', '注册用户')

@section('content')
    <form method="POST" action="/auth/register" role="form" class="form-horizontal">
        {!! csrf_field() !!}
        <p class="bg-warning">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul style="color:red;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        </p>
        <div class="form-group">
            <label for="name" class="col-sm-2">用户名</label>
            <div class=" col-sm-10"><input type="text" class="form-control" id="name" name="name"
                                           value="{{ old('name') }}">
            </div>
        </div>

        <div class="form-group">
            <label for="email" class="col-sm-2">Email</label>
            <div class=" col-sm-10"><input type="email" class="form-control" id="email" name="email"
                                           value="{{ old('email') }}">
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="col-sm-2">密码</label>
            <div class=" col-sm-10"><input type="password" class="form-control" id="password" name="password">
            </div>
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="col-sm-2">确认密码</label>
            <div class=" col-sm-10"><input type="password" class="form-control" id="password_confirmation"
                                           name="password_confirmation">
            </div>
        </div>

        <div class="form-group">
            <button class="btn btn-default" type="submit">注册</button>
        </div>
    </form>
@endsection

