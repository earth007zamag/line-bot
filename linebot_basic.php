<?php

$channelAccessToken = 'GWQL2zZjorHFkZmxwECSAA8zNInujVZqYsEmREsGKwWFzvAIBXRwprnw6yQ1btBydUznwGhbiIHrKDnb2WEEQlJc+0jZ8vbNtXchPzSdVc9ipaRC6Mv5vPKks6YPd17HL8n5c+apofakiV+4twnyCAdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น

$request = file_get_contents('php://input');   // Get request content

$request_json = json_decode($request, true);   // Decode JSON request

foreach ($request_json['events'] as $event)
{
	if ($event['type'] == 'message') 
	{
		if($event['message']['type'] == 'text')
		{
			$text = $event['message']['text'];
			$arr = explode(" ",$text);
			if($arr[0] == "@บอท"){
				
				$reply_message = "กรุณาใช้รูปแบบคำสั่งที่ถูกต้องงงงง!!\n";
				
				$reply_message .= "ฉันมีบริการให้คุณสั่งได้ ดังนี้...\n";
				
				$reply_message .= "พิมพ์ว่า \"@บอท ฉันต้องการค้นหาข้อมูลนิสิตชื่อ ...\"\n";
				$reply_message .= "พิมพ์ว่า \"@บอท ฉันต้องการค้นหาข้อมูลนิสิตนามสกุล ...\"\n";
				$reply_message .= "พิมพ์ว่า \"@บอท ฉันต้องการค้นหาข้อมูลนิสิตรหัสนิสิต ...\"\n";
// 				$reply_message .= "พิมพ์ว่า \"@บอท ฉันต้องการทราบจำนวนนิสิต ชาย ทั้งหมด \"\n";
// 				$reply_message .= "พิมพ์ว่า \"@บอท ฉันต้องการทราบจำนวนนิสิต หญิง ทั้งหมด \"\n";
				$reply_message .= "พิมพ์ว่า \"@บอท ฉันต้องการทราบจำนวนนิสิต ทั้งหมด \"\n";
				$reply_message .= "พิมพ์ว่า \"@บอท ฉันต้องการทราบชื่อนิสิต ทั้งหมด \"\n";
				$reply_message .= "พิมพ์ว่า \"@บอท ใครคือผู้พัฒนา \"\n";
				

				if($arr[1] == "ฉันต้องการค้นหาข้อมูลนิสิตชื่อ"){
					$result_users = mySQL_selectAll('http://bot.kantit.com/json_select_users.php');
					foreach($result_users as $values) {
						if($values["user_firstname"] == 'นาย'.$arr[2]||$values["user_firstname"] == 'นางสาว'.$arr[2]){
							$data .= "พบชื่อ: ".$values["user_firstname"] . " " . $values["user_lastname"] . "\r\n";
						}
					}
					$reply_message = $data;
				}
				if($arr[1] == "ฉันต้องการค้นหาข้อมูลนิสิตนามสกุล"){
					$result_users = mySQL_selectAll('http://bot.kantit.com/json_select_users.php');
					foreach($result_users as $values) {
						if($arr[2] == $values["user_lastname"]){
							$data .= "พบชื่อ: ".$values["user_firstname"] . " " . $values["user_lastname"] . "\r\n";
						}
					}
					$reply_message = $data;
				}
				if($arr[1] == "แสดงรายชื่อนิสิตทั้งหมด"){
					$result_users = mySQL_selectAll('http://bot.kantit.com/json_select_users.php');
					foreach($result_users as $values) {
						$data .= $values["user_stuid"] . " " . $values["user_firstname"] . " " . $values["user_lastname"] . "\r\n";
					}
					$reply_message = $data;
				}
				if($arr[1] == "ใครคือผู้พัฒนา"){
					$reply_message = "นายธณัช จินตกานนท์ 61160060 \n";
				}
				if($arr[1] == "ฉันต้องการค้นหาข้อมูลนิสิตรหัสนิสิต"){
					$result_users = mySQL_selectAll('http://bot.kantit.com/json_select_users.php');
					foreach($result_users as $values) {
						if($arr[2] == $values["user_stuid"]){
							$data .= "พบชื่อ: ".$values["user_firstname"] . " " . $values["user_lastname"] . "\r\n";
						}
					}
					$reply_message = $data;
				}
				if($arr[1] == "ฉันต้องการทราบจำนวนนิสิต" && $arr[2] == "ทั้งหมด" || $arr[1] == "ฉันต้องการทราบจำนวนนิสิตทั้งหมด" ){
					$result_users = mySQL_selectAll('http://bot.kantit.com/json_select_users.php');
					foreach($result_users as $values) {
						$n += 1;
						$data .= $values["user_firstname"] . " " . $values["user_lastname"] . "\r\n";
					}
					$reply_message = $data . "\n" . "จำนวนนิสิตทั้งหมด" . $n . "คน" . "\r\n";
				}
				if($arr[1] == "ฉันต้องการทราบชื่อนิสิต" && $arr[2] == "ทั้งหมด" || $arr[1] == "ฉันต้องการทราบชื่อนิสิตทั้งหมด" ){
					$result_users = mySQL_selectAll('http://bot.kantit.com/json_select_users.php');
					foreach($result_users as $values) {
						$n += 1;
						$data .= $values["user_firstname"] . " " . $values["user_lastname"] . "\r\n";
					}
					$reply_message = $data . "\n" . "จำนวนนิสิตทั้งหมด" . $n . "คน" . "\r\n";
				}
// 				if($arr[1] == "ฉันต้องการทราบจำนวนนิสิต" && $arr[2] == "ชาย"){
// 					$result_users = mySQL_selectAll('http://bot.kantit.com/json_select_users.php');
// 					foreach($result_users as $values) {
//                             			$male = substr($values["user_firstname"],0,3);
//                             			if($male == "นาย"){
//                                 			$data .= $values["user_firstname"] . " " . $values["user_lastname"] . "\r\n";
//                         			}
// 					}
// 					$reply_message = $male;
// 				}
			}
			
			
		} else {
			$reply_message = 'ฉันได้รับ '.$event['message']['type'].' ของคุณแล้ว!';
		}
	} else {
		$reply_message = 'ฉันได้รับ Event '.$event['type'].' ของคุณแล้ว!';
	}
	
	// reply message
	$post_header = array('Content-Type: application/json', 'Authorization: Bearer ' . $channelAccessToken);
	$data = ['replyToken' => $event['replyToken'], 'messages' => [['type' => 'text', 'text' => $reply_message]]];
	$post_body = json_encode($data);
	$send_result = replyMessage('https://api.line.me/v2/bot/message/reply', $post_header, $post_body);
	//$send_result = send_reply_message('https://api.line.me/v2/bot/message/reply', $post_header, $post_body);
}

function replyMessage($url, $post_header, $post_body)
{
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => $post_header,
                'content' => $post_body,
            ],
        ]);
	
	$result = file_get_contents($url, false, $context);

	return $result;
}

function send_reply_message($url, $post_header, $post_body)
{
	$ch = curl_init($url);	
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	
	$result = curl_exec($ch);
	
	curl_close($ch);
	
	return $result;
}

function mySQL_selectAll($url)
{
	$result = file_get_contents($url);
	
	$result_json = json_decode($result, true); //var_dump($result_json);
	
// 	$data = "ผลลัพธ์:\r\n";
		
// 	foreach($result_json as $values) {
// 		$data .= $values["user_firstname"] . " " . $values["user_lastname"] . "\r\n";
// 	}
	
	return $result_json;
}

?>
