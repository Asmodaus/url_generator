<style>
#navi {
height:16px;
margin:10px 0;
padding:4px;
}

#navi .left {
display:inline-block;
width:15%;
text-align:left;
}

#navi .center {
display:inline-block;
width:70%;
text-align:center;
}

#navi .center a {
margin:2px;
padding:5px 8px;
}

#navi .center a:hover {
border-radius:2px;
color:#fff;
background:#356797;
text-shadow:#1e4c78 0 -1px 1px;
margin:2px;
padding:5px 8px;
}

#navi .center span {
border-radius:2px;
color:#fff;
background:#356797;
font-weight:700;
text-shadow:#1e4c78 0 -1px 1px;
margin:0;
padding:5px 8px;
}

#navi .right {
display:inline-block;
width:15%;
text-align:right;
}

</style>

<?

$pleft = '';$pright = '';
if ($num_page != 1) {$pnaz = '<a href="'.$upag.'='. ($num_page - 1) .'">&laquo; Назад</a>';
}else{$pnaz = '<span>&laquo; Назад</span>';}

if ($num_page != $obpag){$pdal = '<a href="'.$upag.'='. ($num_page + 1) .'">Далее &raquo;</a>';
}else{$pdal = '<span>Далее &raquo;</span>';}

if($obpag <= 11){  for($i = 1,$ip = 0; $i < $num_page; $i++,$ip++){
      if($num_page - $i > 0) $pleft .= '<a href="'.$upag.'='. $i .'">'. $i .'</a>';
    }

    for($i = 1; $i < 12 - ($ip + 1); $i++){
      if($num_page + $i <= $obpag) $pright .= '<a href="'.$upag.'='. ($num_page + $i) .'">'. ($num_page + $i) .'</a>';
    }
}else{
if($num_page == 1){    for($i = 1; $i < 9; $i++){
      if($num_page + $i <= $obpag) $pright .= '<a href="'.$upag.'='. ($num_page + $i) .'">'. ($num_page + $i) .'</a>';
    }

    $pright .= '&nbsp;...&nbsp;<a href="'.$upag.'='.$obpag.'">'.$obpag.'</a>';
}elseif($num_page > 1 and $num_page < 7 ){
    for($i = 1,$ip = 0; $i < $num_page; $i++,$ip++){
      if($num_page - $i > 0) $pleft .= '<a href="'.$upag.'='. $i .'">'. $i .'</a>';
    }

    for($i = 1; $i < 10 - ($ip + 1); $i++){
      if($num_page + $i <= $obpag) $pright .= '<a href="'.$upag.'='. ($num_page + $i) .'">'. ($num_page + $i) .'</a>';
    }

    $pright .= '&nbsp;...&nbsp;<a href="'.$upag.'='.$obpag.'">'.$obpag.'</a>';
}elseif($num_page >= 7 and $num_page+7 <= $obpag){
    $pleft .= '<a href="'.$upag.'=1">1</a>&nbsp;...';

    for($i = 1,$ip = 0; $i < 4; $i++,$ip++){
      if($num_page - $i > 0) $pleft .= '<a href="'.$upag.'='. ($num_page - 4 + $i) .'">'. ($num_page - 4 + $i) .'</a>';
    }

    for($i = 1; $i < 4; $i++){
      if($num_page + $i <= $obpag) $pright .= '<a href="'.$upag.'='. ($num_page + $i) .'">'. ($num_page + $i) .'</a>';
    }

    $pright .= '&nbsp;...&nbsp;<a href="'.$upag.'='.$obpag.'">'.$obpag.'</a>';
}elseif( $num_page+6 >= $obpag and $num_page != $obpag and $num_page != 1){
    $pleft .= '<a href="'.$upag.'=1">1</a>&nbsp;...';

    for($i = 1; $i < $num_page; $i++){
      if($num_page - $i > 0) {$ip++;}
    }

    for($i = 1,$vop=1; $i < $obpag - $num_page + 1; $i++){
      if($num_page + $i <= $obpag) {$vop++;$pright .= '<a href="'.$upag.'='. ($num_page + $i) .'">'. ($num_page + $i) .'</a>';}
    }

    for($i = 1, $ops = 1; $i < 10 - $vop; $i++){
      if($num_page - $i > 0) {$ops++;}
    }

    for($i = 1; $i < 10-$vop; $i++){
      if($num_page - $i > 0) {$pleft .= '<a href="'.$upag.'='. ($num_page - $ops + $i) .'">'. ($num_page - $ops + $i) .'</a>';}
    }
}elseif($num_page == $obpag){
    $pleft .= '<a href="'.$upag.'=1">1</a>&nbsp;...';

    for($i = 1; $i < 9; $i++){
      if($num_page - $i > 0) $pleft .= '<a href="'.$upag.'='. ($num_page - 9 + $i) .'">'. ($num_page - 9 + $i) .'</a>';
    }
}
}

$navi = '<div id="navi"><div class="left">&nbsp;'.$pnaz.'&nbsp;</div><div class="center">&nbsp;'.$pleft.'&nbsp;<span>&nbsp;'.$num_page.'&nbsp;</span>&nbsp;'.$pright.'&nbsp;</div><div class="right">&nbsp;'.$pdal.'&nbsp;</div></div>';
?>