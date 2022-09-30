<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=$path?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=$path?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=$path?>dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=$path?>plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?=$path?>plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?=$path?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?=$path?>plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?=$path?>plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?=$path?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
 
	
	<script type="text/javascript" src="/js/qrcode.js"></script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="<?=$path?>https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="<?=$path?>https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script src="/js/system_js.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="<?=$path?>#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
         
          <!-- Tasks: style can be found in dropdown.less -->
        
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="/profile" class="dropdown-toggle"  >
              <img src="<?=$path?>dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?=$user->name?></span>
            </a>
             
          </li>
           
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
		 
        <div class="pull-left image">
          <img src="<?=$path?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
		 
        <div class="pull-left info">
          <p><?=$user->name?></p>
          <a href="/logout"><i class="fa fa-circle text-success"></i> Logout</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
	  <?if (isset($user->id)):?>
      <ul class="sidebar-menu">
	  
		 <?if ($user->check_laws('page/ref_vods')):?>
		  <li  >
          <a href="/admin55/page/ref_vods">
            <i class="fa fa-files-o"></i>
            <span>Рефоводы</span>
			 
          </a> 
        </li>
		<?endif;?>
		 <?if ($user->check_laws('page/calc')):?>
		<li  >
          <a href="/admin55/page/calc">
            <i class="fa fa-files-o"></i>
            <span>Калькулятор</span>
			 
          </a> 
        </li>
		<?endif;?>
		 <?if ($user->check_laws('mailer')):?>
		<li  >
          <a href="/admin55/mailer">
            <i class="fa fa-files-o"></i>
            <span>Рассылка</span>
			 
          </a> 
        </li>
		<?endif;?>
		 <?if ($user->check_laws('confirmation/users')):?>
		  <li  >
          <a href="/admin55/confirmation/users">
            <i class="fa fa-files-o"></i>
            <span>Подтверждение паспорта</span>
			<?if($count_menu['confirm']['users']>0):?>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?=$count_menu['confirm']['users']?></span>
            </span>
			<?endif;?>
          </a> 
        </li>
		<?endif;?>
		<?if ($user->check_laws('confirmation/exchange')):?>
		<li  >
          <a href="/admin55/confirmation/exchange">
            <i class="fa fa-files-o"></i>
            <span>Подтверждение обмена</span>
			<?if($count_menu['confirm']['exchange']>0):?>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?=$count_menu['confirm']['exchange']?></span>
            </span>
			<?endif;?>
          </a> 
        </li>
		<?endif;?>
		<?if ($user->check_laws('confirmation/exchange_localbit')):?>
		<li  >
          <a href="/admin55/confirmation/exchange_localbit">
            <i class="fa fa-files-o"></i>
            <span>Подтверждение Localbit</span>
			<?if($count_menu['confirm']['exchange_localbit']>0):?>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?=$count_menu['confirm']['exchange_localbit']?></span>
            </span>
			<?endif;?>
          </a> 
        </li>
		<?endif;?>
		<?if ($user->check_laws('edit/Telegram_Exchange')):?>
		<li class="treeview">
          <a href="<?=$path?>#">
            <i class="fa fa-edit"></i> <span>Ручные заявки  </span>
			<?if($count_menu['confirm']['telegram_exchange']>0):?>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?=$count_menu['confirm']['telegram_exchange']?></span>
            </span>
			<?endif;?>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
				<li><a href="/admin55/Telegram_Exchange_Dashboard"><i class="fa fa-circle-o"></i>Главная</a></li> 
				<li><a href="/admin55/edit/Telegram_Exchange"><i class="fa fa-circle-o"></i>Заявки (<?=$count_menu['confirm']['telegram_exchange']?>)</a>
				
				</li> 
				
          </ul>
        </li>
		<?endif;?>
		<?if ($user->check_laws('edit')):?>
        <li class="treeview">
          <a href="<?=$path?>#">
            <i class="fa fa-edit"></i> <span>Редактор</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<?foreach ($editors as $k=>$v):?>
				<?if ($user->check_laws('edit/'.$k)):?>
				<li><a href="/admin55/edit/<?=$k?>"><i class="fa fa-circle-o"></i> <?=$v?></a></li> 
				<?endif;?>
			<?endforeach;?>
          </ul>
        </li>
		<?endif;?>
		<?if ($user->check_laws('logs')):?>
        <li class="treeview">
          <a href="<?=$path?>#">
            <i class="fa fa-edit"></i> <span>Логи</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<?foreach ($logs as $k=>$v):?>
				<li><a href="/admin55/logs/<?=$k?>"><i class="fa fa-circle-o"></i> <?=$v?></a></li> 
			<?endforeach;?>
          </ul>
        </li>
		<?endif;?>
		<?if ($user->check_laws('graph')):?>
        <li class="treeview">
          <a href="<?=$path?>#">
            <i class="fa fa-edit"></i> <span>Графики</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<?foreach ($graphs as $k=>$v):?>
				<li><a href="/admin55/graph/<?=$k?>"><i class="fa fa-circle-o"></i> <?=$v?></a></li> 
			<?endforeach;?>
          </ul>
        </li>
		<?endif;?>
	
      </ul>
	  <?endif;?>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Site</a></li>
         <li><a href="/admin55/"><i class="fa  "></i> Admin panel</a></li>
      </ol>
    </section>
	<section class="content">