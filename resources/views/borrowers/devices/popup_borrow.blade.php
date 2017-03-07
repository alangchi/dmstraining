<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h1 class="modal-title">Add To Borrow</h1>
        </div>
        <meta name="_token" content="{{ csrf_token() }}" />   
        <div class="modal-body">
            <form action="" method="post">
                <input name="_method" type="hidden" value="PATCH">
                <div class="form-group">
                    <input type="hidden" value="deviceId" id="deviceId">
                </div>
                
                <div class="form-group">
                    <label>Sart Date:</label><span>*</span>
                    <input type="date" id ="startDate" name ="startDate"  data-date="" data-date-format="DD MMMM YYYY" value="<?php echo date("Y-m-d");?>">
                </div>
                <div class="form-group">
                    <label>End Date:</label><span>*</span>
                    <input type="date" id ="endDate" name ="endDate" data-date="" data-date-format="DD MMMM YYYY" value="<?php echo date("Y-m-d");?>">
                </div>

            </form>
        </div>
        <div class="modal-footer">
            <div class="left" style="text-align: center;">
                <button id="btnAccept" class="btn btn-primary" data-accept="modal">Accept</button>
            </div>
        </div>
      </div>
      
    </div>
  </div>