@extends('borrowers.master')
@section('title', 'User Histories')
@section('content')

<?php  if(isset($histories)) { ?>
<div class="table-responsive">  
<table class="table table-responsive">
    <thead>    
        <tr>
            <th>No.</th>
            <th>Username</th>
            <th>Code</th>
            <th>Name</th>
            <th>Type</th>
            <th>Os</th>
            <th>Version</th>
            <th>Model</th>
            <th>Manufactory</th>
            <th>Description</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php $id = 0; ?>
    @foreach($histories as $item)
    <?php $id = $id + 1;?>
        <tr>
            <td>{{ $id + 20 * ($histories->currentPage() - 1) }}</td>
            <td>{!! $item->username; !!}</td>
            <td>{!! $item->device_code; !!}</td>
            <td>{!! $item->device_name; !!}</td>
            <td>{!! $item->type_name; !!}</td>
            <td>{!! $item->os_name; !!}</td>
            <td>{!! $item->model_name; !!}</td>
            <td>{!! $item->version_name; !!}</td>
            <td>{!! $item->manufactory_name; !!}</td>
            <td>{!! $item->device_description; !!}</td>
            <td>{!! $item->start_at; !!}</td>
            <td>{!! $item->end_at; !!}</td>
            <td>
                <?php 
                    $t1    = strtotime($item->end_at);
                    $today = date("Y-m-d"); 
                    $t2    = strtotime($today);
                ?>
                @if(($t2 > $t1) && ($item->status_id == $defaultRequestDevice->id))
                    <img src="/uploads/icon-warning.png" alt="" height ="20px" width ="20px" />
                @elseif(($t2 > $t1) && ($item->status_id == $defaultReturnedDevice->id))
                    <img src="/uploads/{{ $item->status_image }}" alt="" height ="20px" width ="20px" />
                @else
                    <img src="/uploads/{{ $item->status_image }}" alt="" height ="20px" width ="20px" />
                @endif
            </td>
            <td>
                @if($item->status_id == $defaultRequestDevice->id)
                    <a style="font-weight: bold;">Requesting</a>
                @elseif($item->status_id == $defaultBorrowedDevice->id)
                    <a style="font-weight: bold;">Borrowing</a>
                @elseif($item->status_id == $defaultWarningDevice->id)
                    <a class="btn btn-warning" type="button" onclick="showPopup('{!! $item->id !!}','{!! $item->start_at !!}', '{!! $item->end_at !!}')">Update</a> 
                @elseif($item->status_id == $defaultReturnedDevice->id)
                    <a style="font-weight: bold;">Returned</a>
                @elseif($item->status_id == $defaultLostDevice->id)
                    <a style="font-weight: bold;">Lost</a>
                @else
                    <a style="font-weight: bold;">Cenceled</a>
                @endif

                @if(strtotime($today) > strtotime($item->end_at) && (($item->status_id == $defaultRequestDevice->id) || ($item->status_id == $defaultBorrowedDevice->id)))
                    <a class="btn btn-warning" type="button" onclick="showPopup('{!! $item->id !!}','{!! $item->start_at !!}', '{!! $item->end_at !!}')">Update</a> 
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
            url: '{{ URL::to('borrowers/devices/histories')}}',
            data: {'search':$value},
            success: function(data) {
                // console.log(data);
                $('tbody').html(data);
            }
        });
    });

</script>

    <!-- {!! $histories->links() !!} -->
<?php
$count = count($histories);
if($count){ ?>

    <div id="pagination">
        <ul class="pagination">
            @if($histories->currentPage() != 1)
            <li>
                <a href="{!! $histories->url(1) !!}">First</a>
            </li>
            @endif

            @if($histories->currentPage() != 1)
                <li>
                    <a href="{!! $histories->url($histories->currentPage() -1) !!}">Prev</a>
                </li>
            @endif

            @for($i = 1; $i<= $histories->lastPage() ; $i++)
                
                @if($i >=4 && $i <= ($histories->total()/$histories->perpage()) -3)
                    <a href="{!! $histories->url($i) !!}"></a>
                @else
                    <li class="{!! $histories->currentPage() == $i ? 'active' : '' !!}">
                        <a href="{!! $histories->url($i) !!}"> {!! $i !!}</a>
                    </li>
                @endif
            
            @endfor()

            @if($histories->currentPage() != $histories->lastPage())
                <li><a href="{!! $histories->url($histories->currentPage() +1) !!}">Next</a></li>
            @endif
            @if($histories->lastPage())
                <li><a href="{!! $histories->url($histories->lastPage()) !!}">Last</a></li>
            @endif
        </ul>
    </div>
    <?php } } ?>
</div>

<!-- Modal popup content-->
  @include('borrowers.devices.popup_update')
<!-- end Modal popup -->


@endsection
