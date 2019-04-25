<?php

class Controller {

  protected $user = array('id' => 0);

  protected $passwordSalt = 'jJspr3lKsd';

  protected $statuses = array(
    1 => array('name' => 'חדשה', 'color' => 'red'),
    2 => array('name' => 'בעבודה', 'color' => 'yellow'),
    3 => array('name' => 'משלוח', 'color' => 'green'),
    4 => array('name' => 'סגורה', 'color' => 'white'),
    5 => array('name' => 'ביטול', 'color' => 'black')
  );

  protected $siteUrl;

  public function __construct() {
    if (isset($_SESSION['user']) && is_numeric($_SESSION['user']) && $_SESSION['user'] > 0) {
      if (($result = DB::connect()->query("SELECT * FROM users WHERE id = " . $_SESSION['user'])->fetch_assoc()) && $result['status'] == 1) {
        $this->user = $result;
      }
      else unset($_SESSION['user']);
    }
    $this->siteUrl = 'http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '') . '://' . $_SERVER['SERVER_NAME'];
  }

  public function getStatuses() {
    return $this->statuses;
  }

  public function getSiteUrl() {
    return $this->siteUrl;
  }

  public function getPasswordSalt() {
    return $this->passwordSalt;
  }

  public function getCurrentUser() {
    return $this->user;
  }

  public function indexAction() {
    return 'ok';
  }

  public function redirect($r) {
    header('Location: ' . $r);
    exit;
  }

  public function before() {
    
  }

  public function after() {
    
  }

  public function arg($num = 'all') {
    $url = explode('/', $this->getURL());
    return $num === 'all' ? $url : (array_key_exists($num, $url) ? $url[$num] : '');
  }

  public function getURL () {
    return preg_replace(array('/^\/*/', '/\?.*/'), '', $_SERVER['REQUEST_URI']);
  }

  public function json_for_js($arr) {
    return str_replace(array('\\', '\\\\u0022', '\u0022', "'"), array('\\\\', '\\u0022', '\\\"', "\'"), json_encode($arr, JSON_HEX_QUOT));
  }

  public function isValidEmail($e) {
    return preg_match('/^[\w-_.]+@[\w-_]+(\.[\w]{2,3}){1,2}$/', $e);
  }

  public function removeScripts($str) {
    while (preg_match('/(?:<script>|<\/script>)/', $str)) {
      if (preg_match('/<script[^>]*>[^<]*<\/script>/', $str)) $str = preg_replace('/<script[^>]*>[^<]*<\/script>/', '', $str);
      else $str = str_replace(array('<script>', '</script>'), '', $str);
    }
    return $str;
  }

  public function sendEventEmail($email, $event_name, $tokens = array()) {
    if ($event = DB::connect()->query("SELECT * FROM email_events WHERE event_key = '" . addslashes($event_name) . "'")->fetch_assoc()) {
      return mail($email, str_replace(array_keys($tokens), $tokens, $event['subject']), str_replace(array_keys($tokens), $tokens, $event['body']), 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=utf-8' . "\r\n");
    }
  }

  public function sendSmsEvent($numbers, $event_name, $tokens = array()) {
    if ($event = DB::connect()->query("SELECT * FROM sms_events WHERE event_key = '" . addslashes($event_name) . "'")->fetch_assoc()) {
      return $this->sendSMS($numbers, str_replace(array_keys($tokens), $tokens, $event['text']));
    }
  }

  public function sendSMS($numbers, $message) {
    $user = 'smart73';
    $password = '030410jas';
    $from = 'Creativecut';

    $xml = '<Inforu>' . PHP_EOL;
    $xml .= '<User>' . PHP_EOL;
    $xml .= '<Username>' . htmlspecialchars($user) . '</Username>' . PHP_EOL;
    $xml .= '<Password>' . htmlspecialchars($password) . '</Password>' . PHP_EOL;
    $xml .= '</User>' . PHP_EOL;
    $xml .= '<Content Type="sms">' . PHP_EOL;
    $xml .= '<Message>' . htmlspecialchars($message) . '</Message>' . PHP_EOL;
    $xml .= '</Content>' . PHP_EOL;
    $xml .= '<Recipients>' . PHP_EOL;
    $xml .= '<PhoneNumber>' . htmlspecialchars($numbers) . '</PhoneNumber>' . PHP_EOL;
    $xml .= '</Recipients>' . PHP_EOL;
    $xml .= '<Settings>' . PHP_EOL;
    $xml .= '<Sender>' . htmlspecialchars($from) . '</Sender>' . PHP_EOL;
    $xml .= '</Settings>' . PHP_EOL;
    $xml .= '</Inforu>';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://uapi.inforu.co.il/SendMessageXml.ashx?InforuXML=' . urlencode($xml));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
  }

  public function setMessage($message, $type = 'success') {
    $_SESSION['messages'][$type][] = $message;
  }

  public function getMessages() {
    if (isset($_SESSION['messages']) && is_array($_SESSION['messages'])) {
      foreach ($_SESSION['messages'] as $type => $messages) {
        if (is_array($messages) && in_array($type, array('success', 'warning', 'error'))) {
          echo '<div class="message ' . $type . '">';
          foreach ($messages as $message) {
            echo '<div>' . $message . '</div>';
          }
          echo '</div>';
        }
      }
      unset($_SESSION['messages']);
    }
  }
}


?>