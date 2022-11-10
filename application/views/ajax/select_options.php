<option   >Выберите параметр</option>
<option value="-<?=$level?>"  >Пустой параметр</option>
<?foreach ($options as $k=>$v):?>
<option value="<?=$k?>" <?=($_GET['selected']==$k ? 'selected' : '')?> ><?=$v?></option>
<?endforeach;?> 
<script>
    <?if ($show_input):?> 
        $('#p<?=$level?>_text').show(); 
        <?for ($i=$level;$i<=5;$i++):?> 
            $('#p<?=$i?>_text').show();
        <?endfor;?>
    <?else:?> 
        $('#p<?=$level?>_text').hide();   
        <?for ($i=$level;$i<=5;$i++):?> 
            $('#p<?=$i?>_text').hide();
        <?endfor;?>
    <?endif;?>

    
</script>