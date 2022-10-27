 
<?foreach ($buttons as $k=>$v):?>
	<a OnClick="$('#p<?=$level?>').val('<?=$k?>');$('#p<?=$level?>').trigger('change');select('template','<?=$k?>','#p<?=$level+1?>' );return false;" class="btn btn-light fz_12 py-2"><?=($v)?></a>
<?endforeach;?>  