<?php

class IndexController extends Controller {

  public $agreeRules;

  public function __construct() {
    parent::__construct();
    //$this->agreeRules = str_replace("\n", '<br>', file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/rules.txt'));
    $this->agreeRules = '';
    for ($i = 1; $i <= 11; $i++) {
      $this->agreeRules .= '<img style="max-height:none;" src="/rules/' . $i . '.jpg">';
    }
  }

  public function indexAction() {
    //if (isset($_GET['asd'])) {
    //  include $_SERVER['DOCUMENT_ROOT'] . '/helpers/GraphicModuleFile.php';
    //  $test = new GraphicModuleFile($_SERVER['DOCUMENT_ROOT'] . '/123.dxf');
    //  $data = $test->getData();
    //  echo '<pre>' . print_r($data, 1) . '</pre>';
    //  exit;
    //}
    $url = parse_url($_SERVER['REQUEST_URI']);
    if ($url['path'] == '/') {
      if ($this->user['id']) {
        return Views::getContent('base', array('user' => $this->user, 'content' => Views::getContent('index')));
      }
      else {
        return Views::getContent('authorization', array('specialties' => Models::get('Specialties')->get()));
      }
    }
    else {
      return Views::getContent('404');
    }
  }

  public function fileAction() {
    if ($this->user['id']) {
      if (($bid = Models::get('Bids')->get($this->arg(1))) && $bid['user_id'] == $this->user['id']) {
        $_SESSION['current_file_id'] = $bid['id'];
        $cutting_types = array();
        $result = DB::connect()->query("SELECT * FROM cutting_types ORDER BY id DESC");
        while ($res = $result->fetch_assoc()) {
          $cutting_types[$res['id']] = $res;
        }
    
        $material_sizes = array();
        $result = DB::connect()->query("SELECT * FROM material_sizes ORDER BY id DESC");
        while ($res = $result->fetch_assoc()) {
          $material_sizes[$res['id']] = $res;
        }
    
        $materials = array();
        $result = DB::connect()->query("SELECT mc.* FROM material_categories mc INNER JOIN materials m ON m.category = mc.id ORDER BY id DESC");
        while ($res = $result->fetch_assoc()) {
          $res['image'] = CropImage::getImage($res['image'], '50x50');
          $materials[$res['id']] = $res;
        }
    
        $result = DB::connect()->query("SELECT * FROM materials ORDER BY id DESC");
        while ($res = $result->fetch_assoc()) {
          if (isset($materials[$res['category']])) {
            if ($res['prices'] = @unserialize($res['prices'])) {
              foreach ($res['prices']['images'] as &$image) {
                $image = CropImage::getImage($image, '200x200');
              }
            }
            $res['image'] = CropImage::getImage($res['image'], '50x50');
            $materials[$res['category']]['materials'][$res['id']] = $res;
          }
        }
  
        $all_options = array();
        $result = DB::connect()->query("SELECT * FROM options");
        while ($res = $result->fetch_assoc()) {
          $all_options[$res['name']] = $res['value'];
        }
        $options = array(
          'laser_price_per_minute' => isset($this->user['specialty']) && isset($all_options['laser_price_per_minute_' . $this->user['specialty']]) && $all_options['laser_price_per_minute_' . $this->user['specialty']] && is_numeric($all_options['laser_price_per_minute_' . $this->user['specialty']]) ? $all_options['laser_price_per_minute_' . $this->user['specialty']] : (isset($all_options['laser_price_per_minute']) && $all_options['laser_price_per_minute'] && is_numeric($all_options['laser_price_per_minute']) ? $all_options['laser_price_per_minute'] : 0),
          'distance_between_objects_speed' => isset($all_options['distance_between_objects_speed']) && is_numeric($all_options['distance_between_objects_speed']) ? $all_options['distance_between_objects_speed'] : 0,
          'distance_between_objects_price' => isset($all_options['distance_between_objects_price']) && is_numeric($all_options['distance_between_objects_price']) ? $all_options['distance_between_objects_price'] : 0,
          'tax' => isset($all_options['tax']) && is_numeric($all_options['tax']) ? $all_options['tax'] : 0,
          'price_minimum' => isset($this->user['specialty']) && isset($all_options['price_minimum_' . $this->user['specialty']]) && $all_options['price_minimum_' . $this->user['specialty']] && is_numeric($all_options['price_minimum_' . $this->user['specialty']]) ? $all_options['price_minimum_' . $this->user['specialty']] : (isset($all_options['price_minimum']) && $all_options['price_minimum'] && is_numeric($all_options['price_minimum']) ? $all_options['price_minimum'] : 0),
        );

        return Views::getContent('base', array('user' => $this->user, 'title' => $bid['file_name'], 'content' => Views::getContent('file', array('cutting_types' => $this->json_for_js($cutting_types), 'material_sizes' => $this->json_for_js($material_sizes), 'materials' => $this->json_for_js($materials), 'options' => $this->json_for_js($options), 'units_of_measurement' => array('mm' => 1, 'sm' => 10), 'user' => $this->user, 'bid' => $bid))));
      }
      else {
        return Views::getContent('404');
      }
    }
    else {
      $this->redirect('/');
    }
  }

  public function registrationAction() {
    return Views::getContent('registration', array('specialties' => Models::get('Specialties')->get()));
  }

