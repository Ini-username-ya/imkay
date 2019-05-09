<?php
header('Content-Type: application/json');

session_start();
if (isset($_SESSION['LAST_CALL'])) {
    $last = strtotime($_SESSION['LAST_CALL']);
    $curr = strtotime(date("Y-m-d h:i:s"));
    $sec =  abs($last - $curr);
    if ($sec <= 4){
        $data = array("error" => true, "msg_error" => "Too Many Requests");
        header('Content-Type: application/json');
        die (json_encode($data));
    }
  }
$_SESSION['LAST_CALL'] = date("Y-m-d h:i:s");

function valuenime($url, $code){
    $result = array();

    $url = $url."/shows/".$code."/";
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $headers = array();
    $headers[] = "Host: www.randomanime.org";
    $headers[] = "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,q=0.8";
    $headers[] = "accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7,ms;q=0.6";
    $headers[] = "cache-control: max-age=0";
    $headers[] = "save-data: on";
    $headers[] = "upgrade-insecure-requests: 1";
    $headers[] = "user-agent: Mozilla/5.0 (Linux; Android 7.0; 5060 Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.109 Mobile Safari/537.36";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $html = curl_exec($ch);
    if (curl_errno($ch)) {
       echo '{"status":false,"msg_error":"'.curl_error($ch).'"}';
    }else{

       // base_url
       $result["url"] = $url;

       // image_url
       $result["image_url"] = $url.'/images/shows/'.$code.'/anime-l.jpg';

       // information
       preg_match('/(?s)\<div class\=\"quick-info\"\>(.*?)\<li class\="more/', $html, $info);
       $info = str_replace('</span><span>', ', ', $info[1]);
       $info = preg_replace('/\<.*?\>/', '', $info);
       foreach (explode("\n", $info) as $num => $value){
           $r = explode(": ", $value);
           if (isset($r[1])){
               $result['information'][$r[0]] = $r[1];
           }
       }

       // description
       preg_match("/\<p itemprop\=\'about\'\>(.*?)\<a href/", $html, $desc);
       $desc = preg_replace('/\<.*?\>/', '', $desc[1]);
       preg_match("/<span class\=\'extended\'\>(.*?)\<a href/", $html, $extend);
       $desc .= preg_replace('/\<.*?\>/', '', $extend[1]);
       if ($desc != ""){
           $result["description"] = $desc;
       }

       // watch
       preg_match_all('/<a href\=\"(.*?)\" class\=\"btn btn-primary\".*?Sub/', $html, $watch);
       foreach ($watch[1] as $key => $url){
           preg_match("/^.*?\.(.*?)\./", $url, $dom);
           $result["watch"][$dom[1]] = $url;
       }

       // status
       $result["status"] = true;

       echo json_encode($result);

    }
}

function valnime(){
    $url = 'https://www.randomanime.org';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url.'/scripts/php-scripts/get-list-ids.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, '{"listInfo":{"includedGenres":["0"],"excludedGenres":[]},"single":true}');
    curl_setopt($ch, CURLOPT_POST, 1);

    $headers = array();
    $headers[] = "Host: www.randomanime.org";
    $headers[] = "accept: application/json, text/plain, */*";
    $headers[] = "accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7,ms;q=0.6";
    $headers[] = "content-length: 71";
    $headers[] = "content-type: application/json;charset=UTF-8";
    $headers[] = "origin: https://www.randomanime.org";
    $headers[] = "referer: https://www.randomanime.org/";
    $headers[] = "save-data: on";
    $headers[] = "user-agent: Mozilla/5.0 (Linux; Android 7.0; 5060 Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.109 Mobile Safari/537.36";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
       echo '{"status":false,"msg_error":"'.curl_error($ch).'"}';
    }else{
       $code = json_decode($result, true)[1];
       return array($url, $code);
    }
}

$next_page = valnime();
valuenime($next_page[0], $next_page[1]);

?>
