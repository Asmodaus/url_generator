<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="<?=$path?>bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=$path?>css/my-login.css">
	  <script src="/js/system_js.js"></script>
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div style="    margin: auto;" class="card-wrapper">
					<div class="brand">
						<img src="<?=$path?>img/logo.jpg">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Login</h4>
							<form id="form-user_login" class="login-form" action="javascript:void(null);" method="post" OnSubmit="ajax_post('login',this,'#res-user_login');">
              
								<div class="form-group">
									<label for="email">E-Mail Address</label>

									<input id="email" type="email" class="form-control" name="email" value="" required autofocus>
								</div>

								<div class="form-group">
									<label for="password">Password 
									</label>
									<input id="password" type="password" class="form-control" name="password" required data-eye>
								</div>

								<div class="form-group">
									<label>
										<input type="checkbox" name="remember"> Remember Me
									</label>
								</div>
								 <div id="res-user_login"></div>
								<div class="form-group no-margin">
									<button type="submit" class="btn btn-primary btn-block">
										Login
									</button>
								</div>
								 
							</form>
						</div>
					</div>
					<div class="footer">
						Copyright &copy; Transcoin.me 2017
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="<?=$path?>js/jquery.min.js"></script>
	<script src="<?=$path?>bootstrap/js/bootstrap.min.js"></script>
	<script src="<?=$path?>js/my-login.js"></script>
</body>
</html>