<?
require_once($_SERVER['DOCUMENT_ROOT']."/class/utils.php");
$news_sql = (isset($_GET["id"]))? "WHERE `id` = '".intval($_GET["id"])."' LIMIT 1" : '' ;

if($news_sql == ''){

  $num = $site_con["num_news"];
  $upag = "news.php?n";
  $num_page = (isset($_GET["n"]))? intval($_GET["n"]) : 1 ;
  $np = mysql_num_rows(mysql_query("SELECT `id` FROM `still_news`"));
  $obpag = intval(($np - 1) / $num) + 1;
  if(empty($num_page) or $num_page < 0) $num_page = 1;
  if($num_page > $obpag) $num_page = $obpag;
  $nach = $num_page * $num - $num;

  $limit_new = " ORDER BY `id` DESC LIMIT $nach, $num";

}else{

  $id = (isset($_GET["id"]))? intval($_GET["id"]) : "1" ;

  $news_num = mysql_fetch_array(mysql_query("SELECT `id` FROM `still_news` ORDER BY `id` DESC LIMIT 1"));
  if($id == $news_num["id"] and isset($_SESSION["username"])){
    if($usmem["news"]==1){
      mysql_query("UPDATE `tb_users` SET `news` = '0' WHERE `id` = '".$usmem["id"]."'");
    }
  }

  require("comment.php");

  $num = $site_con["num_news_comm"];
  $upag = "news.php?id=".intval($_GET["id"])."&n";
  $num_page = (isset($_GET["n"]))? intval($_GET["n"]) : 1 ;
  $np = mysql_num_rows(mysql_query("SELECT `id` FROM `still_news_comment` WHERE `idn` = ".intval($_GET["id"]).""));
  $obpag = intval(($np - 1) / $num) + 1;
  if(empty($num_page) or $num_page < 0) $num_page = 1;
  if($num_page > $obpag) $num_page = $obpag;
  $nach = $num_page * $num - $num;

  $comment = mysql_query("
      SELECT  `c1`.`id`, `c1`.`text`, `c1`.`data`, `c3`.`username`, `c3`.`reyting`, `c3`.`avatar`,
      (SELECT IFNULL(SUM(`karma`),0) as sum_kar FROM `still_stena_karma` WHERE `ids`=`c1`.`idu`) as kar
      FROM `still_news_comment` as c1, `still_news` as c2, `tb_users` as c3
      WHERE `c1`.`idn`='".$id."' and `c1`.`idu`=`c3`.`id` and `c2`.`id`='".$id."'
      ORDER BY `c1`.`data` ASC LIMIT $nach, $num");

}

require("navi.php");

$news = mysql_query("SELECT * FROM `still_news` ".$news_sql.$limit_new."");

$num="";
  if(@$_SESSION["z_code"] == ""){
$_SESSION["z_code"] = md5(rand(10000,100000));
}

$z_code = $_SESSION["z_code"];?>