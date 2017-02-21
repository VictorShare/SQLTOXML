<?php 
//header("content-type:text/html; charset=utf-8");
try {
	$pdo = new PDO("mysql:host=localhost;dbname=vipapps;charset=utf8;","root","root",array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
	$sql = "select * from ys_project order by project_id asc";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
	print_r($res);
} catch (Exception $e) {
	echo $e->getMessage();
}
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
echo "<root>";
foreach ($res as $v){
	if($v['construction_id'] == 0){
		continue;
	}
	echo "<project id=\"",$v['project_id'],"\" name=\"",$v['project_name'],"\" kind=\"",returnKind($pdo, $v['construction_id']),"\" >";
	$cons = getCons($pdo, $v['project_id']);
	foreach ($cons as $c){//construction
		echo  "<construction id=\"",$c['construction_item_id'],"\" name=\"",$c['construction_item'],"\" desc=\"",$c['construction_item_description'],"\">";
		$room  = getRoom($pdo, $c['construction_item_id']);
		foreach ($room as $r){
			echo "<amount id=\"".$r['room_id'],"\" bDefault=\"",$r['is_default'],"\" Area=\"",$r['area_amount'],"\" LaterArea=\"",$r['lateralarea_amount'],"\" WindowArea=\"",$r['windowarea_amount'],
			"\" DoorArea=\"",$r['doorarea_amount'],"\" perimeter=\"",$r['circumference_amount'],"\" WindowPerimeter=\"",$r['windowcircumference_amount'],"\" DoorPerimeter=\"",$r['doorcircumference_amount'],
			"\" length=\"",$r['length_amount'],"\" width=\"",$r['width_amount'],"\" DoorWidth=\"",$r['door_width_amount'],"\" height=\"",$r['height_amount'],"\" DoorCount=\"",$r['door_amount'],"\"  constant=\"",$r['amount'],"\" >";
			echo "</amount>";
		}
		echo "<brand unit=\"",$c['unit'],"\" loss=\"",$c['wastage'],"\" main=\"",$c['main'],"\" profit=\"",$c['main_profit'],"\" auxiliary=\"",$c['assistant'],"\" auxprofit=\"",$c['assistant_profit'],"\" laborcost=\"",$c['manpower'],"\" laborprofit=\"",$c['manpower_profit'],"\" >";
		$goods = getGoods($pdo, $r['construction_item_id']);
		//print_r($goods);exit();
		foreach ($goods as $g){
			$good_sku = getGoodsku($pdo,$g['construction_goods_id']);
			if(!empty($good_sku)&& isset($good_sku[0])){
				echo "<mt kind=\"",$good_sku[0]['list_type'],"\" id=\"",$good_sku[0]['construction_goods_id'],"\" name=\"",$good_sku[0]['goods_name'],"\" classify=\"",$good_sku[0]['goods_category'],"\"  model=\"",$good_sku[0]['goods_version'],"\" unit=\"",$good_sku[0]['unit'],"\" pack_unit=\"",$good_sku[0]['pack_unit'],"\" price=\"",$good_sku[0]['price'],"\" num=\"",
				$g['amount'],"\" pack_num=\"",$good_sku[0]['goods_amount'],"\" brand=\"",$good_sku[0]['brand'],"\" desc=\"",$g['description'],"\" goods_id=\"",$good_sku[0]['goods_id'],"\" >";
				echo "</mt>";
			}
		}
		echo "</brand>";
		echo "</construction>";
	}
	echo "</project>";
}
echo "</root>";

//获取construction的结果集
function getCons($pdo,$pro){
	$sql = "select  * from ys_construction_item where project_id=".$pro;
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$kind = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $kind;
}
//获得种类
function  returnKind($pdo,$var){
	$sql = "select  construction_name from ys_construction where construction_id=".$var;
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$kind = $stmt->fetchAll(PDO::FETCH_NUM);
	$kind0 = $kind[0][0];
	return $kind0;
}
//获取房间信息
function getRoom($pdo,$var){
	$sql = "select  * from ys_room_item where construction_item_id=".$var." order by room_id asc";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$kind = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $kind;
}
//获取用量
function getGoods($pdo,$var){
	$sql = "select  * from ys_construction_item_goods where construction_item_id=".$var." order by construction_item_goods_id asc";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$kind = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $kind;
}
//获取货物的sku
function getGoodsku($pdo,$var){
	$sql = "select  * from ys_construction_goods where construction_goods_id=".$var." order by construction_goods_id asc";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$kind = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $kind;
}
?>