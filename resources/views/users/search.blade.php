@extends('layouts.app')
@section('title', 'List users')
@section('content') 

<?php if(isset($users)){ ?>
	<h5 class="add"><a style="margin-left: 0px;" href='create_user' class="btn btn-success btn-block"><span class="glyphicon glyphicon-plus"></span>  Add User</a></h5>
<table class="table table-responsive" id="dataTables-example">
    <thead>
        <tr align="center">
            <th>No.</th>
            <th>ID</th>
            <th>Full Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Level</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php $id = 0; ?>      
        @foreach($users as $user) 
    <?php $id = $id + 1;?>
        <tr class="odd gradeX" align="center">
            <td>{{ $id + 20 * ($users->currentPage() - 1) }}</td>
            <td>{{ $user->id }}</td>
            <td>{{ $user->full_name }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @if($user->role_name == 'admin')
                    <?php echo 'Admin'; ?>
                @elseif($user->role_name == 'member')
                    <?php echo 'User Member'; ?>
                @else
                    <?php echo 'User Manager'; ?>
                @endif
            </td>
            <td class="center"><i class="fa fa-trash-o  fa-fw"></i>
                <a href='edit_user/{{ $user->id }}'><span class="glyphicon glyphicon-wrench"></span></a> &nbsp;&nbsp;
                <a Onclick="return ConfirmDelete();" href='delete_user/{{ $user->id }}'><span class="glyphicon glyphicon-trash"></span></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
	<?php
		$count = count($users);
		if($count){ 
	?>

	<div id="pagination">
	    <ul class="pagination">
	        @if($users->currentPage() != 1)
	        <li>
	            <a href="{!! $users->url(1) !!}">First</a>
	        </li>
	        @endif

	        @if($users->currentPage() != 1)
	            <li>
	                <a href="{!! $users->url($users->currentPage() -1) !!}">Prev</a>
	            </li>
	        @endif

	        @for($i = 1; $i<= $users->lastPage() ; $i++)
	            
	            @if($i >=4 && $i <= ($users->total()/$users->perpage()) -3)
	                <a href="{!! $users->url($i) !!}"></a>
	            @else
	                <li class="{!! $users->currentPage() == $i ? 'active' : '' !!}">
	                    <a href="{!! $users->url($i) !!}"> {!! $i !!}</a>
	                </li>
	            @endif
	        
	        @endfor()

	        @if($users->currentPage() != $users->lastPage())
	            <li><a href="{!! $users->url($users->currentPage() +1) !!}">Next</a></li>
	        @endif
	        @if($users->lastPage())
	            <li><a href="{!! $users->url($users->lastPage()) !!}">Last</a></li>
	        @endif
	    </ul>
	</div>
	<?php 
	} 
 } 
?>

<script type="text/javascript">
    $('#search').on('keyup',function() {
        $value = $(this).val();
        $.ajax({
        	type: 'get',
        	url: '{{ URL::to('users/list_users')}}',
        	data: {'search':$value},
        	success: function(data) {
        		$('tbody').html(data);
        	}
        });
    });

</script>
@stop