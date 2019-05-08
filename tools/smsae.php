<?php

$headers = array(
  "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,q=0.8",
  "Accept-Language: id-ID,en-US;q=0.9",
  "Connection: keep-alive",
  "Host: sms.payuterus.biz",
  "Upgrade-Insecure-Requests: 1",
  "User-Agent: Mozilla/5.0 (Linux; Android 7.0; 5060 Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/65.0.3325.109 Mobile Safari/537.36",
  "X-Requested-With: com.smsGratisSeluruhIndonesia64"
);

function getCaptcha(){
  global $headers, $ch;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "http://sms.payuterus.biz/alpha/");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
  curl_setopt($ch, CURLOPT_HEADER, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $response = curl_exec($ch);

  $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
  $header = substr($response, 0, $header_size);
  $body = substr($response, $header_size);

  if (curl_errno($ch)) {
    echo '{"status":false,"data":[],"msg_error":"'.curl_error($ch).'"}';
  }else{
    preg_match_all("/Set.*?((?:__cfduid|PHPSESSID).*?);/", $header, $cookies);
    $cook = "Cookie: ".$cookies[1][0]."; ".$cookies[1][1];

    preg_match("/<span>(.*?) = <\/span>/", $body, $captcha);
    return array($captcha[1], eval('return '.$captcha[1].';'), $cook);
  }
}

function sendMessage($nohp, $message, $chall, $captcha, $sess){
  global $headers, $ch;

  $fields = array(
    "nohp" => $nohp,
    "pesan" => $message,
    "captcha" => $captcha,
  );

  $end = http_build_query($fields);
  curl_setopt($ch, CURLOPT_URL, 'http://sms.payuterus.biz/alpha/send.php');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $end);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($ch, CURLOPT_POST, 1);

  $headers[] = "Cache-Control: max-age=0";
  $headers[] = "Content-Type: application/x-www-form-urlencoded";
  $headers[] = "Host: sms.payuterus.biz";
  $headers[] = "Origin: http://sms.payuterus.biz";
  $headers[] = "Referer: http://sms.payuterus.biz/alpha/";
  $headers[] = $sess;
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $html = curl_exec($ch);
  if (curl_errno($ch)) {
    return '{"status":false,"msg_error":"'.curl_error($ch).'"}';
  }else{
    $response = array("status" => true, "nohp" => $nohp, "pesan" => $message, "captcha" => array(
        "chall" => $chall,
        "result" => $captcha
      )
    );
    if (strpos($html, "Telah Dikirim")){
      $response["result"]["error"] = false;
      $response["result"]["message"] = "SMS Gratis Telah Dikirim @zvtyrdt.id";
    }else{
      $response["result"]["error"] = true;
      $response["result"]["message"] = "SMS Gratis Gagal Dikirim @zvtyrdt.id";
    }
    return json_encode($response);
  }
}
?>

<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta content="Val" name="author">

<title>IMKAY - sms gratis</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<style type="text/css">
    #wrapshopcart{width:350px;margin:auto;padding:20px;
     padding-bottom: 1px;margin-bottom: 20px;background:#fff;box-shadow:0 0 5px #c1c1c1;border-radius:5px;}
    #response{
        text-align: center;
    }
    #EE{
        width: 50%;
    }
    textarea { resize:none; }
    #count{
        text-align: right;
    }

</style>
</head>
<body>
<br>
  <?php
     if (isset($_POST["nomor"]) and isset($_POST["pesan"])){
       $captcha = getCaptcha();
       $response = sendMessage($_POST["nomor"], $_POST["pesan"], $captcha[0], $captcha[1], $captcha[2]);
     }
  ?>

<div id="wrapshopcart">
  <a href="/tools">
    <i class="fa fa-times" style="font-size:25px">
    </i>
  </a>
  <center>
    <br><h4>IMKAY - free sms sender</h4>
  </center>
  <hr/>
  <div class="form-group">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
      <label>nomor telepon</label>
      <input class="form-control" type="text" name="nomor" value="<?php echo isset($_POST['nomor']) ? $_POST['nomor'] : ''; ?>" placeholder="Contoh: 628xxxx" required><br>
      <label>pesan</label>
      <textarea class="form-control sm-up" name="pesan" rows="3"><?php echo isset($_POST['pesan']) ? $_POST['pesan'] : ''; ?></textarea><br>
      <button type="submit" class="btn btn-success">kirim</button>
    </form>
  <textarea class="form-control" type="textarea" maxlength="150" rows="3" readonly> <?php echo $response; ?></textarea>
  <hr>
  <center>
    <p>
      &copy; 2019&nbsp;
      <a href="/">
        IMKAY
      </a>&nbsp;
      <i class="fa fa-facebook-official"></i>
      <a href="https://m.facebook.com/zvtyrdt.id">
        zvtyrdt.id
      </a>
    </p>
  </center>
  </div>
</div>
</body>
</html>

