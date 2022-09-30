<?
require_once($_SERVER['DOCUMENT_ROOT']."/class/utils.php");
function bbcod($input, $sql=false, $bbc=false) {
    $input = htmlspecialchars($input, ENT_QUOTES,'WINDOWS-1251');
    if(get_magic_quotes_gpc ())
    {
        $input = stripslashes ($input);
    }
    if ($sql)
    {
        $input = mysql_real_escape_string ($input);
    }
    $input = strip_tags($input);

    if ($sql)
    {        $input=str_replace ("\\r\\n\\r\\n\\r\\n\\r\\n","<br><br>", $input);
        $input=str_replace ("\\r\\n\\r\\n\\r\\n","<br><br>", $input);
        $input=str_replace ("\\r\\n\\r\\n","<br><br>", $input);
        $input=str_replace ("\\r\\n","<br>", $input);
        $input=str_replace ("\\n"," ", $input);
        $input=str_replace ("\\r","", $input);
    }

    if($bbc){       $find = array ("'\[b\]'i", "'\[/b\]'i", "'\[i\]'i", "'\[/i\]'i", "'\[u\]'i", "'\[/u\]'i", "'\[quote\]'si", "'\[quote=(.+?)\]'si", "'\[/quote\]'si");

	   $replace = array ("<b>", "</b>", "<i>", "</i>", "<u>", "</u>", "<div class=\"quote\">", "<div class=\"title_quote\"><b>Цитата:</b> \\1</div><div class=\"quote\">", "</div>");

      $input = preg_replace( $find, $replace, $input );
    }

    return $input;
}
?>