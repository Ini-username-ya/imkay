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

function post($token, $onoff){
  $md5 = md5(time());
  $hash = substr($md5, 0, 8)."-".substr($md5, 8, 4)."-".substr($md5, 12, 4)."-".substr($md5, 16, 4)."-".substr($md5, 20, 12);

  $me = json_decode(cURL("https://graph.facebook.com/me?fields=id&access_token=".$token));
  $fb_uid = $me->id;

  if ($onoff == "activate"){
    $onoff = "true";
  } else {
    $onoff = "false";
  }

  $var = "{\"0\":{\"is_shielded\":$onoff,\"session_id\":\"$hash\",\"actor_id\":\"$fb_uid\",\"client_mutation_id\":\"$hash\"}}";
  $params = array(
        "variables" => $var,
        "doc_id" => "1477043292367183",
        "query_name" => "IsShieldedSetMutation",
        "strip_defaults" => "true",
        "strip_nulls" => "true",
        "locale" => "en_US",
        "client_country_code" => "US",
        "fb_api_req_friendly_name" => "IsShieldedSetMutation",
        "fb_api_caller_class" => "IsShieldedSetMutation",
        "access_token" => $token
  );
  $response = cURL("https://graph.facebook.com/graphql", $params);
  $res = json_decode($response);
  if ($res->error->message) {
    return $res->error->message;
  } else {
    return $response;
  }
}
?>

<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta content="Val" name="author">
  <title>KAY - profile picture guard</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="/css/custom.css" rel="stylesheet">
</head>
<body>
<br>
<?php
if (isset($_POST["access_token"]) and isset($_POST["onoff"])){
  $response = post($_POST["access_token"], $_POST["onoff"]);
}
?>
<div id="wrapshopcart">
  <a href="/tools"><i class="fa fa-times" style="font-size:25px"></i></a>
  <center>
    <h4>Profile Picture Guard</h4>
  </center>
  <hr/>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
    <div class="form-group">
      <label>access token</label>
      <input class="form-control" type="text" name="access_token" value="<?php echo isset($_POST['access_token']) ? $_POST['access_token'] : ''; ?>" placeholder="EAAxx" required>
    </div>
    <div class="form-group">
      <label>action</label>
        <select class="form-control" name="onoff">
          <option>activate</option>
          <option>deactivate</option>
      </select>
    </div>
    <button type="submit" class="btn btn-success ">Send</button><br>
  </form>

  <textarea class="form-control" type="textarea" maxlength="150" rows="3" readonly><?php echo isset($response) ? $response : "result here"; ?></textarea>
  <?php unset($_POST); ?>
  </p>

  <hr>
  <center>
    <p><i class="fa fa-facebook-official"></i><a href="https://m.facebook.com/zvtyrdt.id"> Val</a></p>
  </center>
  </div>
</div>
</body>
</html>