  public function personalAction() {
    if ($this->user['id']) {
      $errors = array();
      $specialties = Models::get('Specialties')->get();
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_POST['name']) || !is_string($_POST['name']) || !$_POST['name']) {
          $errors['name'] = 'Name is required';
        }
        if (!isset($_POST['surname']) || !is_string($_POST['surname']) || !$_POST['surname']) {
          $errors['surname'] = 'Surname is required';
        }
        if (!isset($_POST['email']) || !is_string($_POST['email']) || !$_POST['email']) {
          $errors['email'] = 'Email is required';
        }
        elseif (!$this->isValidEmail($_POST['email'])) {
          $errors['email'] = 'Wrong format';
        }
        elseif (($user = Models::get('Users')->get(array('email' => $_POST['email']))) && !isset($user[$this->user['id']])) {
          $errors['email'] = 'User with this email already exists';
        }
        if (!isset($_POST['phone']) || !is_string($_POST['phone']) || !$_POST['phone']) {
          $errors['phone'] = 'Phone is required';
        }
        elseif (!preg_match('/^(?:\+(?: )?)?(?:\d+ |\d+-)*\d+$/', $_POST['phone'])) {
          $errors['phone'] = 'Wrong format';
        }
        if ($this->user['specialty'] == 1 && isset($_POST['educational_institution']) && !is_string($_POST['educational_institution'])) {
          $errors['educational_institution'] = 'Wrong educational institution';
        }
        if ($this->user['specialty'] == 1 && isset($_POST['department']) && !is_string($_POST['department'])) {
          $errors['department'] = 'Wrong department';
        }
        if (isset($_POST['city']) && !is_string($_POST['city'])) {
          $errors['city'] = 'Wrong city';
        }
        if (isset($_POST['street']) && !is_string($_POST['street'])) {
          $errors['street'] = 'Wrong street';
        }
        if (isset($_POST['house_number']) && !is_string($_POST['house_number'])) {
          $errors['house_number'] = 'Wrong house number';
        }
        if (isset($_POST['post_index']) && !is_string($_POST['post_index'])) {
          $errors['post_index'] = 'Wrong house number';
        }
        if (isset($_POST['password']) && !is_string($_POST['password'])) {
          $errors['password'] = 'Wrong password';
        }
        if (isset($_FILES['image']['error']) && !$_FILES['image']['error'] && !@getimagesize($_FILES['image']['tmp_name'])) {
          $errors['image'] = 'Wrong file type';
        }

