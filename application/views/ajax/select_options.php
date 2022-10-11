<option   >Выберите параметр</option>
<?foreach ($options as $k=>$v):?>
<option value="<?=$k?>" ><?=$v?></option>
<?endforeach;?> 
<script>
    <?if ($show_input):?> 
        $('#p<?=$level?>_text').show();
        $('#p<?=$level?>').hide();
        <?for ($i=$level;$i<=5;$i++):?>
            $('#p<?=$i?>').hide();   
            $('#p<?=$i?>_text').show();
        <?endfor;?>
    <?else:?> 
        $('#p<?=$level?>_text').hide();  
        $('#p<?=$level?>').show();
        <?for ($i=$level;$i<=5;$i++):?>
            $('#p<?=$i?>').show();   
            $('#p<?=$i?>_text').hide();
        <?endfor;?>
    <?endif;?>

    
</script>