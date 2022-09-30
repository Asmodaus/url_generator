<?
require_once($_SERVER['DOCUMENT_ROOT']."/class/utils.php");
if($usmem["id"] != '' && isset($_REQUEST["stat"])){
  $id_new = intval($_GET["id"]);

  $n_c = "";
  if($_REQUEST["stat"]=="del" and mb_strtolower($usmem["username"]) == mb_strtolower($site_con["login_admin"])){  	$id_com = intval($_GET["id_com"]);

  	$news_comm_prov = mysql_num_rows(mysql_query("SELECT `id` FROM `still_news_comment` WHERE `id` = '$id_com'"));
    if($news_comm_prov > 0){
      if($_SESSION["z_code"] != $_GET["z_code"] or $_SESSION["z_code"]=="" or @$_GET["z_code"]==""){

        $stop .= "Ошибка ввода";

      }else{
        unset($_SESSION["z_code"]);

        mysql_query("DELETE FROM `still_news_comment` WHERE `id`='$id_com' LIMIT 1");

        $num_com = $site_con["num_news_comm"];
        $np_com = mysql_num_rows(mysql_query("SELECT `id` FROM `still_news_comment` WHERE `idn` = '".$id_new."'"));
        $obpag_com = intval(($np_com - 1) / $num_com) + 1;

        if($obpag_com > 1){$n_c = "&n=".$obpag_com;}

        echo "<meta http-equiv='refresh' content='0; URL=news.php?id=".$id_new.$n_c."#comm'>";

      }

    }

  }

  if($_REQUEST["stat"]=="com" and $_GET["id"]!=""){
    if($_SESSION["z_code"] != @$_POST["z_code"] or $_SESSION["z_code"]=="" or @$_POST["z_code"]==""){

      $stop .= "Ошибка ввода";

    }else{
      unset($_SESSION["z_code"]);

      $news_prov = mysql_num_rows(mysql_query("SELECT `id` FROM `still_news` WHERE `id` = '$id_new'"));

      if($news_prov <= 0){        $stop .= "Нет такой новости";

      }else{
        $text_com = $_POST["comment"];

        if($text_com == NULL){

          $stop .= "Нет текста сообщения";

        }else{

          if(strlen($text_com) > $site_con["max_news_comm"] or strlen($text_com) < $site_con["min_news_comm"]){

            $stop .= "Текст сообщения должен быть от ".$site_con["min_news_comm"]." до ".$site_con["max_news_comm"]." символов";

          }else{

            $com_text = bbcod($text_com, true, true, $imgdomen, 71);

             mysql_query("INSERT INTO `still_news_comment` (`idu`, `text`, `idn`, `data`) VALUES('".$usmem["id"]."', '$com_text', '$id_new', NOW())");

            $id_max = mysql_insert_id();

            $num_com = $site_con["num_news_comm"];
            $np_com =  mysql_num_rows(mysql_query("SELECT `id` FROM `still_news_comment` WHERE `idn` = '".$id_new."'"));
            $obpag_com = intval(($np_com - 1) / $num_com) + 1;

            if($obpag_com > 1){$n_c = "&n=".$obpag_com;}

            echo "<meta http-equiv='refresh' content='0; URL=news.php?id=".$id_new.$n_c."#".$id_max."'>";

            $text_com = '';

          }

        }

      }

    }

  }

}
?>