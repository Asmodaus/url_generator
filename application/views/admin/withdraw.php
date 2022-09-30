<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include('header2.php');
?> 
<div class="cat__top-bar">
		<!-- left aligned items -->
		<div class="cat__top-bar__left">
			<div class="cat__top-bar__logo">
				<!-- <a href="dashboards-alpha.html">
					<img src="modules/dummy-assets/common/img/logo.png" />
				</a> -->
			</div>
			<div class="part_title fw_bold fz_20">Реферальная программа(обработанные) </div>
		</div>
		<!-- right aligned items -->
	</div>
	<div class="cat__content">
		<div class="card mb-3">
			<div class="card-body px-3 py-2 d-flex align-items-center">
				<p class="mb-0">This is some text <strong>122 123</strong></p>
				<button class="btn btn-danger ml-auto">Close</button>
			</div>
		</div>
		<div class="d-flex justify-content-end mb-3">
			<button class="btn mx-1 btn-success btn-sm">Поиск</button>
		</div>
		<div class="main_col row mx-n2">
			<div class="col-12 col_left_part px-2">
				<div class="row mx-n2">
        <?foreach ($confirmation_list as $row):
          ?>
					<div id="row<?=$row['id']?>" class="col-12 col-xl-6 px-2">
						<div class="card">
							<div class="card-header bg-success text-white py-1 d-flex align-items-center">
								<span><i class="fa fa-tag" aria-hidden="true"></i> Заявка <span>#<?=$row['id']?></span></span>
								<span class=" mx-auto">
									<a href="/admin55/edit/users/<?=$row['user_id']?>" class="text-white">
										<i class="fa fa-envelope" aria-hidden="true"></i>
										<span><?=$row['Us']->emai?></span>
									</a>
									<i class="fa fa-reply  fa-flip-horizontal ml-2 cur_p" data-placement="top"
									data-id="<?=$row['id']?>"	data-popover-content="#a1" data-toggle="popover-custom" tabindex="0"" aria-hidden="
										true"></i>
								</span>
								<p class="mb-0">
									<span class="d-block" data-toggle="tooltip" data-placement="left"
										title="дата начала создания"><?=date('d.m.Y H:i',$row['create_time'])?> </span>
								</p>
							</div>
							<div class="card-body">
								<div class="card-block">
									<div class="row">
										<div class="col">
											<div class="row">
												<div class="col">
													<div class="d-flex align-items-center pb-3">
														<div class="ico_label" data-placement="top" data-id="<?=$row['id']?>"	 data-popover-content="#walletInf"
															data-toggle="popover-custom" tabindex="0"" aria-hidden=" true"
															data-trigger="hover">
															<img src='/upload/<?=$row['to_valut']['img']?>' alt='' />
														</div>
														<div class="col pl-2 d-flex align-items-center">
															<strong class="pr-2" data-placement="top" data-popover-content="#walletInf" data-id="<?=$row['id']?>"	
																data-toggle="popover-custom" tabindex="0"" aria-hidden=" true"
																data-trigger="hover"><?=$row['to_valut']['name']?></strong>
														</div>
													</div>
													<ul class="list_inf list-unstyled mb-0">
														<li class="pb-1">
															<i class="fz_17"><?=$row['sum']?></i>
															<span class="text-uppercase text-danger fz_17"><?=$row['to_valut']['ticker']?></span> 
														</li>
														<li class="pb-1">
															<i class=""><?=$row['sum']?></i>
															<span class="text-black mx-1 cur_p" data-placement="top"
																data-popover-content="#editSum" data-toggle="popover-custom" data-id="<?=$row['id']?>"	
																tabindex="0"" aria-hidden=" true">
																<i class="fa fa-cog" aria-hidden="true"></i>
															</span> 
														</li>
													</ul> 
												</div>
												<div class="col">
													<div class="address">
														<span class="d-block text-muted">Кошелёк или email:</span>
														<span
															class="d-block word_wrpap"><?=$row['wallet']?></span>
													</div>
												</div>
											</div>
                      <?if($row['status']==2):?>
											<ul class="message_list list-unstyled mt-4 mb-0">
												<li class="d-flex">
													<span class="message_title bg-primary text-white">
														<i class="fa fa-money" aria-hidden="true"></i>
													</span>
													<div class="col pl-3">
														<div class="alert alert-light alert_corner">
															<p class="mb-0 text-gray"><span class="text-primary">Средства поступили
                              <?=date('d.m.Y H:i',$row['update_time'])?> |</span> Подтвердил <a href="/admin55/edit/users/<?=$row['user_confirm']?>"><?=row('users',$row['user_confirm'])['name']?></a>
															</p>
														</div>
													</div>
												</li>

											</ul>
                      <?endif;?>
										</div>
										<div class="col-auto">
                      <?if ($row['status']==1):?>
                     <button    OnClick="$(this).parent().remove();if (confirm('Вы уверены?')) ajax('admin_confirm/<?=$model_name?>/<?=$row['id']?>/accept','','#row<?=$row['id']?>');" class="btn btn-success"> Подтвердить</button>
											<button   OnClick="$(this).parent().remove();if (confirm('Вы уверены?')) ajax('admin_confirm/<?=$model_name?>/<?=$row['id']?>/decline','','#row<?=$row['id']?>');" class="btn btn-danger"> Отменить</button>
                      <?endif;?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
          <?endforeach;?>
				 
				</div>
			</div>
		</div>
	</div>
   
	<!-- popover for mail -->
	<div class="hidden d-none" id="a1">
		<div class="popover-heading">
			Иноформация о клиенте:
		</div>
		<div class="popover-body">
			<ul class="list-unstyled list_info_user">
				<li>
					<div class="l_part">ID</div>
					<div id="id" class="r_part">123123213</div>
				</li>
				<li>
					<div class="l_part">Группа</div>
					<div id="group" class="r_part">user</div>
				</li>
				<li>
					<div class="l_part">Дата регистрации</div>
					<div  id="register" class="r_part">12.12.1200</div>
				</li>
				<li>
					<div class="l_part">Количество рефералов</div>
					<div id="referal_count" class="r_part">0</div>
				</li>
				<li>
					<div class="l_part">Пригласитель</div>
					<div  id="ref_user"  class="r_part">-</div>
				</li>
				<li>
					<div class="l_part">Заработок с рефералов</div>
					<div id="referal_bonus" class="r_part"></div>
				</li>
				<li>
					<div class="l_part">Реферальный процент</div>
					<div id="referal_proc" class="r_part"></div>
				</li>
				<li>
					<div class="l_part">Скидка</div>
					<div id="discount" class="r_part">0%</div>
				</li>
				<li>
					<div class="l_part">Принято</div>
					<div id="sum_in" class="r_part"></div>
				</li>
				<li>
					<div class="l_part">Отдано</div>
					<div id="sum_out" class="r_part"></div>
				</li>
				<li>
					<div class="l_part">Количество заявок</div>
					<div class="r_part">
						<div id="buttons" class="small_btns">
							 
						</div>
					</div>
				</li>
				<li>
					<div class="l_part">Последний вход с IP</div>
					<div id="last_ip_access" class="r_part">-</div>
				</li>
				<li>
					<div class="l_part">Последняя заявка с IP</div>
					<div  id="last_ip_exchange" class="r_part">-</div>
				</li>
				<li>
					<div class="l_part">Активность</div>
					<div class="r_part">-</div>
				</li>
			</ul>
			<div class="popover_footer pt-3 pb-2 d-flex justify-content-end">
				<a class="btn btn-secondary btn-sm close_popover_js">Закрыть</a>
			</div>
		</div>
	</div>
   
	<!-- popover -->
	<div class="hidden d-none" id="editSum">
		<div class="popover-heading">
			Редактирование суммы к получению
		</div>
		<div class="popover-body">
			<div class="form-group">
				<input type="text" class="form-control" id="p1" placeholder="0" value="">
			</div>
			<div class="popover_footer pt-3 pb-2 d-flex justify-content-end">
				<a class="btn btn-success btn-md close_popover_js">Save</a>
			</div>
		</div>
	</div>
	<!-- popover -->
	<div class="hidden d-none" id="walletInf">
		<div class="popover-heading">
			Реквизиты получения
		</div>
		<div class="popover-body">
			<p class="mb-0">Коешлёк : <strong id="wallet"></strong></p>
		</div>
	</div>
   



 
 
</body>
</html>