@extends('layouts.app')
@section('title', 'Histories')
@section('content')

<div class="table-responsive">  
    <table class="table table-responsive">
        <tr>
            <th>No.</th>
            <th>Username</th>
            <th>Code</th>
            <th>Device Name</th>
            <th>Type</th>
            <th>Version</th>
            <th>Model</th>
            <th>Manufuctory</th>
            <th>Start At</th>
            <th>End At</th>
            <th>Status</th>
            <th>Actions</th>
            
        </tr>
        <?php $id = 0; ?>
        @foreach($histories as $item)
        <?php $id = $id + 1;?>
        <tr>

            <td>{{ $id + 20 * ($histories->currentPage() - 1) }}</td>
            <td>{!! $item->username; !!}</td>
            <td>{!! $item->device_code; !!}</td>
            <td>{!! $item->device_name; !!}</td>
            <td>{!! $item->type_name; !!}</td>
            <td>{!! $item->model_name; !!}</td>
            <td>{!! $item->version_name; !!}</td>
            <td>{!! $item->manufactory_name; !!}</td>
            <td>{!! $item->start_at; !!}</td>
            <td>{!! $item->end_at; !!}</td>
            <td>
                <?php // $t1    = strtotime($item->end_at);
                    $today = date("Y-m-d");
                ?>
                @if((strtotime($today) > strtotime($item->end_at)) && ($item->history_status_id == $defaultWarningDevice->id))
                    <img src="/uploads/icon-warning.png" alt="" height ="20px" width ="20px" />    
                @else
                    <img src="/uploads/{{ $item->status_image }}" alt="" height ="20px" width ="20px" />
                @endif
            </td>
            <td>
                @if($item->history_status_id == $defaultRequestDevice->id)
                    <a href="update/{!! $item->id !!}" class="btn btn-success btn-block">Approve</a>
                @elseif($item->history_status_id == $defaultBorrowedDevice->id)
                    <a class="btn btn-primary btn-block" href="pay/{!! $item->id !!}" >Return</a>
                @elseif($item->history_status_id == $defaultWarningDevice->id)
                    <a class="btn btn-warning btn-block" href="inbox/{!! $item->id !!}" >Inbox</a>
                @elseif($item->history_status_id == $defaultReturnedDevice->id)
                    <a>Returned</a>
                @elseif($item->history_status_id == $defaultLostDevice->id)
                    <a>Lost</a>
                @endif

                @if(strtotime($today) > strtotime($item->end_at) && (($item->history_status_id == $defaultRequestDevice->id) || ($item->history_status_id == $defaultBorrowedDevice->id)))
                    <a class="btn btn-warning btn-block" href="inbox/{!! $item->id !!}" >Inbox</a>
                @endif
            </td>
        </tr>
        @endforeach
        
    </table>
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
        <?php } ?>
    </div>

        <!-- <script type="text/javascript">
            $( document ).ready(function() {
                $('.pagination a').on('click', function(event) {
                    event.preventDefault();
                    if ($(this).attr('href') != '#') {
                        $('#pagination').load($(this).attr('href'));
                    }
                });
            });
        </script> -->
    <!-- </div> -->
@endsection
