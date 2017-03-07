@extends('layouts.app')
@section('title', 'Device Details')
@section('content')

<div class="table-responsive">  
    <table class="table table-responsive">
        <tr ro>
            <th>Device Code</th>
            <th>Device Name</th>
            <th>Image</th>
            <th>Description</th>
            <th>Type</th>
            <th>Manufuctory</th>
            <th>Version</th>
            <th>Model</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Status</th>
            
        </tr>
        <tr>
			<td> <?php echo $device_details->name; ?></td>
			<td> <?php echo $device_details->device_code; ?></td>
			<td> <img src="{{URL::asset('/img_uploads/'.$device_details->image)}}" alt="{{ $device_details->name }}" height="100" width="200"></td>
			<td> <?php echo $device_details->description; ?></td>
			<td> <?php echo $device_details->type_name; ?></td>
			<td> <?php echo $device_details->manufactory_name; ?></td>
			<td> <?php echo $device_details->version_name; ?></td>
			<td> <?php echo $device_details->model_name; ?></td>
			<td> <?php echo $device_details->created_at; ?></td>
			<td> <?php echo $device_details->updated_at; ?></td>
			<td> <?php echo $device_details->status_name; ?></td>
        </tr>
    </table>
</div>

@endsection
