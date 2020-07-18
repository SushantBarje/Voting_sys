<?php 

		$data = array('data' => array('a','b'),'come' => 'here');

		$data = json_encode($data, JSON_PRETTY_PRINT);

		$fp = fopen('json1.json','w');
		fwrite($fp,$data);
		fclose($fp);
 ?>