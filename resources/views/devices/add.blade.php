@extends('layouts.app')
@section('title', 'Add Device')
@section('content')
 
</script>
{!! Form::open(['files'=>true,'method'=>'post']) !!}

@include('blocks.errors')

<!-- <div class="container" style="margin-top: 50px"> -->
<div class="container-fluid">
    <div class="form-device">
        <div class="row">
            <div class="form-group">
                {!! Form::label('txtDevice', 'Device name:', ['class' => 'control-label']) !!}<span>*</span>
                {!! Form::text('name', 'PC PhiLips', ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('txtDeviceCode', 'Device Code:', ['class' => 'control-label']) !!}<span>*</span>
                {!! Form::text('device_code', '03PC', ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('txtDeviceDes', 'Description:', ['class' => 'control-label']) !!}<span>*</span>
                {!! Form::textarea('description', 'Echo device description', ['class' => 'form-control']) !!}
            </div>

            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('image', 'Choose an Image') !!}<span>*</span>
                        {!! Form::file('image', ['class' => 'form']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Type', 'Type:') !!}<span>*</span>
                      <select class="form-control" name="type_id" id="txtType" class="required">
                            <!-- <option value="-1" selected="selected">Choose Device Type</option> -->
                            @foreach($type as $item)
                            <option value="{!! $item->id !!}">{!! $item->name; !!}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        {!! Form::label('Os', 'Os:') !!}<span>*</span>
                      <select class="form-control" name="os_id">
                            <!-- <option value="0">Choose Os</option> -->
                            @foreach($os as $item)
                            <option value="{!! $item->id !!}">{!! $item->name; !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                        {!! Form::label('Version', 'Version:') !!}<span>*</span>
                      <select class="form-control" name="version_id">
                            <!-- <option value="0">Choose Version</option> -->
                            @foreach($version as $item)
                            <option value="{!! $item->id !!}">{!! $item->name; !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        {!! Form::label('Manufactory', 'Manufactory:') !!}<span>*</span>
                        <select class="form-control" name="manufatory_id">
                            <!-- <option value="0">Choose Manufactory</option> -->
                            @foreach($manufactory as $item)
                            <option value="{!! $item->id !!}">{!! $item->name; !!}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                      {!! Form::label('model', 'Model:') !!}<span>*</span>
                      <select class="form-control" name="model_id">
                      <!-- <option value="0">Choose Model</option> -->
                        @foreach($model as $item)
                          <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                      </select>
                    </div>
                </div>  
            </div>
        {!! Form::submit('ADD', ['class' => 'btn btn-success','id'=>'add_devices']) !!}

        {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection
