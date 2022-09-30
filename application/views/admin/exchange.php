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
			<div class="part_title fw_bold fz_20">Title of page</div>
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
			<button class="btn mx-1 btn-primary btn-sm">Создать новую</button>
			<button class="btn mx-1 btn-success btn-sm">Поиск заявок</button>
		</div>
		<div class="main_col row mx-n2">
			<div class="col-12 col_left_part px-2">
				<div class="col_title d-flex justify-content-between mb-2">
					<span class="pr-2">Отображено 1 из 1</span>
					<a href="#" class="">Отображать по 10 заявок</a>
				</div>
				<nav class="mb-3">
					<ul class="pagination pagination-sm mb-0">
						<!-- <li class="page-item disabled">
							<a class="page-link">Previous</a>
						</li> -->
						<li class="page-item"><a class="page-link" href="#">1</a></li>
						<li class="page-item active" aria-current="page">
							<a class="page-link" href="#">2</a>
						</li>
						<li class="page-item"><a class="page-link" href="#">3</a></li>
						<li class="page-item"><a class="page-link" href="#">4</a></li>
						<li class="page-item"><a class="page-link" href="#">5</a></li>
						<li class="page-item"><a class="page-link" href="#">6</a></li>
						<li class="page-item"><a class="page-link" href="#">7</a></li>
						<li class="page-item"><a class="page-link" href="#">...</a></li>
						<li class="page-item"><a class="page-link" href="#">70</a></li>
						<!-- <li class="page-item">
							<a class="page-link" href="#">Next</a>
						</li> -->
					</ul>
				</nav>
				<div class="card">
					<div class="card-header bg-primary text-white py-1 d-flex align-items-center">
						<span><i class="fa fa-tag" aria-hidden="true"></i> Заявка <span>№1324123</span></span>

						<span class=" mx-auto">
							<a href="#" class="text-white">
								<i class="fa fa-envelope" aria-hidden="true"></i>
								<span>asd@gmail.com</span>
							</a>
							<i class="fa fa-info-circle ml-2 cur_p" data-placement="top" data-popover-content="#a1"
								data-toggle="popover-custom" tabindex="0"" aria-hidden=" true"></i>
						</span>
						<p class="mb-0">
							<span class="d-block" data-toggle="tooltip" data-placement="left"
								title="дата начала создания">22.22.2000 в 12:12:00 </span>
							<span class="d-block" data-toggle="tooltip" data-placement="left" title="дата завершения создания">
								22.22.22000 в 12:12:00</span>
						</p>
					</div>
					<div class="card-body">

						<div class="card-block">
							<div class="row">
								<div class="col">
									<div class="row">
										<div class="col">
											<div class="d-flex align-items-center pb-3">
												<div class="ico_label" data-placement="top" data-popover-content="#walletInf"
													data-toggle="popover-custom" tabindex="0"" aria-hidden=" true"
													data-trigger="hover">
													<img src='img/example.jpg' alt='' />
												</div>
												<div class="col pl-2 d-flex align-items-center">
													<strong class="pr-2" data-placement="top" data-popover-content="#walletInf"
														data-toggle="popover-custom" tabindex="0"" aria-hidden=" true"
														data-trigger="hover">Visa/MasterCard</strong>
													<ul class="list-unstyled mb-0 d-flex align-content-center">
														<li class="mx-1">
															<a href="#" class="text-black fz_18" data-popover-content="#requisites"
																data-toggle="popover-custom" tabindex="0"" aria-hidden=" true"
																data-trigger="hover" title="Проверить">
																<i class="fa fa-binoculars" aria-hidden="true"
																	data-popover-content="#requisitesCheck" data-toggle="popover-custom"
																	tabindex="0"" aria-hidden=" true" data-placement="bottom"
																	data-trigger="focus"></i>
															</a>
														</li>
													</ul>
												</div>
											</div>
											<ul class="list_inf list-unstyled mb-0">
												<li class="pb-1">
													<i class="fz_17">90</i>
													<span class="text-uppercase text-danger fz_17">usdt</span>
													<em class="text-muted">123123.12 $</em>
												</li>
												<li class="pb-1">
													<i class="">90</i>
													<span class="text-black mx-1 cur_p" data-placement="top"
														data-popover-content="#editSum" data-toggle="popover-custom"
														tabindex="0"" aria-hidden=" true">
														<i class="fa fa-cog" aria-hidden="true"></i>
													</span>
													<span class="text-uppercase text-danger ">usdt</span>
												</li>
												<li class="pb-1">
													<i class="">0</i>
													<span class="text-black mx-1 cur_p" data-placement="top"
														data-popover-content="#editSumVal" data-toggle="popover-custom"
														tabindex="0"" aria-hidden=" true">
														<i class="fa fa-cog" aria-hidden="true"></i>
													</span>
													<span class="text-uppercase text-danger ">usd</span>
												</li>
											</ul>
											<div class="address">
												<span class="d-block text-muted">Карта:</span>
												<span class="d-block word_wrpap">12312312312312312312312312312312312312312313</span>
											</div>
										</div>
										<div class="col-auto px-4 col_arrow">
											<i class="fa fa-arrow-right text-muted " aria-hidden="true"></i>
										</div>
										<div class="col">
											<div class="d-flex align-items-center pb-3">
												<div class="ico_label">
													<img src='img/example.jpg' alt='' />
												</div>
												<div class="col pl-2 d-flex align-items-center">
													<strong class="pr-2">Visa/MasterCard</strong>
													<ul class="list-unstyled mb-0 d-flex align-content-center">
														<li class="mx-1">
															<a href="#" class="text-black ">
																<i class="fa fa-cc-visa" aria-hidden="true"></i>
															</a>
														</li>
														<li class="mx-1">
															<a href="#" class="text-black ">
																<i class="fa fa-credit-card-alt" aria-hidden="true"></i>
															</a>
														</li>
														<li class="mx-1">
															<a href="#" class="text-black ">
																<i class="fa fa-university" aria-hidden="true"></i>
															</a>
														</li>
													</ul>
												</div>
											</div>
											<ul class="list_inf list-unstyled mb-0">
												<li class="pb-1">
													<i class="fz_17">90</i>
													<span class="text-uppercase text-purple fz_17">usdt</span>
													<em class="text-muted">123123.12 $</em>
												</li>
												<li class="pb-1">
													<i class="text-update">-90</i>
													<span class="text-black mx-1 cur_p" data-placement="top"
														data-popover-content="#editSum" data-toggle="popover-custom"
														tabindex="0"" aria-hidden=" true">
														<i class="fa fa-cog" aria-hidden="true"></i>
													</span>
													<span class="text-uppercase text-danger ">usdt</span>
												</li>
												<li class="pb-1">
													<i class="">0</i>
													<span class="text-black mx-1 cur_p" data-placement="top"
														data-popover-content="#editSumVal" data-toggle="popover-custom"
														tabindex="0"" aria-hidden=" true">
														<i class="fa fa-cog" aria-hidden="true"></i>
													</span>
													<span class="text-uppercase text-danger ">usd</span>
												</li>
											</ul>
											<div class="address">
												<span class="d-block text-muted">Карта:</span>
												<span class="d-block word_wrpap">12312312312312312312312312312312312312312313</span>
											</div>
										</div>
									</div>
									<ul class="message_list list-unstyled mt-4">
										<li class="d-flex">
											<span class="message_title bg-primary text-white">
												<i class="fa fa-money" aria-hidden="true"></i>
											</span>
											<div class="col pl-3">
												<div class="alert alert-light alert_corner">
													<p class="mb-0 text-gray"><span class="text-primary">Средства поступили
															09-09-2222 в 12:12:11 |</span> Подтвердил <a href="#">username</a></p>
												</div>
											</div>
										</li>
										<li class="d-flex">
											<span class="message_title bg-success text-white">
												<i class="fa fa-download" aria-hidden="true"></i>
											</span>
											<div class="col pl-3 mw_500">
												<div class="alert alert-success alert_corner">
													<ul class="list-unstyled mb-0">
														<li><a href="#">some text = some text</a></li>
														<li><a href="#">some text some text</a></li>
														<li><a href="#">some text some text</a></li>
														<li><a href="#">some text some text</a></li>
													</ul>
												</div>
											</div>
										</li>
										<li class="d-flex">
											<span class="message_title bg-update text-white">
												<i class="fa fa-comments-o" aria-hidden="true"></i>
											</span>
											<div class="col pl-3">
												<div class="alert alert-update alert_corner">
													<p class="mb-0">кто-то пиздит бабки...</p>
												</div>
											</div>
										</li>
										<li class="d-flex">
											<span class="message_title text-white">
												<i class="fa fa-telegram" aria-hidden="true"></i>
											</span>
											<div class="col pl-3">
												<div class="alert alert-white alert_corner">
													<ul class="list-unstyled mb-0">
														<li><a href="#">adasd asdasd asdasd</a></li>
														<li><a href="#">adasd asdasd asdasd</a></li>
														<li><a href="#">adasd asdasd asdasd</a></li>
														<li>text</li>
													</ul>
												</div>
											</div>
										</li>
									</ul>
								</div>
								<div class="col-12 col_function">
									<div class="list-group">
										<a href="#" class="list-group-item list-group-item-action ">
											<i class="fa fa-snowflake-o mr-2  fa-fw" aria-hidden="true"></i> В замороженные
										</a>
										<a href="#" class="list-group-item list-group-item-action ">
											<i class="fa fa-external-link mr-2  fa-fw" aria-hidden="true"></i> В предварительные
										</a>
										<a href="#" class="list-group-item list-group-item-action ">
											<i class="fa fa-pencil mr-2  fa-fw" aria-hidden="true"></i> Редактировать
										</a>
										<a href="#" class="list-group-item list-group-item-action ">
											<i class="fa fa-square-o mr-2  fa-fw" aria-hidden="true"></i> Тестовая
										</a>
										<a href="#" class="list-group-item list-group-item-action" data-placement="top"
											data-popover-content="#editLabel" data-toggle="popover-custom"
											tabindex="0"" aria-hidden=" true">
											<i class="fa  mr-2 fa-bookmark fa-fw" aria-hidden="true"></i> Метка
										</a>
										<a href="#" class="list-group-item list-group-item-action ">
											<i class="fa fa-comments-o mr-2  fa-fw" aria-hidden="true"></i> Комментарий
										</a>
										<a href="#" class="list-group-item list-group-item-action ">
											<i class="fa fa-telegram mr-2  fa-fw" aria-hidden="true"></i> Сообщение
										</a>
									</div>
								</div>
							</div>
							<div class="card_footer row align-items-center">
								<div class="col d-flex flex-wrap align-items-center list_footer">
									<button class="btn btn-light py-1 px-3" data-placement="top" data-popover-content="#course"
										data-toggle="popover-custom" tabindex="0"" aria-hidden=" true" data-trigger="focus">
										<i class="fa fa-bar-chart" aria-hidden="true"></i>
									</button>
									<button class="btn btn-light py-1 px-3" data-toggle="modal" data-target="#history">
										<i class="fa fa-pencil" aria-hidden="true"></i>
									</button>
									<button class="btn btn-light py-1 px-3" data-placement="top"
										data-popover-content="#requestInfo" data-toggle="popover-custom"
										tabindex="0"" aria-hidden=" true">
										<i class="fa fa-money" aria-hidden="true"></i>
									</button>
									<i class="fa fa-desktop" aria-hidden="true" data-toggle="tooltip" data-placement="top"
										title="Комп"></i>
									<i class="fa fa-sitemap text-success" aria-hidden="true" aria-hidden="true"
										data-toggle="tooltip" data-placement="top" title="Заявка с сайта"></i>
									<a href="#" target="_blank" aria-hidden="true" aria-hidden="true" data-toggle="tooltip"
										data-placement="top" title="Заявки клиента">
										<i class="fa fa-check-circle fz_17" aria-hidden="true"></i>
										12
									</a>
									<span data-toggle="tooltip" data-placement="top" title="%">
										<i class="fa fa-folder-open" aria-hidden="true" aria-hidden="true" aria-hidden="true"></i>
										13
									</span>
									<span data-toggle="tooltip" data-placement="top" title="Lang"><i class="fa fa-language"
											aria-hidden="true"></i> En</span>
									<a href="#" target="_blank" data-toggle="tooltip" data-placement="top" title="IP">
										<i class="fa fa-globe" aria-hidden="true"></i>
										127.0.0.1:5500
									</a>
									<span data-placement="top" data-popover-content="#discount" data-toggle="popover-custom"
										tabindex="0"" aria-hidden=" true">
										<i class="fa fa-exchange" aria-hidden="true"></i>
										<button class="btn btn-link py-0 px-2">0 USDT (%)</button>
									</span>
									<a href="#" target="_blank" data-toggle="tooltip" data-placement="top"
										title="ссылка на оплату">
										<i class="fa fa-shopping-cart" aria-hidden="true"></i>
										счёт
									</a>
								</div>
								<div class="col-auto px-3">
									<strong class="text-success fz_20">213123 $</strong>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 fix_right px-2">
				<div class="card">
					<div class="card-body p-0">
						<ul class="nav nav-tabs nav_tabs" role="tablist">
							<li class="nav-item" role="presentation">
								<button class="nav-link " data-toggle="tab" data-target="#tab_1" type="button" role="tab"
									aria-selected="false">
									<i class="fa fa-line-chart" aria-hidden="true"></i>
								</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link active" data-toggle="tab" data-target="#tab_2" type="button" role="tab"
									aria-selected="true">
									<i class="fa fa-usd" aria-hidden="true"></i>
								</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link " data-toggle="tab" data-target="#tab_3" type="button" role="tab"
									aria-selected="false">
									<i class="fa fa-money" aria-hidden="true"></i>
								</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" data-toggle="tab" data-target="#tab_4" type="button" role="tab"
									aria-selected="false">
									<i class="fa fa-exchange" aria-hidden="true"></i>
								</button>
							</li>
						</ul>
						<div class="tab-content tab_content">
							<div class="tab-pane fade" id="tab_1">
								1
							</div>
							<div class="tab-pane fade p-0 show active" id="tab_2">
								<div class="table-responsive">
									<table class="table table-hover table_cstm">
										<thead>
											<tr>
												<th class="pl-5">Направление</th>
												<th>Сумма</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="pl-5">
													<a href="#" class="toggle_show toggle_show_js">
														<i class="fa fa-plus-circle" aria-hidden="true"></i>
													</a>
													<div class="d-flex align-items-center">
														<div class="ico_label">
															<img src="img/example.jpg" alt="" class="rounded-circle">
														</div>
														<div class="pl-2 txt col">
															<span>Bitcoin Money USD</span>
														</div>
													</div>
													<span class="data pt-1 d-block fz_11 text-muted">12.12.1222 22:12:01</span>
												</td>
												<td>
													<span class="text-muted">123123 USD</span>
												</td>
												<td class="text-right">
													<a href="#"><i class="fa fa-refresh" aria-hidden="true"></i></a>
												</td>
											</tr>
											<tr class="d-none more_info">
												<td colspan="3" class="pl-3">
													<p class="mb-2">123123 123123 $</p>
													<p class="mb-2">123123 $</p>
												</td>
											</tr>
											<tr>
												<td class="pl-5">
													<div class="d-flex align-items-center">
														<div class="ico_label">
															<img src="img/example.jpg" alt="" class="rounded-circle">
														</div>
														<div class="pl-2 txt col">
															<span>Bitcoin Money USD</span>
														</div>
													</div>
													<span class="data pt-1 d-block fz_11 text-muted">12.12.1222 22:12:01</span>
												</td>
												<td>
													<span class="text-muted">123123 USD</span>
												</td>
												<td class="text-right">
													<a href="#"><i class="fa fa-refresh" aria-hidden="true"></i></a>
												</td>
											</tr>
											<tr>
												<td class="pl-5">
													<a href="#" class="toggle_show toggle_show_js">
														<i class="fa fa-plus-circle" aria-hidden="true"></i>
													</a>
													<div class="d-flex align-items-center">
														<div class="ico_label">
															<img src="img/example.jpg" alt="" class="rounded-circle">
														</div>
														<div class="pl-2 txt col">
															<span>Bitcoin Money USD</span>
														</div>
													</div>
													<span class="data pt-1 d-block fz_11 text-muted">12.12.1222 22:12:01</span>
												</td>
												<td>
													<span class="text-muted">123123 USD</span>
												</td>
												<td class="text-right">
													<a href="#"><i class="fa fa-refresh" aria-hidden="true"></i></a>
												</td>
											</tr>
											<tr class="d-none more_info">
												<td colspan="3" class="pl-3">
													Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eos nulla debitis sunt,
													perferendis dolor modi voluptate voluptatem dolorem necessitatibus ea amet
													commodi temporibus. Perferendis reiciendis doloremque perspiciatis quod
													consectetur necessitatibus.
												</td>
											</tr>
											<tr>
												<td class="pl-5">
													<div class="d-flex align-items-center">
														<div class="ico_label">
															<img src="img/example.jpg" alt="" class="rounded-circle">
														</div>
														<div class="pl-2 txt col">
															<span>Bitcoin Money USD</span>
														</div>
													</div>
													<span class="data pt-1 d-block fz_11 text-muted">12.12.1222 22:12:01</span>
												</td>
												<td>
													<span class="text-muted">123123 USD</span>
												</td>
												<td class="text-right">
													<a href="#"><i class="fa fa-refresh" aria-hidden="true"></i></a>
												</td>
											</tr>
											<tr>
												<td class="pl-5">
													<div class="d-flex align-items-center">
														<div class="ico_label">
															<img src="img/example.jpg" alt="" class="rounded-circle">
														</div>
														<div class="pl-2 txt col">
															<span>Bitcoin Money USD</span>
														</div>
													</div>
													<span class="data pt-1 d-block fz_11 text-muted">12.12.1222 22:12:01</span>
												</td>
												<td>
													<span class="text-muted">123123 USD</span>
												</td>
												<td class="text-right">
													<a href="#"><i class="fa fa-refresh" aria-hidden="true"></i></a>
												</td>
											</tr>
											<tr>
												<td class="pl-5">
													<div class="d-flex align-items-center">
														<div class="ico_label">
															<img src="img/example.jpg" alt="" class="rounded-circle">
														</div>
														<div class="pl-2 txt col">
															<span>Bitcoin Money USD</span>
														</div>
													</div>
													<span class="data pt-1 d-block fz_11 text-muted">12.12.1222 22:12:01</span>
												</td>
												<td>
													<span class="text-muted">123123 USD</span>
												</td>
												<td class="text-right">
													<a href="#"><i class="fa fa-refresh" aria-hidden="true"></i></a>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="tab-pane fade pt-2 " id="tab_3">
								<div class="btn-group pb-2" role="group">
									<button type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown"
										aria-expanded="false">
										Приходы/Расходы
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item" href="#" data-toggle="modal" data-target="#addModal">Приходы</a>
										<a class="dropdown-item" href="#" data-toggle="modal" data-target="#addModal">Расходы</a>
									</div>
								</div>

								<table class="display table table_js" style="width:100%">
									<thead>
										<tr>
											<th class="fz_12">Дата</th>
											<th class="fz_12">Тип операции</th>
											<th class="fz_12">Сумма</th>
											<th class="fz_12">Операции</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="fz_12">31.12.2000 13:14:00</td>
											<td class="fz_12">Зарплата</td>
											<td class="fz_12">-123123 $</td>
											<td>
												<a href="#" class="fz_17 check_btn_js">
													<i class="fa fa-check-circle" aria-hidden="true"></i>
												</a>
												<a href="#" data-toggle="modal" data-target="#exampleModal" class="fz_17">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</td>
										</tr>
										<tr>
											<td class="fz_12">1.12.1999 13:14:00</td>
											<td class="fz_12">Сервера</td>
											<td class="text-success fz_12">+12 $</td>
											<td>
												<a href="#" class="fz_17 check_btn_js">
													<i class="fa fa-check-circle" aria-hidden="true"></i>
												</a>
												<a href="#" data-toggle="modal" data-target="#exampleModal" class="fz_17">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</td>
										</tr>
										<tr>
											<td class="fz_12">10.12.1999 13:14:00</td>
											<td class="fz_12">Прочие расходы</td>
											<td class="text-danger fz_12">-12 $</td>
											<td>
												<a href="#" class="fz_17 check_btn_js">
													<i class="fa fa-check-circle" aria-hidden="true"></i>
												</a>
												<a href="#" data-toggle="modal" data-target="#exampleModal" class="fz_17">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</td>
										</tr>
										<tr>
											<td class="fz_12">10.12.1999 13:14:00</td>
											<td class="fz_12">Прочие расходы</td>
											<td class="text-danger fz_12">-12 $</td>
											<td>
												<a href="#" class="fz_17 check_btn_js">
													<i class="fa fa-check-circle" aria-hidden="true"></i>
												</a>
												<a href="#" data-toggle="modal" data-target="#exampleModal" class="fz_17">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</td>
										</tr>
										<tr>
											<td class="fz_12">10.12.1999 13:14:00</td>
											<td class="fz_12">Прочие расходы</td>
											<td class="text-danger fz_12">-12 $</td>
											<td>
												<a href="#" class="fz_17 check_btn_js">
													<i class="fa fa-check-circle" aria-hidden="true"></i>
												</a>
												<a href="#" data-toggle="modal" data-target="#exampleModal" class="fz_17">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</td>
										</tr>
										<tr>
											<td class="fz_12">10.12.1999 13:14:00</td>
											<td class="fz_12">Прочие расходы</td>
											<td class="text-danger fz_12">-12 $</td>
											<td>
												<a href="#" class="fz_17 check_btn_js">
													<i class="fa fa-check-circle" aria-hidden="true"></i>
												</a>
												<a href="#" data-toggle="modal" data-target="#exampleModal" class="fz_17">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="tab-pane fade" id="tab_4">
								4
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h5 class="modal-title" id="exampleModalLabel">Информация об операции</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Тип операции: Зарплата</p>
					<p>Комментарий:</p>
					<p>ЗП 123123123</p>
					<p>Кошелёк: <img src="img/example.jpg" class="mw_20" alt=""> +095-132-123-23</p>
					<p>Сумма: <span class="text-danger">-123123 $</span></p>
					<p>Пользователь: <a href="#">@username</a></p>
					<p>Дат: 12-12-2022 13:23:00</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h5 class="modal-title" id="exampleModalLabel">Добавление прихода</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row align-items-end">
						<div class="col-6">
							<div class="form-group">
								<label>Расход или приход</label>
								<select class="selectpicker d-flex" data-width="100%" disabled>
									<option>Расход</option>
									<option>Приход</option>
								</select>
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label>Тип операции</label>
								<select class="selectpicker d-flex" data-live-search="true" data-width="100%"
									title="Выберите тип операции">
									<option>Mustard</option>
									<option>Ketchup</option>
									<option>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam consequatur eos,
										ipsam quaerat quia nihil sit corrupti voluptatibus fuga nisi! Repellat quasi minima
										excepturi ea. Quisquam harum numquam adipisci accusamus!</option>
								</select>
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<select class="selectpicker d-flex" data-live-search="true" data-width="100%"
									title="Выберите тип операции">
									<option>Mustard</option>
									<option>Ketchup</option>
									<option>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam consequatur eos,
										ipsam quaerat quia nihil sit corrupti voluptatibus fuga nisi! Repellat quasi minima
										excepturi ea. Quisquam harum numquam adipisci accusamus!</option>
								</select>
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label for="f1">Сумма</label>
								<input type="text" class="form-control" id="f1" placeholder="">
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label for="g1">Коменнтарий</label>
								<textarea class="form-control" id="g1" rows="3"></textarea>
							</div>
						</div>
					</div>
					<div class="label pt-3">Выберите кошелёк</div>
					<table class="display table table-vertical-middle   unsearch_table_js" style="width:100%">
						<thead>
							<tr>
								<th class="fz_12"></th>
								<th class="fz_12">Название</th>
								<th class="fz_12">Резерв</th>
								<th class="fz_12">Обороты в день</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="fz_12">
									<div class="custom_radio">
										<label class="mb-0 d-block">
											<input type="radio" class="custom-control-input  " name="radio-stacked">
											<em></em>
										</label>
									</div>
								</td>
								<td class="fz_12">
									<div class="d-flex align-items-center">
										<div class="ico_label">
											<img src="img/example.jpg" alt="">
										</div>
										<div class="pl-2 txt col ">
											<span>3121231231231231231212312312</span>
										</div>
									</div>
								</td>
								<td class="fz_12">
									12312312
								</td>
								<td class="fz_12">
									<p class="mb-0">
										<span class="text-success"><i class="fa fa-chevron-up" aria-hidden="true"></i>12</span>
										<span class="text-danger">
											<i class="fa fa-chevron-down" aria-hidden="true"></i>
											121212</span>
									</p>
								</td>
							</tr>
							<tr>
								<td class="fz_12">
									<div class="custom_radio">
										<label class="mb-0 d-block">
											<input type="radio" class="custom-control-input  " name="radio-stacked">
											<em></em>
										</label>
									</div>
								</td>
								<td class="fz_12">
									<div class="d-flex align-items-center">
										<div class="ico_label">
											<img src="img/example.jpg" alt="">
										</div>
										<div class="pl-2 txt col ">
											<span>132324234234324k32j4kj23lk4jlk23j4k23klj4lk23j4lkj23lk4j</span>
										</div>
									</div>
								</td>
								<td class="fz_12">
									12312312
								</td>
								<td class="fz_12">
									<p class="mb-0">
										<span class="text-success"><i class="fa fa-chevron-up" aria-hidden="true"></i>12</span>
										<span class="text-danger">
											<i class="fa fa-chevron-down" aria-hidden="true"></i>
											121212</span>
									</p>
								</td>
							</tr>
							<tr>
								<td class="fz_12">
									<div class="custom_radio">
										<label class="mb-0 d-block">
											<input type="radio" class="custom-control-input  " name="radio-stacked">
											<em></em>
										</label>
									</div>
								</td>
								<td class="fz_12">
									<div class="d-flex align-items-center">
										<div class="ico_label">
											<img src="img/example.jpg" alt="">
										</div>
										<div class="pl-2 txt col ">
											<span>132324234234324k32j4kj23lk4jlk23j4k23klj4lk23j4lkj23lk4j</span>
										</div>
									</div>
								</td>
								<td class="fz_12">
									43
								</td>
								<td class="fz_12">
									<p class="mb-0">
										<span class="text-success"><i class="fa fa-chevron-up" aria-hidden="true"></i>12</span>
										<span class="text-danger">
											<i class="fa fa-chevron-down" aria-hidden="true"></i>
											121212</span>
									</p>
								</td>
							</tr>
							<tr>
								<td class="fz_12">
									<div class="custom_radio">
										<label class="mb-0 d-block">
											<input type="radio" class="custom-control-input  " name="radio-stacked">
											<em></em>
										</label>
									</div>
								</td>
								<td class="fz_12">
									<div class="d-flex align-items-center">
										<div class="ico_label">
											<img src="img/example.jpg" alt="">
										</div>
										<div class="pl-2 txt col ">
											<span>132324234234324k32j4kj23lk4jlk23j4k23klj4lk23j4lkj23lk4j</span>
										</div>
									</div>
								</td>
								<td class="fz_12">
									12
								</td>
								<td class="fz_12">
									<p class="mb-0">
										<span class="text-success"><i class="fa fa-chevron-up" aria-hidden="true"></i>12</span>
										<span class="text-danger">
											<i class="fa fa-chevron-down" aria-hidden="true"></i>
											121212</span>
									</p>
								</td>
							</tr>
							<tr>
								<td class="fz_12">
									<div class="custom_radio">
										<label class="mb-0 d-block">
											<input type="radio" class="custom-control-input  " name="radio-stacked">
											<em></em>
										</label>
									</div>
								</td>
								<td class="fz_12">
									<div class="d-flex align-items-center">
										<div class="ico_label">
											<img src="img/example.jpg" alt="">
										</div>
										<div class="pl-2 txt col ">
											<span>132324234234324k32j4kj23lk4jlk23j4k23klj4lk23j4lkj23lk4j</span>
										</div>
									</div>
								</td>
								<td class="fz_12">
									3
								</td>
								<td class="fz_12">
									<p class="mb-0">
										<span class="text-success"><i class="fa fa-chevron-up" aria-hidden="true"></i>1200</span>
										<span class="text-danger">
											<i class="fa fa-chevron-down" aria-hidden="true"></i>
											121212</span>
									</p>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-success" data-dismiss="modal">Save</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="history" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h5 class="modal-title" id="exampleModalLabel">История изменений</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<ul class="message_list list-unstyled mt-4">
						<li class="d-flex">
							<span class="message_title text-white">
								<i class="fa fa-pencil" aria-hidden="true"></i>
							</span>
							<div class="col pl-3">
								<div class="alert alert-light alert_corner">
									<p class="text-success mb-2">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
										Praesentium ratione ipsa nulla assumenda quas dolorum unde quae </p>
									<p class="text-success mb-2">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
										Praesentium ratione ipsa nulla assumenda quas dolorum unde quae </p>
									<p class="mb-0 text-gray"> Автор <a href="#">username</a> 12.12.2222 12:00:12</p>
								</div>
							</div>
						</li>
						<li class="d-flex">
							<span class="message_title text-white">
								<i class="fa fa-pencil" aria-hidden="true"></i>
							</span>
							<div class="col pl-3">
								<div class="alert alert-light alert_corner">
									<p class="text-success mb-2">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
										Praesentium ratione ipsa nulla assumenda quas dolorum unde quae </p>
									<p class="text-success mb-2">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
										Praesentium ratione ipsa nulla assumenda quas dolorum unde quae </p>
									<p class="mb-0 text-gray"> Автор <a href="#">username</a> 12.12.2222 12:00:12</p>
								</div>
							</div>
						</li>
						<li class="d-flex">
							<span class="message_title text-white">
								<i class="fa fa-pencil" aria-hidden="true"></i>
							</span>
							<div class="col pl-3">
								<div class="alert alert-light alert_corner">
									<p class="text-success mb-2">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
										Praesentium ratione ipsa nulla assumenda quas dolorum unde quae </p>
									<p class="text-success mb-2">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
										Praesentium ratione ipsa nulla assumenda quas dolorum unde quae </p>
									<p class="mb-0 text-gray"> Автор <a href="#">username</a> 12.12.2222 12:00:12</p>
								</div>
							</div>
						</li>

					</ul>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
					<div class="r_part">123123213</div>
				</li>
				<li>
					<div class="l_part">Группа</div>
					<div class="r_part"><a href="#">user</a></div>
				</li>
				<li>
					<div class="l_part">Дата регистрации</div>
					<div class="r_part">12.12.1200</div>
				</li>
				<li>
					<div class="l_part">Количество рефералов</div>
					<div class="r_part">0</div>
				</li>
				<li>
					<div class="l_part">Пригласитель</div>
					<div class="r_part">-</div>
				</li>
				<li>
					<div class="l_part">Заработок с рефералов</div>
					<div class="r_part">123123$</div>
				</li>
				<li>
					<div class="l_part">Реферальный процент</div>
					<div class="r_part">2222$</div>
				</li>
				<li>
					<div class="l_part">Скидка</div>
					<div class="r_part">.005%</div>
				</li>
				<li>
					<div class="l_part">Принято</div>
					<div class="r_part">123</div>
				</li>
				<li>
					<div class="l_part">Отдано</div>
					<div class="r_part">123123123</div>
				</li>
				<li>
					<div class="l_part">Количество заявок</div>
					<div class="r_part">
						<div class="small_btns">
							<a href="#" target="_blank" class="btn btn-danger btn-sm fz_10" title="123213">100</a>
							<a href="#" target="_blank" class="btn btn-primary btn-sm fz_10">1</a>
							<a href="#" target="_blank" class="btn btn-warning btn-sm fz_10">1</a>
							<a href="#" target="_blank" class="btn btn-success btn-sm  fz_10">1</a>
							<a href="#" target="_blank" class="btn btn-info btn-sm fz_10">1</a>
							<a href="#" target="_blank" class="btn btn-update btn-sm fz_10">1</a>
							<a href="#" target="_blank" class="btn btn-secondary btn-sm fz_10">1</a>
							<a href="#" target="_blank" class="btn btn-light btn-sm fz_10">1</a>
							<a href="#" target="_blank" class="btn btn-dark btn-sm fz_10">1</a>
						</div>
					</div>
				</li>
				<li>
					<div class="l_part">Последний вход с IP</div>
					<div class="r_part">-</div>
				</li>
				<li>
					<div class="l_part">Последняя заявка с IP</div>
					<div class="r_part">-</div>
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
	<div class="hidden d-none" id="course">
		<div class="popover-heading">
			Курсы
		</div>
		<div class="popover-body">
			<strong class=" d-block pb-2">Зафиксированный</strong>
			<ul class="list-unstyled d-table  border border-light">
				<li class="d-table-row bg-light">
					<span class="d-table-cell p-2 ">0%</span>
					<span class="d-table-cell p-2">1 USDT <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
						123123$</span>
				</li>
				<li class="d-table-row">
					<span class="d-table-cell p-2">1110%</span>
					<span class="d-table-cell p-2">1 USDT <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
						123123$</span>
				</li>
			</ul>
			<strong class=" d-block pb-2">Текущий</strong>
			<ul class="list-unstyled d-table  border border-light">
				<li class="d-table-row bg-light">
					<span class="d-table-cell p-2 ">0%</span>
					<span class="d-table-cell p-2">1 USDT <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
						123123$</span>
				</li>
				<li class="d-table-row">
					<span class="d-table-cell p-2">1110%</span>
					<span class="d-table-cell p-2">1 USDT <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
						123123$</span>
				</li>
			</ul>
		</div>
	</div>
	<!-- popover -->
	<div class="hidden d-none" id="requestInfo">
		<div class="popover-heading">
			Инофрмация о заявке
		</div>
		<div class="popover-body">
			<div class="form-group">
				<label for="x1">Email</label>
				<input type="mail" class="form-control" id="x1" placeholder="" value="asd@asd.com">
			</div>
			<div class="form-group">
				<label for="x11">Кошелёк отправки</label>
				<input type="text" class="form-control" id="x11" placeholder="" value="afdsfsdfsdfsdfsdf">
			</div>
			<div class="form-group">
				<label for="x111">Кошелёк получения</label>
				<input type="text" class="form-control" id="x111" placeholder="" value="afdsfsdfsdfsdfsdf">
			</div>
			<div class="form-group">
				<label for="x111">IP</label>
				<input type="text" class="form-control" id="x111" placeholder="" value="123.123.123.2">
			</div>
			<div class="form-group">
				<textarea class="form-control" rows="2" placeholder="Коменнтарий"></textarea>
			</div>
			<div class="popover_footer pt-3 pb-2 d-flex justify-content-end">
				<a class="btn btn-success btn-md close_popover_js">Save</a>
			</div>
		</div>
	</div>
	<!-- popover -->
	<div class="hidden d-none" id="discount">
		<div class="popover-heading">
			Размер скидки
		</div>
		<div class="popover-body">
			<div class="form-group">
				<input type="text" class="form-control" id="x11g" placeholder="0" value="">
			</div>
			<div class="popover_footer pt-3 pb-2 d-flex justify-content-end">
				<a class="btn btn-success btn-md close_popover_js">Save</a>
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
			<p class="mb-0">Коешлёк : <strong>+123123123</strong></p>
		</div>
	</div>
	<!-- popover -->
	<div class="hidden d-none" id="editLabel">
		<div class="popover-heading">
			Редактирование метки
		</div>
		<div class="popover-body">
			<div class="form-group">
				<textarea class="form-control" rows="2" placeholder="Введите метку"></textarea>
			</div>
			<div class="popover_footer pt-3 pb-2 d-flex justify-content-end">
				<a class="btn btn-success btn-md close_popover_js">Save</a>
			</div>
		</div>
	</div>
	<!-- popover -->
	<div class="hidden d-none" id="editSumVal">
		<div class="popover-heading">
			Редактирование суммы к получению <span class="text-danger d-inline-block">в валюте</span>
		</div>
		<div class="popover-body">
			<div class="form-group">
				<input type="text" class="form-control" id="p1" placeholder="0" value="">
			</div>
			<div class="form-group">
				<label>Валюта</label>
				<select class="custom-select">
					<option>Валюта 1</option>
					<option>Валюта 2</option>
					<option>Валюта 2</option>
					<option>Валюта 2</option>
					<option>Валюта 2</option>
					<option>Валюта 2</option>
					<option>Валюта 2</option>
					<option>Валюта 2</option>
					<option>Валюта 2</option>
				</select>
			</div>
			<div class="popover_footer pt-3 pb-2 d-flex justify-content-end">
				<a class="btn btn-success btn-md close_popover_js">Save</a>
			</div>
		</div>
	</div>
	<!-- popover -->
	<div class="hidden d-none" id="requisites">
		<div class="popover-heading">
			Реквезиты получения
		</div>
		<div class="popover-body">
			<ul class="list-unstyled word_wrpap">
				<li><span class="text-muted">Кошелёк:</span> weurueroiuroiu23l12h3lkh12312j3123hk</li>
				<li><span class="text-muted">Доп:</span> Эксодус</li>
			</ul>
		</div>
	</div>
	<!-- popover -->
	<div class="hidden d-none" id="requisitesCheck">
		<div class="popover-body">
			<p class="mb-0">Проверить кошелёк: <a href="#">ljksdfjklsdjlkfjlskdjfsdfsdf</a></p>
		</div>
	</div>




