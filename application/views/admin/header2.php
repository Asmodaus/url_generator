<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Админ панель обменника </title>
    <link href="<?=$path?>modules/core/common/img/favicon.ico" rel="shortcut icon">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i" rel="stylesheet">

    <!-- VENDORS -->
    <!-- v2.0.0 -->
    <?/*
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/bootstrap/dist/css/bootstrap.min.css"> */?>
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/jscrollpane/style/jquery.jscrollpane.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/ladda/dist/ladda-themeless.min.css">
    <?/*
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/bootstrap-select/dist/css/bootstrap-select.min.css"> */?>
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/select2/dist/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/bootstrap-sweetalert/dist/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/summernote/dist/summernote.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/ionrangeslider/css/ion.rangeSlider.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/datatables/media/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/c3/c3.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/chartist/dist/chartist.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/nprogress/nprogress.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/jquery-steps/demo/css/jquery.steps.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/dropify/dist/css/dropify.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/font-linearicons/style.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/font-icomoon/style.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/cleanhtmlaudioplayer/src/player.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>vendors/cleanhtmlvideoplayer/src/player.css">
    <script src="<?=$path?>vendors/jquery/dist/jquery.min.js"></script>
    <script src="<?=$path?>vendors/tether/dist/js/tether.min.js"></script>
    <script src="<?=$path?>vendors/jquery-ui/jquery-ui.min.js"></script>
    <?/*
    <script src="<?=$path?>vendors/bootstrap/dist/js/bootstrap.min.js"></script> */?>
    <script src="<?=$path?>vendors/jquery-mousewheel/jquery.mousewheel.min.js"></script>
    <script src="<?=$path?>vendors/jscrollpane/script/jquery.jscrollpane.min.js"></script>
    <script src="<?=$path?>vendors/spin.js/spin.js"></script>
    <script src="<?=$path?>vendors/ladda/dist/ladda.min.js"></script>
    <script src="<?=$path?>vendors/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="<?=$path?>vendors/select2/dist/js/select2.full.min.js"></script>
    <script src="<?=$path?>vendors/html5-form-validation/dist/jquery.validation.min.js"></script>
    <script src="<?=$path?>vendors/jquery-typeahead/dist/jquery.typeahead.min.js"></script>
    <script src="<?=$path?>vendors/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
    <script src="<?=$path?>vendors/autosize/dist/autosize.min.js"></script>
    <script src="<?=$path?>vendors/bootstrap-show-password/bootstrap-show-password.min.js"></script>
    <script src="<?=$path?>vendors/moment/min/moment.min.js"></script>
    <script src="<?=$path?>vendors/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?=$path?>vendors/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="<?=$path?>vendors/bootstrap-sweetalert/dist/sweetalert.min.js"></script>
    <script src="<?=$path?>vendors/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js"></script>
    <script src="<?=$path?>vendors/summernote/dist/summernote.min.js"></script>
    <script src="<?=$path?>vendors/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="<?=$path?>vendors/ionrangeslider/js/ion.rangeSlider.min.js"></script>
    <script src="<?=$path?>vendors/nestable/jquery.nestable.js"></script> 
    <script src="<?=$path?>vendors/datatables/media/js/jquery.dataTables.min.js"></script> 
    <script src="<?=$path?>vendors/datatables/media/js/dataTables.bootstrap4.js"></script> 
    <script src="<?=$path?>vendors/datatables-fixedcolumns/js/dataTables.fixedColumns.js"></script>
    <script src="<?=$path?>vendors/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="<?=$path?>vendors/editable-table/mindmup-editabletable.js"></script>
    <script src="<?=$path?>vendors/d3/d3.min.js"></script>
    <script src="<?=$path?>vendors/c3/c3.min.js"></script>
    <script src="<?=$path?>vendors/chartist/dist/chartist.min.js"></script>
    <script src="<?=$path?>vendors/peity/jquery.peity.min.js"></script>
    <script src="<?=$path?>vendors/chartist-plugin-tooltip/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="<?=$path?>vendors/jquery-countTo/jquery.countTo.js"></script>
    <script src="<?=$path?>vendors/nprogress/nprogress.js"></script>
    <script src="<?=$path?>vendors/jquery-steps/build/jquery.steps.min.js"></script>
    <script src="<?=$path?>vendors/chart.js/dist/Chart.bundle.min.js"></script>
    <script src="<?=$path?>vendors/dropify/dist/js/dropify.min.js"></script>
    <script src="<?=$path?>vendors/cleanhtmlaudioplayer/src/jquery.cleanaudioplayer.js"></script>
    <script src="<?=$path?>vendors/cleanhtmlvideoplayer/src/jquery.cleanvideoplayer.js"></script>
	
	

    <!-- CLEAN UI ADMIN TEMPLATE MODULES-->
    <!-- v2.0.0 -->
    <link rel="stylesheet" type="text/css" href="<?=$path?>modules/core/common/core.cleanui.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>modules/vendors/common/vendors.cleanui.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>modules/layouts/common/layouts-pack.cleanui.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>modules/themes/common/themes.cleanui.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>modules/menu-left/common/menu-left.cleanui.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>modules/menu-right/common/menu-right.cleanui.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>modules/top-bar/common/top-bar.cleanui.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>modules/footer/common/footer.cleanui.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>modules/pages/common/pages.cleanui.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>modules/ecommerce/common/ecommerce.cleanui.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>modules/apps/common/apps.cleanui.css">
    <script src="<?=$path?>modules/menu-left/common/menu-left.cleanui.js"></script>
    <script src="<?=$path?>modules/menu-right/common/menu-right.cleanui.js"></script>
	  <script src="/js/system_js.js"></script>
	  
	  
	  <!-- include summernote css/js-->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
