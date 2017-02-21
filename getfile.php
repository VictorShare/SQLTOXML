<?php
//header("content-type:text/html; charset=utf-8");
/* 	$my_curl = curl_init();    //初始化一个curl对象
	curl_setopt($my_curl, CURLOPT_URL, "http:www.vipapps.com/admin/sqltoxml");    //设置你需要抓取的URL
	curl_setopt($my_curl,CURLOPT_RETURNTRANSFER,1);    //设置是将结果保存到字符串中还是输出到屏幕上，1表示将结果保存到字符串
	$str = curl_exec($my_curl);    //执行请求
	echo $str;    //输出抓取的结果
	curl_close($my_curl);    //关闭url请求 */

/* 	$str = file_get_contents("http://www.vipapps.com/admin/sqltoxml");
	//file_put_contents("D:/xml/xml.xml",$str); 

	$filename = "/xml/data".date("Y-m-d",time())."-".rand(0,9999).".xml";
	$data = substr($str,strpos($str,"<?xml"),(strpos($str,"</root>")+7)) ;
	file_put_contents("D:/WWW/sqltoxml".$filename,$data);
	$name = "D:/WWW/sqltoxml".$filename;
	header('Content-type: application/xml');
	//下载显示的名字
	header('Content-Disposition: attachment; filename="data.xml"');
	readfile("$name"); */
	
	$str = file_get_contents("http://www.vipapps.com/admin/sqltoxml");
	//file_put_contents("D:/xml/xml.xml",$str);
	
	$filename = "/xml/data".date("Y-m-d",time())."-".rand(0,9999).".xml";
	$data = substr($str,strpos($str,"<?xml"),(strpos($str,"</root>")+7)) ;
	file_put_contents("D:/WWW/sqltoxml".$filename,$data);
	$name = "D:/WWW/sqltoxml".$filename;
	header('Content-type: application/xml');
	//下载显示的名字
	header('Content-Disposition: attachment; filename="data.xml"');
	readfile("$name");
?>