<section class="card">
    <div class="card-header">
        <span class="cat__core__title">
            <strong>Подтверждение <?=$model_name?></strong>
        </span>
    </div>
    <div class="card-block">
        <div id="example1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="row">
        <div class="col-sm-12">
        <table class="table table-hover nowrap dataTable dtr-inline" id="example1" width="100%" role="grid" aria-describedby="example1_info">
            <thead class="thead-default">
            <tr role="row">
			<?foreach ($model->get_table_cols('confirmation') as $val):?>
				<th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Нажмите для сортировки"><?=$val?></th>
			<?endforeach;?>
				<th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Нажмите для сортировки">Действие</th>
				<th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Нажмите для сортировки">Действие</th>
			
			</tr>
            </thead>
            <tfoot>
            <tr>
            <?foreach ($model->get_table_cols('confirmation') as $val):?>
				<th   rowspan="1" colspan="1"><?=$val?></th>
			<?endforeach;?> 
				<th rowspan="1" colspan="1" style="">Действие</th>
				<th rowspan="1" colspan="1" style="">Действие</th>
            </tr>
            </tfoot>
            <tbody>
			<?foreach ($model->confirmation_get() as $row):
				$Us = new $model_name($this,$row['id']);
				
						 
				?>
				<tr role="row" class="odd" <?if ($row['status']==1) echo ' style="color:red;" ';?> id="row<?=$row['id']?>">
              
					<?foreach ($model->get_table_cols('confirmation') as $key => $val):
					if (!isset($row[$key])) $row[$key]=$Us->$key;
					?>
					<td style="" title="<?=$val?>"><?=$model->get_table_row($key,$row,$Us)?></td>
					<?endforeach;?> 
					<td style="">
					<?if($model_name=='Users'):?>
						<a href="javascript: void(0);" OnClick="$('#row_val_conf').val('<?=$row['id']?>');" class="bconfdic  cat__core__link--underlined" data-toggle="modal" data-target="#confirm"><small><i class="icmn-checkmark"></i></small> Подтвердить</a>
					<?else:?>
					<a href="javascript: void(0);"  OnClick="$('.child').remove();if (confirm('Вы уверены?')) ajax('admin_confirm/<?=$model_name?>/<?=$row['id']?>/accept','','#row<?=$row['id']?>');" class="bconfaccept cat__core__link--underlined mr-2"><i class="icmn-checkmark"></i> Подтвердить</a>
					<?endif;?>
					</td>
					<td style="">
						<a href="javascript: void(0);" OnClick="$('#row_val').val('<?=$row['id']?>');" class="bconfdic  cat__core__link--underlined" data-toggle="modal" data-target="#decline"><small><i class="icmn-cross"></i></small> Отказать</a>
					</td>
                </tr>
				<?endforeach;?>  
            </tr>
            </tbody>
        </table></div></div>
        
        </div>
    </div>
