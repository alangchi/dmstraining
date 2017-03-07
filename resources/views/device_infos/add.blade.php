@extends('layouts.app')
@section('title', 'Create Devices Info')
@section('content')

{!! Form::open([
    'files'=>true,'method'=>'post'
]) !!}

@include('blocks.errors')

<div class="container-fluid">
    <div class="form-device">
        <div class="row">
            <div class="form-group">
                {!! Form::label('deviceType', 'Device Type:', ['class' => 'control-label']) !!}<span>*</span>
                {!! Form::text('deviceType', 'PC', ['class' => 'form-control']) !!}
            </div>


            <div class="form-group">
                {!! Form::label('deviceOs', 'Device Os:', ['class' => 'control-label']) !!}<span>*</span>
                {!! Form::text('deviceOs', 'IOS', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('deviceModel', 'Device Model:', ['class' => 'control-label']) !!}<span>*</span>
                {!! Form::text('deviceModel', 'Moderm', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('deviceVersion', 'Device Version:', ['class' => 'control-label']) !!}<span>*</span>
                {!! Form::text('deviceVersion', '9.1', ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('deviceManufactory', 'Device Manufactory:', ['class' => 'control-label']) !!}<span>*</span>
                {!! Form::text('deviceManufactory', 'Apple', ['class' => 'form-control']) !!}
            </div>

            {!! Form::submit('Add', ['class' => 'btn btn-success']) !!}

			{!! Form::close() !!}
        </div>
    </div>
</div>
@endsection