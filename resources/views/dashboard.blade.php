@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<h5 class="add"><a style="margin-left: 0px" href="{{ url('/devices/add') }}" class="btn btn-success btn-block"><span class="glyphicon glyphicon-plus"></span>  Add Device</a></h5>

<div class="col-md-12">
    <div class="row">
        {!! Form::open(['method'=>'get']) !!}
            <ul class="filter">
                <li>
                    <select class="form-control" name="type_devices">
                        <option value="0" >Type</option>
                        @foreach($type as $item)
                          <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </li>
                <li>
                    <select class="form-control" name="manufactory_devices">
                        <option value="0">Manufactory</option>
                        @foreach($manufactory as $item)
                          <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </li>
                <li>
                    <select class="form-control" name="version_devices">
                        <option value="0">Version</option>
                        @foreach($version as $item)
                          <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </li>
                <li>
                    <select class="form-control" name="model_devices">
                        <option value="0">Model</option>
                        @foreach($model as $item)
                          <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </li>
                <li>
                    <select class="form-control" name="os_devices">
                        <option value="0">Os</option>
                        @foreach($os as $item)
                          <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </li>
            </ul>
            
            {!! Form::close() !!}
        </div>
    </div>
<!-- <div class="table-responsive"> -->
    <table class="table table-responsive" id="search_on">

        <tr>
            <th>No.</th>
            <th>Code</th>
            <th>Name</th>
            <th>Type</th>
            <th>Description</th>
            <th>Manufuctory</th>
            <th>Version</th>
            <th>Model</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

    <?php $id = 0; ?>
    @foreach($dashboard as $item)
    <?php $id = $id + 1;?>
        <tr>
            <td>{{ $id + 20 * ($dashboard->currentPage() - 1) }}</td>
            <td>{!! $item->device_code; !!}</td>
            <td id="show_img">{!! $item->name; !!}
                <div id="img">
                    <img src="/img_uploads/{{ $item->image }}" alt="{{ $item->name }}"  />
                </div>
            </td>
            
            <td>{!! $item->type_name; !!}</td>
            <td>{!! $item->description; !!}</td>
            <td>{!! $item->manufactory_name; !!}</td>
            <td>{!! $item->version_name; !!}</td>
            <td>{!! $item->model_name; !!}</td>
            <td>{!! $item->created_at; !!}</td>
            <td>{!! $item->updated_at; !!}</td>
            <td><img src="/uploads/{{ $item->status_image }}" alt="" height ="20px" width ="20px" /></td>
            <td><a href='devices/{{ $item->id }}/show_device_details'><span class="glyphicon glyphicon-screenshot
"></span></a>&nbsp;&nbsp;<a href='device/edit/{{ $item->id }}'><span class="glyphicon glyphicon-wrench"></span></a>&nbsp;&nbsp;
                <a Onclick="return ConfirmDelete();" href='device/delete/{{ $item->id }}'><span class="glyphicon glyphicon-trash"></span></a></td>
        </tr>
    @endforeach

        
    </table>

<?php
$count = count($dashboard);
    if($count){ ?>
        <div id="pagination">
            <ul class="pagination">
                @if($dashboard->currentPage() != 1)
                <li>
                    <a href="{!! $dashboard->url(1) !!}">First</a>
                </li>
                @endif

                @if($dashboard->currentPage() != 1)
                    <li>
                        <a href="{!! $dashboard->url($dashboard->currentPage() -1) !!}">Prev</a>
                    </li>
                @endif

                @for($i = 1; $i<= $dashboard->lastPage() ; $i++)
                    
                    @if($i >=4 && $i <= ($dashboard->total()/$dashboard->perpage()) -3)
                        <a href="{!! $dashboard->url($i) !!}"></a>
                    @else
                        <li class="{!! $dashboard->currentPage() == $i ? 'active' : '' !!}">
                            <a href="{!! $dashboard->url($i) !!}"> {!! $i !!}</a>
                        </li>
                    @endif
                
                @endfor()

                @if($dashboard->currentPage() != $dashboard->lastPage())
                    <li><a href="{!! $dashboard->url($dashboard->currentPage() +1) !!}">Next</a></li>
                @endif
                @if($dashboard->lastPage())
                    <li><a href="{!! $dashboard->url($dashboard->lastPage()) !!}">Last</a></li>
                @endif
            </ul>
        </div>
   <?php } ?>

<!-- </div> -->
@endsection