</section>
<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Доступные процессинги</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  
	  
		<div class="form-group">
            <label for="proc_other" class="form-control-label">Процессинг Other:</label>
            <select  class="form-control"   id="proc_other" >
				<?foreach ((new Pay_Methods($this))->get_all(100,0,'id','asc',['card_processing'=>1]) as $row):?>
					<option  value="<?=$row['id']?>"><?=$row['proc_name']?></option>
				<?endforeach;?>
			</select>
          </div>
		 <div class="form-group">
            <label for="proc_visa" class="form-control-label">Процессинг VISA:</label>
            <select  class="form-control"   id="proc_visa" >
				<?foreach ((new Pay_Methods($this))->get_all(100,0,'id','asc',['card_processing'=>1]) as $row):?>
					<option  value="<?=$row['id']?>"><?=$row['proc_name']?></option>
				<?endforeach;?>
			</select>
          </div>
		<div class="form-group">
            <label for="proc_mastercard" class="form-control-label">Процессинг MasterCard:</label>
            <select  class="form-control"     id="proc_mastercard" >
				<?foreach ((new Pay_Methods($this))->get_all(100,0,'id','asc',['card_processing'=>1]) as $row):?>
					<option  value="<?=$row['id']?>"><?=$row['proc_name']?></option>
				<?endforeach;?>
			</select>
          </div>		  
          <div class="form-group">
            <label for="proc_com" class="form-control-label">Комиссия процессинга:</label>
            <input type="text" id="proc_com"  required  class="form-control"   value="<?=vars('card_com')?>" >
          </div>
		  <div class="form-group">
            <label for="proc_com" class="form-control-label">Наша комиссия:</label>
            <input type="text" id="btc_com"  required  class="form-control"   value="<?=vars('btc_com')?>" >
          </div>
			<input id="row_val_conf" type="hidden" value="" > 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        <button type="button" data-dismiss="modal" OnClick="$('.child').remove();if (confirm('Вы уверены?')) ajax('admin_confirm/<?=$model_name?>/'+$('#row_val_conf').val()+'/accept','proc_com='+$('#proc_com').val()+'&proc_visa='+$('#proc_visa').val()+'&proc_mastercard='+$('#proc_mastercard').val()+'&btc_com='+$('#btc_com').val()+'&proc_other='+$('#proc_other').val(),'#row'+$('#row_val_conf').val());" class="btn btn-danger">Принять</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="decline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Отказв проверке</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<?if ($model_name=='Users'):?>
			Отказанные документы:
			<?foreach (['bank'=>'Фото','adresdoc'=>'Адрес', 'passport'=>'Паспорт','passport2'=>'Обратная сторона'] as $key=>$doc):?>
			<br><input type="checkbox" value="<?=$key?>" name="doc[]"> <?=$doc?>
			<?endforeach;?>
			<?endif;?>
			
			
          <div class="form-group">
            <label for="message-text" class="form-control-label">Причина отказа:</label>
            <textarea class="form-control" id="dic"></textarea>
			
			<input id="row_val" type="hidden" value="" > 
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        <button type="button" data-dismiss="modal" OnClick="$('.child').remove();if (confirm('Вы уверены?')) ajax('admin_confirm/<?=$model_name?>/'+$('#row_val').val()+'/decline','text='+$('#dic').val()+'&doc='+$('input[name=\'doc[]\']:checked').map(function(){return $(this).val();}).get(),'#row'+$('#row_val').val());" class="btn btn-danger">Отказать</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="photopass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Просмотр документов <a id="passport_doc_load" href="">(Скачать)</a></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img id="passport_doc" src="https://upload.wikimedia.org/wikipedia/commons/6/63/ID-card_CZ_2012.jpg" class="img-fluid" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="photoutility" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Просмотр документов <a id="bank_doc_load" href="">(Скачать)</a></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img id="bank_doc" src="http://vancouver.ca/images/cov/content/John-UtilityBill-NoLabels.png" class="img-fluid" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
<!-- START: page scripts -->
<div class="modal fade" id="info-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Информация о пользователе</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <dl class="row" id="user_info_ajax">
                       </dl>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        <a id="user_edit_ajax" href=""><button type="button" class="btn btn-info">Детали</button></a>
      </div>
    </div>
  </div>
</div>
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
<script>
    $(function () {

        // Datatables
        $('#example1').DataTable({
            "lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
            responsive: true,
            "autoWidth": false,
			 "order": [[ 0, "desc" ]]
        });

    })
</script>



  
<?if ($model_name=='Exchange'):?>
<script>
function renew_kurs()
{
	$.ajax({
								   type: "GET",
								   url: '/ajax/renew_kurs' ,
								   dataType: 'json', 
									cache:false,
									contentType: false,
									processData: false,
								  
								   success: function(data)
								   {
									  $.each( data  , function( index, value ) {
										   console.log( value.id+' '+  value.sum_to );
										   
										   $('#sum_to'+value.id).html(value.sum_to);
										   $('#status'+value.id).html(value.status);
										});
									      
								   }
						});
}
setInterval(renew_kurs,60000);
renew_kurs();
</script>	
<?endif;?>
 
</body>
</html>