<?php
	// http://www.pachi.ac/~multi/cgi-bin/familyname/display.cgi?mode=aa


	// </td><td width="10%"><br></td><td width="20%"> > \n
	// </td><td width="25%"> > ,
	// <("[^"]*"|'[^']*'|[^'">])*>
	// ^\n
	// （(.*)）> 置換

	// key => MemberID val => MemberName
	// Memberテーブルから以下のような配列を生成
	$names[1] = "久保田怜也";
	$names[4] = "久保怜也";
	$names[7] = "久保田　怜也";
	$names[6] = "久保田 怜也";
	$names[5] = "長 怜也";
	$names[2] = "長谷川 怜也";

	$csv = ("data/kanji.csv");

	$f = fopen($csv, "r");

	$arr = array();
	while ($line = fgetcsv($f)) {
		$arr[mb_strlen($line[0])][] = $line[0];
	}

	krsort($arr);
	// var_dump($arr);
	$newNames = array();
	foreach ($names as $id => $name) {

		foreach ($arr as $len => $arr2) {

			foreach ($arr2 as $key => $val) {

				$nms = explode($val, $name);
				if ($nms[0] == "") {

					$newNames[$id] = array(
						"sei" => $val,
						"mei" => preg_replace("/( |　)/", "", $nms[1]),
					);
					//ヒットすれば次
					continue 3;
				}
			}
		}
	}

	// var_dump($newNames);
	// ここでデータベース更新
	foreach ($newNames as $id => $arr) {

		printf('ID: %s [表示名] %s => [姓] %s [名] %s <hr>', $id, $names[$id], $arr["sei"], $arr["mei"]);

		// $view = new Member($pdo);
		// $view->MemberID = $id;
		// $view->MemberName1 = $arr["sei"];
		// $view->MemberName2 = $arr["mei"];
	}
?>