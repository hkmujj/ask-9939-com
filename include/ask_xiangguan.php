<?php
/*
	科室相关问答
*/
//$cid = intval($_GET['cid']);
$cid = intval($this->classid) ?  intval($this->classid) : intval($this->info['classid']);
$sWhere = ($cid > 0) ? "classid=$cid and answernum>0 and examine=1" : 1;

define("ROOT",substr(dirname(__FILE__), 0, -7));	//文件的主目录
require_once(ROOT.'/config.php');

//$cacheName = 'ask_xiangguan_'.$cid;
//$arr = loadCache($cacheName,24);

$cacheName = 'ask_xiangguan_' . $cid;
$arr = QLib_Cache_Client::getCache('ask_xiangguan', $cacheName, 24);


if(!$arr || count($arr)>10) {
	$arr = array();
	$sql = "select id,title from wd_ask  where ".$sWhere." order by id desc limit 0,10";
	$result = mysql_query($sql);
	if($result) {
		while($row = mysql_fetch_assoc($result)){
			$arr[] = $row;
		}
                
//		saveCache($cacheName,$arr,2);//缓存2小时
                QLib_Cache_Client::setCache('ask_xiangguan', $cacheName, $arr, 2);
	}
}

$count = 0; //计数
?>

<?php if($arr) { ?>
<?php	foreach($arr as $val) { ?>
<?php $count++; if($count>10) break; ?>
			 <li><a href="/id/<?php echo $val['id'];?>" target="_blank" title="<?php echo $val['title'];?>"><?php echo mb_substr($val['title'],0,18,'utf-8');?></a></li>
<?php	} ?>
<?php } ?>

