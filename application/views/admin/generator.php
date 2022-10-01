<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include('header2.php');

if ($user->partner_boss>0) $P = new Users($this,$user->partner_boss);
else $P = $user;
?>

<div class="cat__top-bar">
    <!-- left aligned items -->
    <div class="cat__top-bar__left">
        <div class="cat__top-bar__logo">
            <!--<a href="dashboards-alpha.html">
                <img src="<?=$path?>modules/dummy-assets/common/img/logo.png" />
            </a>-->
        </div>
    </div>
    <!-- right aligned items -->
</div>
<div class="cat__content"> 
<?if (count($result)):?>
 <div  class="alert alert-default" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="alert-heading">Ошибка!</h4>
                        <p id="itog" > <?  echo '<br>'.$result;?>  </p> 
</div>
<?endif;?>

<section class="card main_col row mx-n2">
    <div class="card-header">
        <span class="cat__core__title">
            <strong>Генератор ссылок</strong>
        </span>
    </div>
        
				<form class="login-form"   action="/admin55/edit/links/0/save" method="post" enctype="multipart/form-data"  role="form">
					<div class="card-block">
						 
							<?foreach ($model->generate_form_rows('form-control') as $k=>$form_row):?>
							 
								<div class="ml-2 mt-2 row"><div class=" col-lg-12"><div class="mb-5"><div class=" form-group row">
								<label class="col-md-3 col-form-label" for="form_<?=$k?>"><?=$form_row['title']?></label>
								<div class="col-md-9">
							  
									<?=$form_row['form']?>
								 
								</div>
								</div></div></div></div>
							<?endforeach;?>
							 
							<div class="form-actions">
												<div class="form-group row">
													<div class="col-md-9 offset-md-3">
														<a href="<?=$admurl?>edit/<?=$model_name?>/" class="btn  btn-default">Перейти в архив</a>
														<button type="submit" class="btn  btn-primary">Создать</button>
													</div>
												</div>
							</div>					
							  
					
				</div>
	</form>
</section>
			 
			 
		 
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