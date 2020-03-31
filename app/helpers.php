<?php

// stable 

require_once 'db_config.php';

error_reporting(0);

if (!function_exists('old')) {
// save old inputs and restore them 
  function old($argument){
    return $_REQUEST[$argument] ?? '';
  }
}




if (!function_exists('csrf_token')) {
  // create csrf token for verify steps 
  function csrf_token($length = 35){

    $token = "";
    $codealphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codealphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codealphabet.= "0123456789";
    $codealphabet.= "!@#$%^&*({[]})";
    $max_letters = strlen($codealphabet);

    // $token = bin2hex(openssl_random_pseudo_bytes(70));

    for ($i=0; $i < $length; $i++) {
        $token .= $codealphabet[random_int(0, $max_letters-1)];
    }

    $_SESSION['csrf_token'] = $token;
    return $token;
  }
}




if (!function_exists('auth_user')) {
  // get the user author 
  function auth_user(){

    $auth = false;

    if (isset($_SESSION['user_id'])) {

      if (isset($_SESSION['user_ip']) && $_SESSION['user_ip'] == $_SERVER['REMOTE_ADDR']) {

        if (isset($_SESSION['user_agent']) && $_SESSION['user_agent'] == $_SERVER['HTTP_USER_AGENT']) {

          $auth = true;
        }
      }
    }

    return $auth;
  }
}



if (!function_exists('email_exist')) {
  // check if the email is already in the DB
  function email_exist($email, $link){

    $sql = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {

      return true;
    } else {

      return false;
    }
  }
}



if (!function_exists('check_avatar')) {

  function check_avatar($file){

    $valid = false;

    $allowed = [
      // size = 6mb
      'max_file_size' => 1024 * 1024 * 6, 
      // allowed file types
      'ex' => ['jpg', 'jpeg', 'gif', 'png', 'bmp'],
      // types list
      'mimes' => ['image/jpeg', 'image/gif', 'image/png', 'image/bmp']
    ];

    if (isset($file['image']['size']) && $file['image']['size'] <= $allowed['max_file_size']) {

      if (isset($file['image']['type']) && in_array(strtolower($file['image']['type']), $allowed['mimes'])) {

        if (isset($file['image']['name'])) {

          $file_detailed = pathinfo($file['image']['name']);

          if (in_array(strtolower($file_detailed['extension']), $allowed['ex'])) {

            if (is_uploaded_file($file['image']['tmp_name'])) {

              $valid = true;
            }
          }
        }
      }
    }

    return $valid;
  }
}



if(!function_exists('message_alert')){
  // alert message from the system and etc
  function message_alert(){
    $message = $_SESSION['message'] ?? false;
if($message){

echo '<div class="container fixed-bottom">
<div class="alert alert-success alert-dismissible border border-dark rounded">
  <button style="user-select: none;" type="button" class="close" data-dismiss="alert">&times;</button>
  <strong><span>Success! </span></strong>' . $_SESSION['message'] .'
</div></div>';

unset($_SESSION['message']);
}
  }
}




if(!function_exists('error_alert')){
  // alert system message / error
  function error_alert(){
    $message = $_SESSION['error_alert'] ?? false;
if($message){

echo '<div class="container fixed-bottom">
<div class="alert alert-danger alert-dismissible border border-dark rounded">
  <button style="user-select: none;" type="button" class="close" data-dismiss="alert">&times;</button>
  <strong><span>System Alert! </span></strong>' . $_SESSION['error_alert'] .'
</div></div>';

unset($_SESSION['error_alert']);
}
  }
}




if(!function_exists('user_os')){
  $user_agent = $_SERVER["HTTP_USER_AGENT"];
function user_os() { 
    global $user_agent;
    $os_platform =   "Unknown OS Platform";
    $os_array =   array(
      // Systems options
        '/windows nt 10/i'     =>  'Windows 10',
        '/windows nt 6.3/i'     =>  'Windows 8.1',
        '/windows nt 6.2/i'     =>  'Windows 8',
        '/windows nt 6.1/i'     =>  'Windows 7',
        // old windows OG (list)
        '/windows nt 6.0/i'     =>  'Windows Vista',
        '/windows nt 5.2/i'     =>  'Windows Server 2003/Xx64',
        '/windows nt 5.1/i'     =>  'Windows XP',
        '/windows xp/i'         =>  'Windows XP',
        '/windows nt 5.0/i'     =>  'Windows 2000',
        '/windows me/i'         =>  'Windows ME',
        '/win98/i'              =>  'Windows 98',
        '/win95/i'              =>  'Windows 95',
        '/win16/i'              =>  'Windows 3.11',
        '/macintosh|mac os x/i' =>  'Mac OS X',
        '/mac_powerpc/i'        =>  'Mac OS 9',
        '/linux/i'              =>  'Linux',
        '/ubuntu/i'             =>  'Ubuntu',
        '/iphone/i'             =>  'iPhone',
        '/ipod/i'               =>  'iPod',
        '/ipad/i'               =>  'iPad',
        '/android/i'            =>  'Android',
        '/blackberry/i'         =>  'BlackBerry',
        '/webos/i'              =>  'Mobile',
                        );
    foreach ($os_array as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }   
    return $os_platform;
}
  }




  if(!function_exists('webhook_post')){
    // this function sends me an update evertime you call it and sends me a webhook notflication to my discordapp.com account

    // you can see updates at https://discord.gg/geZT5uY

    function webhook_post($message = 'null'){
      $webhook_name = $_SESSION['user_name'] . ' (ID: ' . $_SESSION['user_id'] . ") [Webhook] " ?? "Discord Portal Update";

      $webhookurl = "https://discordapp.com/api/webhooks/690635915680284803/AIdVn4NG--pKG8Wh6P0krMniogywn5dNXIhYtPbPJeh8ph3CuMEni1zJi1jHsoQdwqb8";
      $timestamp = date("c", strtotime("now"));

$json_data = json_encode([
    // Message
    "content" => "$message",
    "username" => $webhook_name,
    "tts" => false
            
        ]
);


$ch = curl_init( $webhookurl );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch ); 
curl_close( $ch );
    }
  }




if(!function_exists('server_count')){
  function server_count($server_id = 596854473167470594){
    $members = json_decode(file_get_contents("https://discordapp.com/api/guilds/$server_id/widget.json"), true)['members'];
$membersCount = 1;
foreach ($members as $member) {
    if ($member['status']) {
        $membersCount++;
    }
}
return $membersCount;
  }
}


if(!function_exists('page_location')){
  function page_location($res){
    $uri = $res;
    $uri = str_replace('/', ' ' , $uri);
    return $uri;
  }
}