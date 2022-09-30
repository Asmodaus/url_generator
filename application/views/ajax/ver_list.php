<?foreach (explode(',',$method['verefy_docs']) as $doc):?>
<?if (strlen($user->$doc)<1 && strlen($doc)>1):?>
								
	           
	           
	                <div class="form-group hideonload">
								<div class="col-md-12">
										<label for="<?=$doc?>"><?=l($doc);?> <?=l($doc.' пояснение');?></label>
										<input type="file" name="<?=$doc?>" id="<?=$doc?>" class="form-control">
									</div> 
								</div>
	<?endif;?>
<?endforeach;?> 