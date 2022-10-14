<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Авторизация</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Alumni+Sans:wght@700&family=Inter:wght@400;500&display=swap"
		rel="stylesheet">

	<link rel="stylesheet" href="<?=$path?>css/custom_bootstrap.css">
	<link rel="stylesheet" href="<?=$path?>css/libs.min.css">
	<link rel="stylesheet" href="<?=$path?>css/all.css">
</head>

<body>
	<div class="home_page d-flex  align-items-center justify-content-center">
		<form   action="javascript:void(null);" method="post" OnSubmit="ajax_post('login',this,'#res_user_login');">
              
			<div class="enter_panel panel p-5">
				<h4 class="text-center mb-4 bold_font fz_30">ВОЙТИ</h4>
				<div class="form-group">
					<input type="email" class="form-control" name="email" id="f1" required autofocus placeholder="Логин (почта)">
				 
				</div>
				<div class="form-group">
					<div class="input_holder input_holder_js">
						<input type="password"  required data-eye name="password" class="form-control pr-5" id="password_field" placeholder="Пароль">
						<span class="ico"><i class="far fa-fw fa-eye toggle_password_js" toggle="#password_field"></i> </span>
					</div>
					<div id="res_user_login" style="    display: block;" class="invalid-feedback  fz_10">
					 
					</div>
				</div>
				<div class="text-center pt-4">
					<button type="submit" class="btn btn-danger px-4">Войти</button>
				</div>
			</div>
		</form>	
	</div>
	<script src="<?=$path?>js/jquery.min.js"></script>
	<script src="<?=$path?>js/bootstrap.bundle.min.js"></script>
	<script src="<?=$path?>js/main.js"></script>
	<script src="/js/system_js.js"></script>
</body>

</html>