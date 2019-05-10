<?php

function cURL($url, $post=null, $head=null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    if($post != null) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    if($head != null) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    }
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $exec = curl_exec($ch);
    curl_close($ch);
    return $exec;
}

function post($email, $password){
  $KEY = '62f8ce9f74b12f84c123cc23437a4a32';
  $DPOST = array(
    "api_key" => "882a8490361da98702bf97a021ddc14d",
    "credentials_type" => "password",
    "email" => $email,
    "format" => "JSON",
    "generate_machine_id" => "1",
    "generate_session_cookies" => "1",
    "locale" => "en_US",
    "method" => "auth.login",
    "password" => $password,
    "return_ssl_resources" => "0",
    "v" => "1.0"
  );
  $sig = "";
  foreach ($DPOST as $key => $value) {
    $sig .= $key."=".$value;
  }
  $DPOST["sig"] = md5($sig.$KEY);

  $res = json_decode(cURL('https://api.facebook.com/restserver.php', $DPOST));

  if ($res->access_token){
    return $res->access_token;
  } else {
    return json_decode($res->error_data)->error_message;
  }
}
?>

<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta content="Val" name="author">
  <title>KAY - access token genrator</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="/css/custom.css" rel="stylesheet">
</head>
<body>
<br>
<?php
if (isset($_POST["email"]) and isset($_POST["pass"])){
  $response = post($_POST["email"], $_POST["pass"]);
}
?>
<div id="wrapshopcart">
  <a href="/tools"><i class="fa fa-times" style="font-size:25px"></i></a>
  <center>
    <h5>Access Token Generator</h5>
  </center>
  <hr/>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
    <div class="form-group">
      <label>email</label>
      <input class="form-control" type="text" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
    </div>
    <div class="form-group">
      <label>password</label>
      <input class="form-control" type="password" name="pass" value="<?php echo isset($_POST['pass']) ? $_POST['pass'] : ''; ?>" required>
    </div>
    <button type="submit" class="btn btn-success ">generate</button><br>
  </form>

  <textarea class="form-control" type="textarea" maxlength="150" rows="3" readonly><?php echo isset($response) ? $response : "result here"; ?></textarea>
  </p>

  <hr>
  <center>
    <p><i class="fa fa-facebook-official"></i><a href="https://m.facebook.com/zvtyrdt.id"> Val</a></p>
  </center>
  </div>
</div>
</body>
</html>
