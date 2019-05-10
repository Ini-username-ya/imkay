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

function post($access_token){
  $xml = cURL("https://api.facebook.com/restserver.php?method=auth.expireSession&access_token=".$access_token);
  preg_match("/\<error_msg\>(.*?) \(/", $xml, $res);
  if ($res){
    return $res[1];
  } else {
    return "Your session has been deleted";
  }
}
?>

<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta content="Val" name="author">
  <title>session remover</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="/css/custom.css" rel="stylesheet">
</head>
<body>
<br>
<?php
if (isset($_POST["access_token"])){
  $response = post($_POST["access_token"]);
}
?>
<div id="wrapshopcart">
  <a href="/tools"><i class="fa fa-times" style="font-size:25px"></i></a>
  <center>
    <h5>Session Remover</h5>
  </center>
  <hr/>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
    <div class="form-group">
      <label>access token</label>
      <input class="form-control" type="text" name="access_token" value="<?php echo isset($_POST['access_token']) ? $_POST['access_token'] : ''; ?>" required>
    </div>
    <button type="submit" class="btn btn-danger">remove</button><br>
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
