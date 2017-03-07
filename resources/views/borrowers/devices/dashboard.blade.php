@extends('borrowers.master')
@section('title', 'List Devices')
@section('content')

<?php if(isset($listDevices)){ ?>
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

    <table class="table table-responsive" id="dataTables-example">
    <thead>
        <tr>
            <th>No.</th>
            <th>Code</th>
            <th>Name</th>
            <th>Type</th>
            <th>Description</th>
            <th>Manufactory</th>
            <th>Version</th>
            <th>Model</th>
            <th>Os</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php $id = 0; ?>
    @foreach($listDevices as $item)
    <?php $id = $id + 1;?>
        <tr>
            <td>{{ $id + 20 * ($listDevices->currentPage() - 1) }}</td>
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
            <td>{!! $item->os_name; !!}</td>
            <td><img src="/uploads/{{ $item->status_image }}" alt="" height ="20px" width ="20px" /></td>
            <td>
                @if($item->status_id == $defaultDevicesAvalable->id)
                    <a class="btn btn-success btn-block" type="button" onclick="showAddBorrowModal({!! $item->id !!})">Borrow</a>
                @elseif($item->status_id == $defaultDevicesBorrowing->id)
                    <a style="font-weight: bold;">Borrowing</a>
                @elseif($item->status_id == $defaultDevicesBroken->id)
                    <a style="font-weight: bold;">Broken</a>
                @elseif($item->status_id == $defaultDevicesLost->id)
                    <a style="font-weight: bold;">Lost</a>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    
<!-- Search devices -->
<script type="text/javascript">
    $('#search').on('keyup',function() {
        $value = $(this).val();
        $.ajax({
            type: 'get',
            url: '{{ URL::to('borrowers/devices/dashboard')}}',
            data: {'search':$value},
            success: function(data) {
                $('tbody').html(data);
            }
        });
    });

</script>

<!-- {!! $listDevices->links() !!} -->
<?php
$count = count($listDevices);
if($count){ ?>
<div id="pagination">
    <ul class="pagination">
        @if($listDevices->currentPage() != 1)
        <li>
            <a href="{!! $listDevices->url(1) !!}">First</a>
        </li>
        @endif

        @if($listDevices->currentPage() != 1)
            <li>
                <a href="{!! $listDevices->url($listDevices->currentPage() -1) !!}">Prev</a>
            </li>
        @endif

        @for($i = 1; $i<= $listDevices->lastPage() ; $i++)
            
            @if($i >=4 && $i <= ($listDevices->total()/$listDevices->perpage()) -3)
                <a href="{!! $listDevices->url($i) !!}"></a>
            @else
                <li class="{!! $listDevices->currentPage() == $i ? 'active' : '' !!}">
                    <a href="{!! $listDevices->url($i) !!}"> {!! $i !!}</a>
                </li>
            @endif
        
        @endfor()

        @if($listDevices->currentPage() != $listDevices->lastPage())
            <li><a href="{!! $listDevices->url($listDevices->currentPage() +1) !!}">Next</a></li>
        @endif
        @if($listDevices->lastPage())
            <li><a href="{!! $listDevices->url($listDevices->lastPage()) !!}">Last</a></li>
        @endif
    </ul>
</div>
<?php } } ?>

<!-- Modal popup content-->
  @include('borrowers.devices.popup_borrow')
<!-- end Modal popup -->
@endsection

