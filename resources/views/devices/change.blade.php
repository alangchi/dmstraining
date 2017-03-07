@extends('layouts.app')
@section('title', 'Update Device')
@section('content')

{!! Form::open(['files'=>true,'method'=>'post']) !!}

@include('blocks.errors')
<?php //echo $devicesChange; die; ?>
<div class="container-fluid">
    <div class="form-device">
        <div class="form-group">
            {!! Form::label('txtDevice', 'Device name:', ['class' => 'control-label']) !!}<span>*</span>
            {!! Form::text('name', $devicesChange["name"], ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('txtDeviceCode', 'Device Code:', ['class' => 'control-label']) !!}<span>*</span>
            {!! Form::text('device_code', $devicesChange["device_code"], ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('txtDeviceDes', 'Description:', ['class' => 'control-label']) !!}<span>*</span>
            {!! Form::textarea('description', $devicesChange["description"], ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('Show Image', 'Old Image :', ['class' => 'control-label']) !!}
            <img src="{{URL::asset('/img_uploads/'.$devicesChange['image'])}}" alt="{{ $devicesChange['name'] }}" height="50" width="50">
        </div>
         
        <div class="form-group">
        {!! Form::label('image', 'Choose an Image') !!}<span>*</span>
        {!! Form::file('image', ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <select class="form-control" name="type_id">
                        <option value="{{ $devicesChange['type_id'] }}">Type</option>
                        @foreach($type as $item)
                        <option value="{!! $item->id !!}">{!! $item->name; !!}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <select class="form-control" name="os_id">
                        <option value="{{ $devicesChange['os_id'] }}">Os</option>
                        @foreach($os as $item)
                        <option value="{!! $item->id !!}">{!! $item->name; !!}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <select class="form-control" name="status_id">
                        <option value="{{ $devicesChange['status_id'] }}">Status</option>
                        @foreach($status as $item)
                        <option value="{!! $item->id !!}">{!! $item->name; !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <select class="form-control" name="manufatory_id">
                        <option value="{{ $devicesChange['manufatory_id'] }}">Manufactory</option>
                        @foreach($manufactory as $item)
                        <option value="{!! $item->id !!}">{!! $item->name; !!}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <select class="form-control" name="version_id">
                        <option value="{{ $devicesChange['version_id'] }}">Version</option>
                        @foreach($version as $item)
                        <option value="{!! $item->id !!}">{!! $item->name; !!}</option>
                        @endforeach
                    </select>

                </div>

                <div class="form-group">
                    <select class="form-control" name="model_id">
                        <option value="{{ $devicesChange['model_id'] }}">Model</option>
                        @foreach($model as $item)
                        <option value="{!! $item->id !!}">{!! $item->name; !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {!! Form::submit('UPDATE', ['class' => 'btn btn-success']) !!}

        {!! Form::close() !!}
    </div>
</div>

@endsection
