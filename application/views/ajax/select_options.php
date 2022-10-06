<?foreach ($options as $k=>$v):?>
<option value="<?=$k?>" ><?=$v?></option>
<?endforeach;?> 
<script>
    <?if ($show_input):?> 
        $('#form_p<?=$level?>_text').show();
    <?else:?> 
        $('#form_p<?=$level?>_text').hide();  
    <?endif;?>
</script>