        if (!$errors) {
          $_POST['id'] = $this->user['id'];
          if (isset($_FILES['image']['error']) && !$_FILES['image']['error']) {
            $_POST['image'] = CropImage::saveUploadedImage($_FILES['image']['tmp_name']);
            CropImage::deleteImage($this->user['image']);
          }
          elseif (isset($_POST['delete_image'])) {
            $_POST['image'] = '';
            CropImage::deleteImage($this->user['image']);
          }
          elseif (isset($_POST['image'])) unset($_POST['image']);
          if (isset($_POST['status'])) unset($_POST['status']);
          if (isset($_POST['social'])) unset($_POST['social']);
          if (isset($_POST['newbie'])) unset($_POST['newbie']);
          if (isset($_POST['specialty'])) unset($_POST['specialty']);
          if (isset($_POST['register_date'])) unset($_POST['register_date']);
          if ($this->user['specialty'] != 1 && isset($_POST['educational_institution'])) unset($_POST['educational_institution']);
          if ($this->user['specialty'] != 1 && isset($_POST['department'])) unset($_POST['department']);
          if (isset($_POST['password']) && (!is_string($_POST['password']) || !$_POST['password'])) unset($_POST['password']);
          Models::get('Users')->save($_POST);
          $this->setMessage('הנתונים נשמרו בהצלחה');
          $this->redirect('/personal');
        }
      }
      return Views::getContent('base', array('user' => $this->user, 'title' => 'פרופיל', 'content' => Views::getContent('personal', array('user' => $_SERVER['REQUEST_METHOD'] == 'POST' ? array_merge($this->user, $_POST) : $this->user, 'specialties' => $specialties, 'errors' => $errors))));
    }
    else {
      return Views::getContent('403');
    }
  }

  public function yourObjectsAction() {
    if ($this->user['id']) {
      return Views::getContent('base', array('user' => $this->user, 'title' => 'קבצים והזמנות', 'content' => Views::getContent('your_objects', array(
        'bids' => Models::get('Bids')->getByUser($this->user['id']),
        'cutting_types' => Models::get('materialsCategoriesSizes')->getCuttingTypes(),
        'materials' => Models::get('materialsCategoriesSizes')->getMaterials(),
        'materials_categories' => Models::get('materialsCategoriesSizes')->getMaterialsCategories(),
        'materials_sizes' => Models::get('materialsCategoriesSizes')->getMaterialsSizes(),
        'link' => 'your-objects'
      ))));
    }
    else {
      return Views::getContent('403');
    }
  }

  public function yourOrdersAction() {
    if ($this->user['id']) {
      $orders = Models::get('Orders')->getOrders(false, $this->user['id']);
      $navigation = new Navigation(20, isset($_GET['page']) ? $_GET['page'] : 1, $orders);
      return Views::getContent('base', array('user' => $this->user, 'title' => 'Your orders', 'content' => Views::getContent('your_orders', array(
        'orders' => $navigation->getMaterialsList(),
        'pager' => $navigation->getPager()
      ))));
    }
    else {
      return Views::getContent('403');
    }
  }

  public function publicFilesAction() {
    if ($this->user['id']) {
      $args = array();
      $files = Models::get('Bids')->getPublic();
      $navigation = new Navigation(20, isset($_GET['page']) ? $_GET['page'] : 1, $files);
      $args['bids'] = $navigation->getMaterialsList();
      $args['pager'] = $navigation->getPager();
      $args['link'] = 'public-files';
      $args['cutting_types'] = Models::get('materialsCategoriesSizes')->getCuttingTypes();
      $args['materials'] = Models::get('materialsCategoriesSizes')->getMaterials();
      $args['materials_categories'] = Models::get('materialsCategoriesSizes')->getMaterialsCategories();
      $args['materials_sizes'] = Models::get('materialsCategoriesSizes')->getMaterialsSizes();
      return Views::getContent('base', array('user' => $this->user, 'title' => 'Your objects', 'content' => Views::getContent('your_objects', $args)));
    }
    else {
      return Views::getContent('403');
    }
  }

  public function login($id, $redirect = '/') {
    $_SESSION['user'] = $id;
    $symbols = 'abcdefghijklmnopqrstuvwxyz';
    $bid_confirm_hash = '';
    while (strlen($bid_confirm_hash) < 30) {
      $bid_confirm_hash .= $symbols[rand(0, strlen($symbols) - 1)];
    }
    $_SESSION['bid_confirm_hash'] = $bid_confirm_hash;
    $res = Models::get('Users')->get(array('id' => $id));
    setcookie('user_is_newbie', /*$res[$id]['newbie'] === '1' ? 'yes' : */'no', 0, '/');
    if (isset($_SESSION['user_additional_data'])) unset($_SESSION['user_additional_data']);
    if ($redirect) $this->redirect($redirect);
  }

  public function loginAction() {
    if (!$this->user['id'] && $_SERVER['REQUEST_METHOD'] == 'POST') {
      $errors = array();
      if (!isset($_POST['email']) || !is_string($_POST['email']) || !$_POST['email']) {
        $errors['email'] = 'Введите Email';
      }
      if (!isset($_POST['password']) || !is_string($_POST['password']) || !$_POST['password']) {
        $errors['password'] = 'Введите пароль';
      }
      if (!$errors && !$result = DB::connect()->query("SELECT id, status FROM users WHERE email = '" . addslashes($_POST['email']) . "' AND password != '' AND password = '" . md5($_POST['password'] . $this->passwordSalt) . "'")->fetch_assoc()) {
        $errors['password'] = 'Неверный Email или пароль';
      }
      if (isset($result) && $result) {
        switch ($result['status']) {
          case 0: $errors['email'] = 'Ваш аккаунт еще не активен'; break;
          case 2: $errors['email'] = 'Ваш аккаунт заблокирован'; break;
        }
      }

      if (!$errors) {
        $this->login($result['id']);
      }
      else {
        $specialties = Models::get('Specialties')->get();
        return Views::getContent('authorization', array('specialties' => $specialties, 'login_errors' => $errors, 'login' => $_POST));
      }
    }
    else $this->redirect('/');
  }

  public function logoutAction() {
    unset($_SESSION['user']);
    unset($_SESSION['bid_confirm_hash']);
    unset($_SESSION['current_file_id']);
    setcookie('user_is_newbie', '', 1, '/');
    $this->redirect('/');
  }

  public function registerAction() {
    if (!$this->user['id'] && $_SERVER['REQUEST_METHOD'] == 'POST') {
      $specialties = Models::get('Specialties')->get();

      $errors = array();
      if (!isset($_POST['name']) || !is_string($_POST['name']) || !$_POST['name'] || !$this->removeScripts($_POST['name'])) {
        $errors['name'] = 'יש למלא שם';
      }
      if (!isset($_POST['surname']) || !is_string($_POST['surname']) || !$_POST['surname'] || !$this->removeScripts($_POST['surname'])) {
        $errors['surname'] = 'יש למלא שם משפחה';
      }
      if (!isset($_POST['email']) || !is_string($_POST['email']) || !$_POST['email']) {
        $errors['email'] = 'Введите Email';
      }
      elseif (!$this->isValidEmail($_POST['email'])) {
        $errors['email'] = 'Неверный формат';
      }
      elseif (Models::get('Users')->get(array('email' => $_POST['email']))) {
        $errors['email'] = 'Пользователь с таким Email уже существует';
      }
      if (!isset($_POST['phone']) || !is_string($_POST['phone']) || !$_POST['phone']) {
        $errors['phone'] = 'Введите телефон';
      }
      elseif (!preg_match('/^\d{10}$/', $_POST['phone'])) {
        $errors['phone'] = 'Неверный формат';
      }
      if (!isset($_POST['phone_code']) || !is_string($_POST['phone_code']) || !preg_match('/^\d{5}$/', $_POST['phone_code'])) {
        $errors['phone_code'] = 'Неверный код';
      }
      elseif (!isset($errors['phone']) && !Models::get('PhoneCode')->checkPhoneCode($_POST['phone'], $_POST['phone_code'])) {
        $errors['phone_code'] = 'Этот код не подходит для этого телефона';
      }
      if (!isset($_POST['password']) || !is_string($_POST['password']) || !$_POST['password']) {
        $errors['password'] = 'Введите пароль';
      }
      if (!isset($_POST['specialty']) || !is_numeric($_POST['specialty']) || !$_POST['specialty']) {
        $errors['specialty'] = 'Выберите вашу область специализации';
      }
      elseif (!array_key_exists($_POST['specialty'], $specialties)) {
        $errors['specialty'] = 'Неправильная специальность';
      }
      if (!isset($_POST['agree-rules'])) {
        $errors['agree-rules'] = 'Условия использования должны быть подтверждены';
      }

      if (!$errors) {
        if (isset($_POST['id'])) unset($_POST['id']);
        $_POST['status'] = 1;
        $_POST['newbie'] = 1;
        $_POST['register_date'] = time();
        Models::get('Users')->save($_POST);
        $user_id = DB::connect()->insert_id;
        $this->sendEventEmail($_POST['email'], 'register_event', array('!name' => $_POST['name'], '!surname' => $_POST['surname']));
        Models::get('PhoneCode')->deleteByPhone($_POST['phone']);
        $this->login($user_id);
      }
      else {
        return Views::getContent(isset($_POST['page']) && $_POST['page'] == 'registration' ? 'registration' : 'authorization', array('specialties' => $specialties, 'register_errors' => $errors, 'register' => $_POST));
      }
    }
    else $this->redirect('/');
  }

  public function forgotPasswordAction() {
    if ($this->user['id']) {
      $this->redirect('/');
    }
    else {
      return Views::getContent('forgot_password');
    }
  }

  public function sendSmsAction() {
    try {
      if ($_SERVER['REQUEST_METHOD'] != 'POST') throw new Exception('Bad request');
      if (!isset($_POST['phone_number']) || !preg_match('/^\d{10}$/', $_POST['phone_number'])) throw new Exception('Wrong phone format');
      if (Models::get('Users')->get(array('phone' => $_POST['phone_number']))) throw new Exception('This phone already in use');

      return Models::get('PhoneCode')->sendCode($_POST['phone_number']);
    }
    catch (Exception $e) {
      return $e->getMessage();
    }
  }

  public function saveFileAction() {
    if ($this->user['id']) {
      require_once 'helpers/GraphicModuleFile.php';

      if (in_array($ext = strtolower(substr(strrchr($_FILES['graphic_module_file']['name'], '.'), 1)), GraphicModuleFile::getAllowedExtensions()) && isset($_POST['file_name']) && is_string($_POST['file_name']) && $_POST['file_name']) {
        DB::connect()->query("INSERT INTO bids (date, file, file_name, user_id, material, size, status, data, paid, public) VALUES(" . time() . ", '', '" . (addslashes($bid_file_name = $this->removeScripts(strip_tags($_POST['file_name'])))) . "', " . $this->user['id'] . ", '', '', 1, '', 0, " . (isset($_POST['public']) && in_array($_POST['public'], array(1, 0)) ? $_POST['public'] : 0) . ")");
        $id = DB::connect()->insert_id;
        $file_name = $id . '.' . $ext;
        DB::connect()->query("UPDATE bids SET file = '$file_name' WHERE id = $id");
        $file_name = $_SERVER['DOCUMENT_ROOT'] . '/graphic_files/' . $file_name;
        move_uploaded_file($_FILES['graphic_module_file']['tmp_name'], $file_name);
        echo json_encode(array('status' => 'success', 'id' => $id));
      }
      else {
        echo json_encode(array('status' => 'error', 'type' => 'Supported only ' . implode(', ', GraphicModuleFile::getAllowedExtensions()) . ' extensions'));
      }
    }
  }

  public function loadFileAction() {
    require_once 'helpers/GraphicModuleFile.php';

    if (isset($_POST['file_id']) && is_numeric($_POST['file_id']) && ($bid = Models::get('Bids')->get($_POST['file_id'])) && $bid['user_id'] == $this->user['id']) {
      $graphicModuleFile = new GraphicModuleFile($_SERVER['DOCUMENT_ROOT'] . '/graphic_files/' . $bid['file']);
      echo json_encode(array('status' => 'success', 'data' => $graphicModuleFile->getData(), 'id' => $_SESSION['bid_confirm_hash'] . $bid['id'], 'file_name' => $bid['file_name']));
    }
    else {
      echo json_encode(array('status' => 'error', 'type' => 'Wrong file'));
    }
  }

  public function saveBidAction() {
    if ($this->user['id']) {
      $turn = false;
      $materials = array();
      $result = DB::connect()->query("SELECT id FROM materials");
      while ($res = $result->fetch_assoc()) {
        $materials[] = $res['id'];
      }
  
      $sizes = array();
      $result = DB::connect()->query("SELECT id FROM material_sizes");
      while ($res = $result->fetch_assoc()) {
        $sizes[] = $res['id'];
      }
  
      if (preg_match_all('/^([a-z]+)(\d+)$/', $_POST['bidId'], $matches) && $matches[1][0] == $_SESSION['bid_confirm_hash'] && ($bid = Models::get('Bids')->get($matches[2][0])) && $bid['user_id'] == $this->user['id'] && isset($_POST['material']) && is_numeric($_POST['material']) && in_array($_POST['material'], $materials) && isset($_POST['size']) && is_numeric($_POST['size']) && in_array($_POST['size'], $sizes) && isset($_POST['cutting_types_values']) && is_array($_POST['cutting_types_values']) && $_POST['cutting_types_values'] && isset($_POST['preview']) && is_string($_POST['preview']) && $_POST['preview']) {
        $error = '';
        $material_category = DB::connect()->query("SELECT c.* FROM materials m INNER JOIN material_categories c ON c.id = m.category WHERE m.id = " . $_POST['material'])->fetch_assoc();

        if (!$material_category) {
          $error = 'Wrong category';
        }
        elseif (!isset($_POST['work_width']) || !is_numeric($_POST['work_width']) || $_POST['work_width'] <= 0 || !isset($_POST['work_height']) || !is_numeric($_POST['work_height']) || $_POST['work_height'] <= 0) {
          $error = 'Wrong work width or height';
        }
        elseif ((floatval($material_category['max_width']) && $_POST['work_width'] > $material_category['max_width']) || (floatval($material_category['max_height']) && $_POST['work_height'] > $material_category['max_height'])) {
          if ((floatval($material_category['max_width']) && $_POST['work_height'] > $material_category['max_width']) || (floatval($material_category['max_height']) && $_POST['work_width'] > $material_category['max_height'])) {
            if (floatval($material_category['max_width']) && $_POST['work_width'] > $material_category['max_width']) {
              $error = 'גודל הקובץ עבור ' . $material_category['name'] . ' גדול מדי, אנא פצל את הקובץ לגודל מקסימלי של ' . $material_category['max_width'] . '/' . $material_category['max_height'] . ' מ"מ';
            }
            if (floatval($material_category['max_height']) && $_POST['work_height'] > $material_category['max_height']) {
              $error = 'גודל הקובץ עבור ' . $material_category['name'] . ' גדול מדי, אנא פצל את הקובץ לגודל מקסימלי של ' . $material_category['max_width'] . '/' . $material_category['max_height'] . ' מ"מ';
            }
          }
          else {
            $turn = true;
          }
        }
        if (!isset($_POST['total_price']) || !is_numeric($_POST['total_price']) || $_POST['total_price'] <= 0) {
          $error = 'Wrong price';
        }
        if (!isset($_POST['tax']) || !is_numeric($_POST['tax']) || $_POST['tax'] <= 0) {
          $error = 'Wrong tax';
        }

        if (!$error) {
          Models::get('Orders')->getNewOrder();
          if ($bid['data']) $bid = Models::get('Bids')->copy($bid['id']);
          $data = array(
            'work_width' => isset($_POST['work_width']) ? $_POST['work_width'] + 20 : 0,
            'work_height' => isset($_POST['work_height']) ? $_POST['work_height'] + 20 : 0,
            'total_price' => isset($_POST['total_price']) ? $_POST['total_price'] : 0,
            'tax' => isset($_POST['tax']) ? $_POST['tax'] : 0,
            'total_length' => isset($_POST['total_length']) && is_numeric($_POST['total_length']) ? $_POST['total_length'] : 0,
            'total_area' => isset($_POST['total_area']) && is_numeric($_POST['total_area']) ? $_POST['total_area'] : 0
          );
          foreach ($_POST['cutting_types_values'] as $cutting_types_values) {
            $data['cutting_types_values'][] = array(
              'line_length' => isset($cutting_types_values['line_length']) && is_numeric($cutting_types_values['line_length']) ? $cutting_types_values['line_length'] : 0,
              'area' => isset($cutting_types_values['area']) && is_numeric($cutting_types_values['area']) ? $cutting_types_values['area'] : 0,
              'price' => isset($cutting_types_values['price']) && is_numeric($cutting_types_values['price']) ? $cutting_types_values['price'] : 0,
              'type' => isset($cutting_types_values['type']) && is_numeric($cutting_types_values['type']) ? $cutting_types_values['type'] : 0,
              'color' => isset($cutting_types_values['color']) && is_string($cutting_types_values['color']) && preg_match('/^rgb\((\d{1,3}, ){2}\d{1,3}\)$/', $cutting_types_values['color']) ? $cutting_types_values['color'] : 0,
            );
          }
    
          if ((isset($_POST['zoom']) && is_numeric($_POST['zoom']) && $_POST['zoom'] > 0 && $_POST['zoom'] != 1) || (isset($_POST['entities_to_delete']) && is_array($_POST['entities_to_delete'])) || $turn) {
            require_once 'helpers/GraphicModuleFile.php';
            $graphicModuleFile = new GraphicModuleFile($_SERVER['DOCUMENT_ROOT'] . '/graphic_files/' . $bid['file']);
            $graphicModuleFile->changeSizes($_POST['zoom'], isset($_POST['entities_to_delete']) && is_array($_POST['entities_to_delete']) ? $_POST['entities_to_delete'] : array(), $turn);
          }
    
          file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/graphic_files/preview/' . $bid['id'] . '.png', base64_decode($_POST['preview']));
          
          DB::connect()->query("UPDATE bids SET material = " . $_POST['material'] . ", size = " . $_POST['size'] . ", data = '" . serialize($data) . "' WHERE id = " . $bid['id']);
          Models::get('Users')->save(array('id' => $this->user['id'], 'newbie' => '0'));
          unset($_SESSION['current_file_id']);
          echo json_encode(array('status' => 'success'));
        }
        else {
          echo json_encode(array('status' => 'fail', 'message' => $error));
        }
      }
      else {
        echo json_encode(array('status' => 'fail', 'message' => 'Please, try to relogin'));
      }
    }
  }

  public function cartAction() {
    if ($this->user['id']) {
      $errors = array();
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_POST['delivery_time']) || !is_numeric($_POST['delivery_time']) || !$delivery_time = Models::get('DeliveryTime')->get($_POST['delivery_time'])) {
          $errors['delivery_time'] = 'Wrong delivery date';
        }
        if (!isset($_POST['name']) || !is_string($_POST['name']) || !$_POST['name'] || !strip_tags($this->removeScripts($_POST['name']))) {
          $errors['name'] = 'Введите имя';
        }
        if (!isset($_POST['surname']) || !is_string($_POST['surname']) || !$_POST['surname'] || !strip_tags($this->removeScripts($_POST['surname']))) {
          $errors['surname'] = 'Введите фамилию';
        }
        if (!isset($_POST['city']) || !is_string($_POST['city']) || !$_POST['city'] || !Models::get('Cities')->get(array('name' => $_POST['city']))) {
          $errors['city'] = 'Введите город';
        }
        if (!isset($_POST['street']) || !is_string($_POST['street']) || !$_POST['street'] || !strip_tags($this->removeScripts($_POST['street']))) {
          $errors['street'] = 'Введите улицу';
        }
        if (!isset($_POST['house_number']) || !is_string($_POST['house_number']) || !$_POST['house_number'] || !strip_tags($this->removeScripts($_POST['house_number']))) {
          $errors['house_number'] = 'Введите номер дома';
        }
        if (!isset($_POST['post_index']) || !is_string($_POST['post_index']) || !$_POST['post_index'] || !strip_tags($this->removeScripts($_POST['post_index']))) {
          $errors['post_index'] = 'Введите индекс';
        }
        if (!isset($_POST['company_name']) || !is_string($_POST['company_name']) || !$_POST['company_name'] || !strip_tags($this->removeScripts($_POST['company_name']))) {
          $errors['company_name'] = 'Введите название компании';
        }
        if (!isset($_POST['company_id']) || !is_string($_POST['company_id']) || !$_POST['company_id'] || !strip_tags($this->removeScripts($_POST['company_id']))) {
          $errors['company_id'] = 'Введите P / Z / P';
        }
        if (isset($_POST['coupon']) && is_string($_POST['coupon']) && $_POST['coupon']) {
          if (!($coupon = Models::get('Coupons')->getByCode($_POST['coupon'])) || !$coupon['discount'] || !is_numeric($coupon['discount']) || $coupon['discount'] <=0 || $coupon['discount'] > 100) {
            $errors['coupon'] = 'Неверный промокод';
          }
          elseif ($coupon['valid_till'] < time()) {
            $errors['coupon'] = 'Этот промокод уже использован';
          }
          elseif ($coupon['status'] !== '0') {
            $errors['coupon'] = 'Этот промокод уже используется';
          }
        }
        if (!$bids = Models::get('Bids')->getNewByUser($this->user['id'])) {
          $errors['cart'] = 'Ваша корзина пуста';
        }
        else {
          foreach ($bids as $bid) {
            if (!isset($_POST['quantity'][$bid['id']]) || !is_numeric($_POST['quantity'][$bid['id']]) || $_POST['quantity'][$bid['id']] < 1)
              $errors['quantity'][$bid['id']] = 'Wrong quantity';
          }
        }
        if (!isset($_POST['agree-rules'])) {
          $errors['agree-rules'] = 'Условия использования должны быть подтверждены';
        }

        if (!$errors) {
          $price = $delivery_time['price'];
          foreach ($bids as $bid) {
            $price += ($bid['data']['total_price'] + $bid['data']['tax']) * $_POST['quantity'][$bid['id']];
          }
          if (isset($coupon)) {
            $price = round($price - $price / 100 * $coupon['discount'], 2);
            Models::get('Coupons')->updateStatus($coupon['id'], 1);
          }
          if ($order = Models::get('Orders')->insert($price, $delivery_time['id'], $_POST['name'], $_POST['surname'], $_POST['city'], $_POST['street'], $_POST['house_number'], $_POST['post_index'], $_POST['company_name'], $_POST['company_id'], $bids, $_POST['quantity']))
            Models::get('Orders')->payWithZCredit($price, $order['id'], $order['hash'], count($bids), $this->user['name']);
          else $this->redirect('/cart?message=Something wrong, please contact the administrator');
        }
      }
      elseif (isset($_GET['delete_from_cart']) && is_numeric($_GET['delete_from_cart'])) {
        Models::get('Bids')->delete($_GET['delete_from_cart']);
        $this->redirect('/cart');
      }
      elseif (isset($_GET['message'])) {
        if (is_string($_GET['message']) && $_GET['message']) {
          return Views::getContent('base', array('user' => $this->user, 'title' => 'Cart', 'content' => '<div class="content"><div class="cart-message">' . $_GET['message'] . '</div></div>'));
        }
        else $this->redirect('/cart');
      }
      elseif (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0 && isset($_GET['hash']) && is_string($_GET['hash']) && strlen($_GET['hash']) == 30) {
        if ($order = Models::get('Orders')->pay($_GET['id'], $_GET['hash'])) {
          $this->sendEventEmail($this->user['email'], 'order_create', array('!name' => $this->user['name'], '!surname' => $this->user['surname'], '!order_number' => $_GET['id']));
          $this->sendSmsEvent($order['phone'], 'order_payed', array('!name' => $order['user_name'], '!order_id' => $order['id']));
          $this->redirect('/cart?message=הזמנתך התקבלה בהצלחה!');
        }
        else $this->redirect('/cart?message=Wrong order data');
      }
      return Views::getContent('base', array('user' => $this->user, 'title' => 'סל קניות', 'body_classes' => 'cart', 'content' => Views::getContent('cart', array('errors' => $errors, 'values' => $_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST : $this->user, 'bids' => Models::get('Bids')->getNewByUser($this->user['id']), 'order' => Models::get('Orders')->getNewOrder(), 'dtimes' => Models::get('DeliveryTime')->get(), 'rules' => $this->agreeRules))));
    }
    else {
      return Views::getContent('403');
    }
  }

  public function notifyPaymentAction() {
    if (isset($_GET['type'])) {
      $tax = DB::connect()->query("SELECT * FROM options WHERE name = 'tax'")->fetch_assoc();
      $tax = $tax && is_array($tax) && isset($tax['value']) && is_numeric($tax['value']) ? $tax['value'] : 0;
      switch ($_GET['type']) {
        case 'zcredit':
          if (isset($_POST['GUID']) && is_string($_POST['GUID']) && isset($_POST['CardName']) && is_string($_POST['CardName']) && isset($_POST['CardNum']) && is_numeric($_POST['CardNum']) && isset($_POST['ExpDate_MMYY']) && is_string($_POST['ExpDate_MMYY']) && preg_match_all('/^(\d{2})\/(\d{2})$/', $_POST['ExpDate_MMYY'], $card_exp) && isset($card_exp[1][0]) && isset($card_exp[2][0]) && isset($_POST['CustomerID']) && is_string($_POST['CustomerID']) &&
              isset($_POST['CustomerName']) && is_string($_POST['CustomerName']) && isset($_POST['ApprovalNumber']) && is_numeric($_POST['ApprovalNumber']) &&
              preg_match('/^\{?[A-Za-z0-9]{8}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{12}\}?$/', $_POST['GUID']) && ($order = DB::connect()->query("SELECT o.*, u.email FROM orders o INNER JOIN users u ON o.user_id = u.id WHERE o.payment_data LIKE '%\"GUID\":\"" . $_POST['GUID'] . "\"%'")->fetch_assoc()) &&
              ($icount_response = Models::get('Orders')->sendICountDocument($order['company_id'], $order['company_name'], $order['email'], $order['id'], $order['summ'] / ($tax / 100 + 1), $_POST['CardName'], $_POST['CardNum'], $card_exp[1][0], '20' . $card_exp[2][0], $_POST['CustomerID'], $_POST['CustomerName'], $_POST['ApprovalNumber'])) && isset($icount_response->doc_url)) {
            DB::connect()->query("UPDATE orders SET pdf_link = '" . $icount_response->doc_url . "', payment_data = '" . addslashes(json_encode($_POST)) . "' WHERE id = " . $order['id']);
          }
          break;
      }
    }
  }

  public function checkCouponAction() {
    if ($this->user['id']) {
      if (isset($_POST['coupon']) && is_string($_POST['coupon']) && $_POST['coupon'] && $coupon = Models::get('Coupons')->getByCode($_POST['coupon'])) {
        if ($coupon['status'] !== '0') echo json_encode(array('status' => 'error', 'type' => 'Coupon already was used'));
        elseif (!is_numeric($coupon['discount'])) echo json_encode(array('status' => 'error', 'type' => 'Coupon is broken'));
        else echo json_encode(array('status' => 'success', 'discount' => $coupon['discount']));
      }
      else echo json_encode(array('status' => 'error', 'type' => 'קוד קופון לא נמצא'));
    }
    else echo json_encode(array('status' => 'error', 'type' => 'You are not logged in'));
    exit;
  }

  public function deleteBidAction() {
    if ($this->user['id']) {
      $bid = Models::get('Bids')->get($this->arg(1));
      if ($bid && $bid['user_id'] == $this->user['id']) {
        Models::get('Bids')->delete($this->arg(1));
        @unlink($_SERVER['DOCUMENT_ROOT'] . '/graphic_files/' . $bid['file']);
      }
      $this->redirect('/your-objects');
    }
    else {
      $this->redirect('/');
    }
  }

  public function insertIpDataAction() {
    $sites = array('creativecut.co.il');
    $events = array('צור-קשר', 'שירותי-גרפיקה', 'הצעת-מחיר-אונליין');
    if (isset($_POST['key']) && $_POST['key'] == 'kas4398kl3qdsakpeqzxnhjdkq2' && isset($_POST['ip']) && is_string($_POST['ip']) && preg_match('/^(?:\d{1,3}\.){3,3}\d{1,3}$/', $_POST['ip']) && isset($_POST['site']) && is_string($_POST['site']) && in_array($_POST['site'], $sites) && isset($_POST['event']) && is_string($_POST['event']) && in_array($_POST['event'], $events)) {
      DB::connect()->query("INSERT INTO ip_address_data (ip, site, event, date) VALUES ('" . $_POST['ip'] . "', '" . $_POST['site'] . "', '" . addslashes($_POST['event']) . "', " . time() . ")");
    }
  }

  public function facebookAction() {
    if (!$this->user['id']) {
      $app_id = '605529852884853';
      $app_secret = 'c0890585d0f5770131507f7e62e6356e';
      $redirect = $this->getSiteUrl() . '/facebook';
      
      if (isset($_GET['code'])) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://graph.Facebook.com/oauth/access_token?client_id=' . $app_id . '&redirect_uri=' . $redirect . '&client_secret=' . $app_secret . '&code=' . $_GET['code']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $res = json_decode(curl_exec($curl));
        curl_close($curl);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://graph.Facebook.com/me?access_token=' . $res->access_token);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $res = json_decode(curl_exec($curl));
        curl_close($curl);

        if (is_object($res) && isset($res->id) && $res->id) {
          $user = DB::connect()->query("SELECT * FROM users WHERE social = 'facebook_" . $res->id . "' OR social LIKE 'facebook_" . $res->id . ",%' OR social LIKE '%,facebook_" . $res->id . ",%' OR social LIKE '%,facebook_" . $res->id . "'")->fetch_assoc();
          if ($user) {
            $required_fields = array('email', 'phone', 'password', 'name', 'specialty');
            foreach ($required_fields as $required_field) {
              if (!isset($user[$required_field]) || !$user[$required_field]) {
                $_SESSION['user_additional_data'] = $user['id'];
                print '<script>
                  window.opener.location = \'/userAdditionalData\';
                  window.close();
                </script>';
                exit;
              }
            }
            $this->login($user['id'], '');
            print '<script>
              window.opener.location = \'/\';
              window.close();
            </script>';
          }
          elseif (isset($res->email) && $res->email && $ube = Models::get('Users')->get(array('email' => $res->email))) {
            header('Content-Type: text/html; charset=utf-8');
            echo 'האימייל ' . $res->email . ' כבר בשימוש';
          }
          else {
            copy('https://graph.facebook.com/' . $res->id . '/picture?type=large', $_SERVER['DOCUMENT_ROOT'] . '/files/' . ($file_name = uniqid() . 'jpeg'));
            Models::get('Users')->save(array('name' => $res->name, 'status' => 1, 'email' => isset($res->email) ? $res->email : '', 'register_date' => time(), 'image' => $file_name));
            $id = DB::connect()->insert_id;
            DB::connect()->query("UPDATE users SET social = 'facebook_" . $res->id . "' WHERE id = $id");
            $_SESSION['user_additional_data'] = $id;
            print '<script>
              window.opener.location = \'/userAdditionalData\';
              window.close();
            </script>';
          }
        }
        else {
          echo 'Error';
        }
      }
      else {
        $this->redirect('https://www.Facebook.com/dialog/oauth?client_id=' . $app_id . '&redirect_uri=' . $redirect . '&response_type=code&scope=email,user_birthday&display=popup');
      }
    }
    else $this->redirect('/');
  }

  public function googleAction() {
    if (!$this->user['id']) {
      $app_id = '112653788819-6dn1kj3badbk859lihkam70obohkinta.apps.googleusercontent.com';
      $app_secret = '1Fg5JkzBvikF_NaVHlx-8TDU';
      $redirect = $this->getSiteUrl() . '/google';

      if (isset($_GET['code'])) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, 'client_id=' . $app_id . '&client_secret=' . $app_secret . '&redirect_uri=' . $redirect . '&grant_type=authorization_code&code=' . $_GET['code']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $res = json_decode(curl_exec($curl));
        curl_close($curl);
      
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v1/userinfo?client_id=' . $app_id . '&client_secret=' . $app_secret . '&redirect_uri=' . $redirect . '&grant_type=authorization_code&code=' . $_GET['code'] . '&access_token=' . $res->access_token);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $res = json_decode(curl_exec($curl));
        curl_close($curl);
        
        if (is_object($res) && isset($res->id) && $res->id) {
          $user = DB::connect()->query("SELECT * FROM users WHERE social = 'google_" . $res->id . "' OR social LIKE 'google_" . $res->id . ",%' OR social LIKE '%,google_" . $res->id . ",%' OR social LIKE '%,google_" . $res->id . "'")->fetch_assoc();
          if ($user) {
            $required_fields = array('email', 'phone', 'password', 'name', 'specialty');
            foreach ($required_fields as $required_field) {
              if (!isset($user[$required_field]) || !$user[$required_field]) {
                $_SESSION['user_additional_data'] = $user['id'];
                print '<script>
                  window.opener.location = \'/userAdditionalData\';
                  window.close();
                </script>';
                exit;
              }
            }
            $this->login($user['id'], '');
            print '<script>
              window.opener.location = \'/\';
              window.close();
            </script>';
          }
          elseif (isset($res->email) && $res->email && $ube = Models::get('Users')->get(array('email' => $res->email))) {
            header('Content-Type: text/html; charset=utf-8');
            echo 'האימייל ' . $res->email . ' כבר בשימוש';
          }
          else {
            copy($res->picture, $_SERVER['DOCUMENT_ROOT'] . '/files/' . ($file_name = uniqid() . 'jpeg'));
            Models::get('Users')->save(array('name' => $res->name, 'status' => 1, 'email' => isset($res->email) ? $res->email : '', 'register_date' => time(), 'image' => $file_name));
            $id = DB::connect()->insert_id;
            DB::connect()->query("UPDATE users SET social = 'google_" . $res->id . "' WHERE id = $id");
            $_SESSION['user_additional_data'] = $id;
            print '<script>
              window.opener.location = \'/userAdditionalData\';
              window.close();
            </script>';
          }
        }
        else {
          echo 'Error';
        }
      }
      else {
        header('Location: https://accounts.google.com/o/oauth2/auth?redirect_uri=' . $redirect . '&response_type=code&client_id=' . $app_id . '&scope=https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile');
      }
    }
    else $this->redirect('/');
  }

  public function userAdditionalDataAction() {
    if (isset($_SESSION['user_additional_data']) && is_numeric($_SESSION['user_additional_data']) && $_SESSION['user_additional_data'] > 0 && $user = Models::get('Users')->get(array('id' => $_SESSION['user_additional_data']))) {
      $specialties = Models::get('Specialties')->get();
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        if (!isset($_POST['name']) || !is_string($_POST['name']) || !strip_tags($this->removeScripts($_POST['name']))) {
          $errors['name'] = 'Name is required';
        }
        if (!isset($_POST['surname']) || !is_string($_POST['surname']) || !strip_tags($this->removeScripts($_POST['surname']))) {
          $errors['name'] = 'Surname is required';
        }
        if (!isset($_POST['email']) || !is_string($_POST['email']) || !$_POST['email']) {
          $errors['email'] = 'Email is required';
        }
        elseif (!$this->isValidEmail($_POST['email'])) {
          $errors['email'] = 'Wrong format';
        }
        elseif ($user = Models::get('Users')->get(array('email' => $_POST['email']))) {
          if (!isset($user[$_SESSION['user_additional_data']])) $errors['email'] = 'User with this email already exists';
        }
        if (!isset($_POST['phone']) || !is_string($_POST['phone']) || !$_POST['phone']) {
          $errors['phone'] = 'Phone is required';
        }
        elseif (!preg_match('/^(?:\+(?: )?)?(?:\d+ |\d+-)*\d+$/', $_POST['phone'])) {
          $errors['phone'] = 'Wrong format';
        }
        if (!isset($_POST['phone_code']) || !is_string($_POST['phone_code']) || !preg_match('/^\d{5}$/', $_POST['phone_code'])) {
          $errors['phone_code'] = 'Wrong code';
        }
        elseif (!isset($errors['phone']) && !Models::get('PhoneCode')->checkPhoneCode($_POST['phone'], $_POST['phone_code'])) {
          $errors['phone_code'] = 'This code wrong for this phone';
        }
        if (!isset($_POST['password']) || !is_string($_POST['password']) || !$_POST['password']) {
          $errors['password'] = 'Password is required';
        }
        if (!isset($_POST['specialty']) || !is_numeric($_POST['specialty']) || !$_POST['specialty']) {
          $errors['specialty'] = 'Specialty is required';
        }
        elseif (!array_key_exists($_POST['specialty'], $specialties)) {
          $errors['specialty'] = 'Wrong specialty';
        }

        if (!$errors) {
          $_POST['id'] = $_SESSION['user_additional_data'];
          $_POST['status'] = 1;
          if (isset($_POST['register_date'])) unset($_POST['register_date']);
          Models::get('Users')->save($_POST);
          $this->sendEventEmail($_POST['email'], 'register_event', array('!name' => $_POST['name']));
          Models::get('PhoneCode')->deleteByPhone($_POST['phone']);
          $this->login($_SESSION['user_additional_data']);
        }
        else {
          return Views::getContent('authorization', array('specialties' => $specialties, 'user_additional_data' => $_POST, 'errors' => $errors));
        }
      }
      else {
        return Views::getContent('authorization', array('specialties' => $specialties, 'user_additional_data' => $user[$_SESSION['user_additional_data']]));
      }
    }
    else $this->redirect('/');
  }

  public function saveMceImageAction() {
    if (isset($_FILES['image']['error']) && !$_FILES['image']['error'] && $imagesize = getimagesize($_FILES['image']['tmp_name'])) {
      return move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $path = ('/images/tiny_mce/' . (isset($_POST['type']) && is_string($_POST['type']) && $_POST['type'] == 'temporary' ? 'temporary/' : '') . uniqid() . strrchr($_FILES['image']['name'], '.'))) ? $this->siteUrl . $path : '';
    }
  }
}


?>