<script src="/js/editor.js"></script>

    <link rel="stylesheet" type="text/css" href="<?=$path?>css/bootstrap-select.min.css">
	<link rel="stylesheet" type="text/css" href="<?=$path?>css/custom_bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?=$path?>css/all.css">
</head>
<body class="cat__config--vertical cat__menu-left--colorful cat__menu-left--visible">

<nav class="cat__menu-left">
<div class="cat__menu-left__lock cat__menu-left__action--menu-toggle">
        <div class="cat__menu-left__pin-button">
            <div><!-- --></div>
        </div>
    </div>
    <!--<div class="cat__menu-left__logo">
        <a href="dashboards-alpha.html">
            <img src="modules/dummy-assets/common/img/logo-inverse.png" />
        </a>
    </div>-->
    <div class="cat__menu-left__inner">
		<?if (isset($user->id)):?>
        <ul class="cat__menu-left__list cat__menu-left__list--root">
            <li class="cat__menu-left__item cat__menu-left__item--active">
                <a href="/admin55">
                    <span class="cat__menu-left__icon icmn-home"></span>
                    Dashboard
                </a>
			<?if (1==2 && $user->check_laws('page/calc')):?> 
            <li class="cat__menu-left__item cat__menu-left__item">
                <a href="<?=$admurl?>page/calc">
				    <span class="cat__menu-left__icon fa fa-calculator"></span>
                    Калькулятор
                </a>
            </li>
			<?endif;?>
			 
			<?if (1==2 && $user->check_laws('confirmation/users')):?>
            <li class="cat__menu-left__item cat__menu-left__item">
                <a href="<?=$admurl?>confirmation/users">
				    <span class="cat__menu-left__icon fa fa-eye"></span>
					<?if($count_menu['confirm']['users']>0):?>
                    <span class="badge badge-danger pull-right"><?=$count_menu['confirm']['users']?></span>
					<?endif;?>
                    Проверка документов
                </a>
            </li>
			<?endif;?>
			<?if ($user->check_laws('confirmation/exchange')):?> 
            <li class="cat__menu-left__item cat__menu-left__item">
                <a href="<?=$admurl?>confirmation/exchange">
				    <span class="cat__menu-left__icon fa fa-exchange"></span>
					<?if($count_menu['confirm']['exchange']>0):?>
                    <span class="badge badge-info pull-right"><?=$count_menu['confirm']['exchange']?></span>
					<?endif;?>
                    Проверка заказа
                </a>
            </li>
			<?endif;?>
			  
			<?foreach ($editors2 as $k=>$v):?>  
			<?if ($user->check_laws('edit/'.$k)):?>
            <li class="cat__menu-left__divider"><!-- --></li>
			<li class="cat__menu-left__item cat__menu-left__submenu">
                <a href="javascript: void(0);">
                    <span class="cat__menu-left__icon fa fa-user"></span>
                    Управ. пользователями
                </a>
                <ul class="cat__menu-left__list">
                   <?foreach ($editors2 as $k=>$v):?>
						<?if ($user->check_laws('edit/'.$k)):?>
						<li class="cat__menu-left__item"><a href="<?=$admurl?>edit/<?=$k?>"> <?=$v?></a></li> 
						<?endif;?>
					<?endforeach;?> 
                </ul>
            </li>
            <li class="cat__menu-left__divider"><!-- --></li>
			<?
			break;
			endif;?>
			<?endforeach;?>  
			<?foreach ($editors as $k=>$v):?>  
			<?if ($user->check_laws('edit/'.$k)):?>
            <li class="cat__menu-left__item cat__menu-left__submenu">
                <a href="javascript: void(0);">
                    <span class="cat__menu-left__icon fa fa-desktop"></span>
                    Сайт
                </a>
                <ul class="cat__menu-left__list">
					<?foreach ($editors as $k=>$v):?>
						<?if ($user->check_laws('edit/'.$k)):?>
						<li class="cat__menu-left__item"><a href="<?=$admurl?>edit/<?=$k?>"> <?=$v?></a></li> 
						<?endif;?>
					<?endforeach;?> 
                </ul>
            </li>
            <li class="cat__menu-left__divider"><!-- --></li>
			 <?
			break;
			endif;?>
			<?endforeach;?>  
			<?if (1==2 && $user->check_laws('logs')):?> 
            <li class="cat__menu-left__item cat__menu-left__submenu">
                <a href="javascript: void(0);">
                    <span class="cat__menu-left__icon fa fa-info"></span>
                    Отчеты
                </a>
                <ul class="cat__menu-left__list">
					<?foreach ($logs as $k=>$v):?>
						<li class="cat__menu-left__item"><a href="<?=$admurl?>logs/<?=$k?>"> <?=$v?></a></li> 
					<?endforeach;?> 
					
					<?if ($user->check_laws('graph')):?> 
						<?foreach ($graphs as $k=>$v):?>
							<li class="cat__menu-left__item"><a href="<?=$admurl?>graph/<?=$k?>"> <?=$v?></a></li> 
						<?endforeach;?> 
					<?endif;?> 
                </ul>
            </li>
			<?endif;?>
            <li class="cat__menu-left__divider"><!-- --></li>
            <!--<li class="cat__menu-left__item cat__menu-left__item">
                <a href="rates.html">
				    <span class="cat__menu-left__icon fa fa-btc"></span>
                    Курсы валют
                </a>
            </li>-->
			<?if ($user->check_laws('page/ref_vods')):?> 
            <li class="cat__menu-left__item cat__menu-left__item">
                <a href="<?=$admurl?>page/ref_vods">
				    <span class="cat__menu-left__icon fa fa-sitemap"></span>
                    Рефоводы
                </a>
            </li>
			<?endif;?>
			<?if (1==2 && $user->check_laws('page/app_list')):?> 
            <li class="cat__menu-left__item cat__menu-left__item">
                <a href="<?=$admurl?>page/app_list">
				    <span class="cat__menu-left__icon fa fa-sitemap"></span>
                    Партнеры
                </a>
            </li>
			<?endif;?>
			<?if (1==2 && $user->check_laws('mailer')):?> 
			<li class="cat__menu-left__item cat__menu-left__item">
                <a href="<?=$admurl?>mailer">
				    <span class="cat__menu-left__icon fa fa-sitemap"></span>
                    Рассылка
                </a>
            </li>
			
			<li class="cat__menu-left__item cat__menu-left__item">
                <a href="<?=$admurl?>page/webpush">
				    <span class="cat__menu-left__icon fa fa-sitemap"></span>
                    Рассылка WebPush
                </a>
            </li>
			<?endif;?>
			<li class="cat__menu-left__item cat__menu-left__item ">
                <a href="/logout">
                    <span class="cat__menu-left__icon icmn-home"></span>
                    Выйти
                </a>
			 </li>
        </ul>
		<?endif;?>
    </div>
</nav>
 