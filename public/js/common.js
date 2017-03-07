
//alert for success and failed
$("div.alert").delay(2000).slideUp();

// button in app.blade.php
var click_hide = true;

$(document).ready(function(){
    $(".click-hide").click(function(){
        $(this).data('clicked', true);

        if($('.click-hide').data('clicked')) {
            if(click_hide) {
                $(".col-md-2").addClass("left-abc");
                $(".col-md-10").addClass("right-abc");
                $(".row-head").addClass("head");
                $("footer").addClass("footer");

                $(".list-group a.list-group-item").addClass("hide-text");
                $("a.list-group-item").addClass("large");
                $(".list-group a #icon").addClass("icon");
                $("#big").attr('src',"/images/logo_img.png");

                click_hide = false;
            } else {
                $(".col-md-2").removeClass("left-abc");
                $(".col-md-10").removeClass("right-abc");
                $(".row-head").removeClass("head");
                $("footer").removeClass("footer");
                $(".list-group a.list-group-item").removeClass("hide-text");
                $("a.list-group-item").removeClass("large");
                $(".list-group a #icon").removeClass("icon");
                $("#big").attr('src',"/images/logo.png");

                click_hide = true;
            }
        }
    });
});

//Devices delete
function ConfirmDelete() {
  var x = confirm("Are you sure you want to delete?");
  if (x)
      return true;
  else
    return false;
}

//request post to borrow
var showAddBorrowModal = function(id){
    $('#myModal').modal('show');
    $('#deviceId').val(id);
};
$(document).ready(function(){
    
    $("#btnAccept").click(function(e){
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

        e.preventDefault();
        var start = $("#startDate").val();
        var end   = $("#endDate").val();
        var deviceId = $('#deviceId').val();
        var data  = { start:start, end:end};
        var url   = 'http://10.121.79.81:8000/borrowers/devices/borrows/'+deviceId;
        $('#myModal').modal('hide');
        $.ajax({
            type:'POST',
            dataType: 'json',
            data:data,
            url:url,
            success:function(data) {
                console.log(data);
                $('#myModal').modal('hide');
            }
        });
    });
});

//Request to update

var showPopup = function(hid, start_at, end_at){
    $('#myModal').modal('show');
    $('#hId').val(hid);
    $('#start').val(start_at);
    $('#end').val(end_at);
};
$(document).ready(function(){
    
    $("#btnUpdate").click(function(e){
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

        e.preventDefault();
        var start = $("#start").val();
        var end   = $("#endDate").val();
        var hId   = $('#hId').val();
        var data  = { start:start, end_at:end};
        var url   = 'http://dmstraining.herokuapp.com/borrowers/devices/update/'+hId;
        $('#myModal').modal('hide');
        $.ajax({
            type:'POST',
            dataType: 'json',
            data:data,
            url:url,
            success:function(data) {
                $('#myModal').modal('hide');
            }
        });
    });
});
//http://127.0.0.1:8000/dashboard
