@extends('layouts.app')
@section('title', 'Update users')
@section('content') 
<style type="text/css">
.col-lg-9{
    padding-top: 30px;
    margin-left: 200px;
}
    label{
        float: left;
    }
    button{
        float: left;
        margin-left: 10px;
    }
    .radio-inline input {
        color: red;
        margin-left: 20px;
    }
</style>
<div class="col-lg-9">
    @include('blocks.errors')
    <form action="" method="POST">
        <input type ="hidden" name="_token" value = "{!! csrf_token() !!}">
        
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" value ="{!! old('email', isset($data) ? $data['email'] : null) !!}" disabled/>
        </div>

        <div class="form-group">
            <label>Full Name</label>
            <input class="form-control" name="full_name" value ="{!! old('full_name', isset($data) ? $data['full_name'] : null) !!}"/>
        </div>

        <div class="form-group">
            <label>Username</label>
            <input class="form-control" name="txtUser" value ="{!! old('txtUser', isset($data) ? $data['username'] : null) !!}"  />
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="txtPass"  placeholder=" Enter Password" />
        </div>

        <div class="form-group">
            <label>RePassword</label>
            <input type="password" class="form-control" name="txtRePass" placeholder=" Enter RePassword" />
        </div>


        @if(Auth::user()->id != $id)
        <div class="form-group" >
            <label>Role</label><br/>
            <label class="radio-inline">
                <input name="rdoLevel" value="{{ $defaultRoleUserAdmin->id }}" type="radio"
                @if($data["role_id"] == $defaultRoleUserAdmin->id)
                     checked="checked"
                @endif >Admin
            </label>
            <label class="radio-inline">
                <input name="rdoLevel" value="{{ $defaultRoleUserMember->id }}" type="radio"
                @if($data["role_id"] == $defaultRoleUserMember->id)
                     checked="checked"
                @endif >Member
            </label>
            <label class="radio-inline">
                <input name="rdoLevel" value="{{ $defaultRoleUserManger->id }}" type="radio"
                @if($data["role_id"] == $defaultRoleUserManger->id)
                     checked="checked"
                @endif >Manager
            </label>
        </div>
        @endif
        <br/>
        <div class="form-group">
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="reset" class="btn btn-danger">Reset</button>
        </div>
    <form>
</div>
@stop