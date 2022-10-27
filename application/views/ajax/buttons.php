 
<?foreach ($options as $k=>$v):?>
	<a OnClick="$('#p<?=$level?>').val('<?=$k?>');select('template','<?=$k?>','#p<?=$level+1?>' );return false;" class="btn btn-light fz_12 py-2"><?=($v)?></a>
<?endforeach;?>  