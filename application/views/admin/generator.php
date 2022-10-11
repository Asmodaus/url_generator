<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include('header2.php'); 
?>
<div class="main px-3 py-5">
			<div class="centered">
				<div class="text-center pb-5">
					<h2 class="bold_font fz_50">Генератор UTM-меток</h2>
					<p>Создавайте ссылки для рекламных кампаний в несколько кликов</p>
				</div>
                <form class="login-form"   action="?" method="post" enctype="multipart/form-data"  role="form">
                    <?if (!$model->id):?>
                    <div class="panel p-5 mb-4">
                        <label for="asd" class="bold_font fz_30">Адрес страницы, для которой генерируем UTM-метки:</label>
                        <div class="input-group mb-0">
                            <input type="text" class="form-control" name="short_url" placeholder="mysite.ru" id="asd">
                            <div class="input-group-append">
                                <a class="btn btn-danger fz_12" OnClick="$('#asd').val('');" type="button" id="button-addon2">Очистить</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel p-5 mb-4">
                        <p class="bold_font fz_30">Выбор источника перехода:</p>
                        <?foreach ($p0 as $row):?>
                        <a OnClick="$('#p0').val('<?=$row['id']?>');return false;"  OnChange="select('template','<?=$row['id']?>','#p1' );" class="btn btn-light fz_12 py-2"><?=$row['value']?></a>
                        <?endforeach;?>
                    </div>
                    <?if ($user->link):?>
                    <div class="text-center pt-3">
                        <a href="#"  OnClick="$('.p_text').toggle();$('.p_select').toggle();" class="btn btn-outline-secondary py-2 fz_12">Создать ссылку свободного вида</a>
                    </div>
                    <?endif;?>
                    <div class="row mt-5 mx-n2">
                        <div class="col-6 px-2 mb-4">
                            <div class="panel p-5 h-100">
                                <h3 class="bold_font fz_30 mb-3">Выбор основных параметров:</h3>
                                <div class="form-group">
                                    <p class="label mb-2">Источник рекламной кампании (источник перехода) <strong
                                            class="d-block">utm_sourse</strong></p>
                                    <select id="p0" OnChange="select('template',this.value,'#p1' );" name="p0" class="custom-select p_select">
                                        <?foreach ($p0 as $row):?>
                                        <option  value="<?=$row['id']?>"><?=$row['value']?></option>
                                        <?endforeach;?>
                                    </select>
                                    <input type="text" style="display: none;" class="form-control p_text" id="p0_text" id="p0_text" placeholder="Значение">
                                </div>
                                <div class="form-group">
                                    <p class="label mb-2">Тип рекламной кампании (тип трафика) <strong
                                            class="d-block">utm_medium</strong></p>
                                    <select id="p1" name="p1"  OnChange="select('template',this.value,'#p2' );"  class="custom-select p_select"> 
                                    </select>
                                    <input type="text" style="display: none;" class="form-control p_text" id="p1_text" id="p1_text" placeholder="Значение">
                                </div>
                                <div class="form-group">
                                    <p class="label mb-2">Название рекламной кампании<strong class="d-block">utm_campaign</strong>
                                    </p>
                                    <select id="p2" name="p2"  OnChange="select('template',this.value,'#p3' );"  class="custom-select p_select"> 
                                    </select>
                                    <input type="text" style="display: none;" class="form-control p_text" id="p2_text" id="p2_text" placeholder="Значение">
                                </div>
                            </div>
                        </div>
                        <div class="col-6 px-2 mb-4">
                            <div class="panel p-5 h-100">
                                <h3 class="bold_font fz_30 mb-3">Выбор дополнительных параметров:</h3>
                                <div class="form-group">
                                    <p class="label mb-2">Идентификатор объявления<strong class="d-block">utm_content</strong></p>
                                    <select id="p3" name="p3"  OnChange="select('template',this.value,'#p4' );"  class="custom-select p_select"> 
                                    </select>
                                    <input type="text" style="display: none;" class="form-control p_text" id="p3_text" id="p3_text" placeholder="Значение">
                                </div>
                                <div class="form-group">
                                    <p class="label mb-2">Ключевое слово<strong class="d-block">utm_term</strong></p>
                                    <select id="p4" name="p4"  OnChange="select('template',this.value,'#p5' );"  class="custom-select p_select"> 
                                    </select>
                                    <input type="text" style="display: none;" class="form-control p_text" id="p4_text" id="p4_text" placeholder="Значение">
                                </div>
                                <div class="form-group">
                                    <p class="label mb-2">Дополнительные get параметры<strong class="d-block">get</strong>
                                    </p>
                                    <select id="p5" name="p5"   class="custom-select p_select"> 
                                    </select>
                                    <input type="text" style="display: none;" class="form-control p_text" id="p5_text" id="p5_text" placeholder="Значение">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-danger py-2 fz_12">Создать ссылку</button>
                    </div>
 
                    <?else:?>
                    <div class="panel p-5 mb-4">
                        <div class="d-flex align-items-center">
                            <p class="bold_font fz_30 mb-0">Итоговая ссылка:</p>
                            <div class="d-flex ml-auto">
                                <label for="inputFile"
                                    class="btn btn-outline-secondary d-inline-flex align-items-center ml-2 fz_12 mb-0">
                                    <input type="file" class="d-none" id="inputFile">
                                    <i class="fas fa-table fz_16 mr-2"></i>
                                    Добавить таблицу
                                </label>
                                <button class="btn btn-outline-secondary d-inline-flex align-items-center ml-2 fz_12"
                                    data-toggle="modal" data-target="#exampleModal">
                                    <i class="far fa-comment fz_16 mr-2"></i>
                                    Добавить комментарий</button>
                            </div>
                        </div>

                        <div class="input-group pt-3">
                            <input type="text" class="form-control" value="<?=$model->url?>" id="url">
                            <?/*
                            <div class="input-group-append">
                                <button class="btn btn-danger fz_12" type="button" id="button-addon2">Создать</button>
                            </div>
                            */?>
                        </div>
                        <div class="row pt-3 mx-n2">
                            <div class="col-auto px-2">
                                <button OnClick="copy('url');" class="btn btn-outline-secondary d-inline-flex align-items-center fz_12">
                                    <i class="far fa-copy fz_16 mr-2"></i>
                                    Копировать</button>
                                    <?/*
                                <button class="btn btn-outline-secondary d-inline-flex align-items-center fz_12">
                                    Сократить</button>
                                    */?>
                            </div>
                            <div class="col px-2">
                                <p class="fz_12"><?=$model->text?></p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="?" class="btn btn-danger py-2 fz_12">Создать новую ссылку</a>
                    </div>
                    <?endif;?>
                    

                </form>
			</div>
		</div> 

        <div class="modal fade" id="exampleModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Добавление комментария</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="login-form"   action="?id=<?=$model->id?>" method="post" enctype="multipart/form-data"  role="form">
                    <div class="modal-body">
                        <textarea class="form-control" name="text" rows="3" placeholder="Введите текст комментария…"><?=$model->text?></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger fz_12">Добавить</button>
                        <?/*
                        <button type="button" class="btn btn-secondary fz_12">Добавлять ко всем ссылкам</button>
                        */?>
                    </div>
                    </form>
                </div>
            </div>
        </div>
<?include('footer2.php');?> 
</body>
</html>