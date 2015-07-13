<html>
<head>
    <title>Sender</title>
    <meta charset="utf-8">
</head>
<body>
<form name="f1" action="" method="post">
    <label>Action -</label>
    <select name="action">
        <option>query</option>
    </select><br/><br/>
    <input type="text" name="query" placeholder="query" value="SELECT * FROM blog.articles;" style="width: 15%"><br/><br/>
    <button id="encrypt" type="submit">Send</button>
</form>
</body>
</html>
<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define("ENCRYPTION_KEY", "!@#$%^&*");

require_once('env.class.php');

$env = new Env();

$action = $env->encrypt($_POST['action'],ENCRYPTION_KEY);
$data   = $env->encrypt($_POST['query'],ENCRYPTION_KEY);

echo 'Encrypted action - '.$action.'<br><br>';
echo 'Encrypted query - '.$data.'<br><br>';
echo '<hr>';
echo 'Encrypted response :'.'<br><br>';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/tasks/router.php');
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, "data=$data&action=$action");
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U;Windows NT 5.1; ru; rv:1.8.0.9) Gecko/20061206 Firefox/1.5.0.9');
$exec = curl_exec($ch);
curl_close($ch);

echo $exec;
echo '<br><br><br>';
echo 'Decrypted response :'.'<br><br>';
echo $env->decrypt($exec,ENCRYPTION_KEY);