<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Шаблонизатор UTM </title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Alumni+Sans:wght@700&family=Inter:wght@400;500;700&display=swap"
		rel="stylesheet">

	<link rel="stylesheet" href="<?=$path?>css/custom_bootstrap.css">
	<link rel="stylesheet" href="<?=$path?>css/libs.min.css">
	<link rel="stylesheet" href="<?=$path?>css/all.css">

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
  
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
</head>

<body>
	<div class="wrapper">
		<div class="header bg-light_green px-3">
			<div class="centered d-flex align-items-center">
				<strong class="logo"><a href="#"><img src="images/logo.svg" alt=""></a></strong>
				<ul class="main_nav list-unstyled mb-0 d-flex align-items-center flex-wrap col justify-content-center">
                    <li><a href="/generator">Генератор</a></li>	
                    <li><a href="/links">Архив</a></li> 
				</ul>
				<div class="d-flex align-items-center">
					<span class="mr-2 admin_ico">
						<a href="#">
							<svg width="30" height="31" viewBox="0 0 30 31" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect y="0.5" width="30" height="30" rx="5" fill="#F79788" />
								<path
									d="M24 16.1C23.9 16.1 23.7 16.2 23.6 16.3L22.6 17.3L24.7 19.4L25.7 18.4C25.9 18.2 25.9 17.8 25.7 17.6L24.4 16.3C24.3 16.2 24.2 16.1 24 16.1ZM22.1 17.9L16 23.9V26H18.1L24.2 19.9L22.1 17.9ZM24 6H16V12H24V6ZM22 10H18V8H22V10ZM16 21.06V14H24V14.1C23.24 14.1 22.57 14.5 22.19 14.89L21.07 16H18V19.07L16 21.06ZM14 6H6V16H14V6ZM12 14H8V8H12V14ZM14 23.06V18H6V24H14V23.06ZM12 22H8V20H12V22Z"
									fill="#37545F" />
							</svg>
						</a>
					</span>
					<div class="dropdown dropdown_custom">
						<div class="btn text-left d-flex align-items-center" data-toggle="dropdown" aria-expanded="false">

							<span class="photo_user">
								<img src="<?=$path?>images/icon.svg" alt="" class="img-fluid">
							</span>
							<div class="txt_info pl-3 col pr-0">
								<span class="d-block bold_font  text-truncate"><?=$user->email?></span>
								<span class="d-block fz_12 text-truncate"><?=$user->name?></span>
							</div>
						</div>
                        <?if($user->user_type_id==6):?>
						<div class="dropdown-menu bg-dark_green">
							<a class="dropdown-item" href="/admin55/edit/users">Пользователи</a>
							<a class="dropdown-item" href="/admin55/edit/user_type">Управление ролями</a>
							<a class="dropdown-item" href="/admin55/edit/user_log">Лог пользователей</a>
							<a class="dropdown-item" href="/admin55/edit/template">Настройка шаблонов</a>
						</div>
                        <?endif;?>
					</div>
					<a href="/logout" class="btn btn-danger ml-2 px-3 btn-sm">Выйти</a>
				</div>
			</div>
		</div>
        
        
        
         
  