@extends('layouts.main')

@section('title', '登录系统')

@section('content')
    <form method="POST" action="/auth/login" role="form" class="form-horizontal">
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
            <label class="col-sm-2" for="name">Email</label>
            <div class=" col-sm-10"><input type="email" class="form-control" name="email" value="{{ old('email') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2" for="name">密码</label>
            <div class=" col-sm-10"><input type="password" class="form-control" name="password" id="password">
            </div>
        </div>

        <div class="form-group">
            <input type="checkbox" name="remember"> 记住我
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-default">登录</button>
        </div>
    </form>
@endsection

