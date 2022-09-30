<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include('header2.php');
?> 
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Рассылка</h3>
			   
			</div>
			    
			
			<form action='?' id='form1' method="post" >
				<div class="box-body">
						<div class="form-group">
						<label >Уровень юзера</label>
						<select class="form-control"  name="user_type_id">
							<?foreach ((new User_Type($this))->get_all() as $row):?>
							<option value="<?=$row['id']?>" ><?=$row['name']?></option>
							<?endforeach;?>
						</select>
						</div>
						<div class="form-group">
						<label >Тема</label>
						<input  class="form-control" type="text" name="theme">
						</div>
						<div class="form-group">
						<label >Текст</label>
						<textarea  class="form-control" id="editor1" name="text"></textarea>
						</div>
				 
				<button  class="btn btn-block btn-primary" type="submit" >Разослать</button>
				</div>
				 
			</form>
			 
			  
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
 
        </div>
        <!-- /.col -->
      </div> 

<!-- START: page scripts -->
<script>
    $(function() {

        ///////////////////////////////////////////////////
        // SIDEBAR CURRENT STATE
        $('.cat__apps__messaging__tab').on('click', function(){
            $('.cat__apps__messaging__tab').removeClass('cat__apps__messaging__tab--selected');
            $(this).addClass('cat__apps__messaging__tab--selected');
        });

        ///////////////////////////////////////////////////////////
        // CUSTOM SCROLL
        if (!(/Mobi/.test(navigator.userAgent)) && jQuery().jScrollPane) {
            $('.custom-scroll').each(function() {
                $(this).jScrollPane({
                    autoReinitialise: true,
                    autoReinitialiseDelay: 100
                });
                var api = $(this).data('jsp'),
                        throttleTimeout;
                $(window).bind('resize', function() {
                    if (!throttleTimeout) {
                        throttleTimeout = setTimeout(function() {
                            api.reinitialise();
                            throttleTimeout = null;
                        }, 50);
                    }
                });
            });
        }

        ///////////////////////////////////////////////////////////
        // ADJUSTABLE TEXTAREA
        autosize($('.adjustable-textarea'));

    });
</script>
<!-- END: Page Scripts -->



 

<?include('footer2.php');?>

<script type="text/javascript"> 
$('textarea').summernote({
   
});
</script>
</body>
</html>