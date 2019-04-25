<?php

class IndexController extends Controller {

  public function indexAction() {
    return Views::getContent(isset($_SESSION['admin_login']) ? 'a-panel/base' : 'a-panel/login');
  }

  protected $cutting_types_size_types = array('lineLength' => 'Line length', 'area' => 'Area');

  public function cuttingTypesAction() {
    if (isset($_SESSION['admin_login'])) {
      $args = array('form' => false, 'size_types' => $this->cutting_types_size_types);
      if ($this->arg(2) == 'add') {
        $args['form'] = true;
      }
      elseif ($this->arg(2) == 'edit' && is_numeric($this->arg(3)) && $this->arg(3) > 0 && $cutting_type = Models::get('materialsCategoriesSizes')->getCuttingTypes($this->arg(3))) {
        $args['form'] = true;
        $args['cutting_type'] = $cutting_type;
      }
      else {
        $cutting_types = Models::get('materialsCategoriesSizes')->getCuttingTypes();
        $navigation = new Navigation(20, isset($_GET['page']) ? $_GET['page'] : 1, $cutting_types);
        $args['materials'] = $navigation->getMaterialsList();
        $args['pager'] = $navigation->getPager();
        $args['total_cutting_types'] = count($cutting_types);
      }
      return Views::getContent('a-panel/base', array('title' => 'Cutting types', 'content' => Views::getContent('a-panel/cutting_types', $args)));
    }
    else return Views::getContent('403');
  }

  public function saveCuttingTypeAction() {
    if (isset($_SESSION['admin_login'])) {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        if (!isset($_POST['name']) || !is_string($_POST['name']) || !$_POST['name']) {
          $errors['name'] = 'Name is required';
        }
        if (!isset($_POST['size_type']) || !is_string($_POST['size_type']) || !in_array($_POST['size_type'], array('lineLength', 'area'))) {
          $errors['size_type'] = 'Wrong size type';
        }
    
        if (!$errors) {
          $name = addslashes($_POST['name']);
          $size_type = $_POST['size_type'];
          $id = isset($_POST['id']) && is_numeric($_POST['id']) && Models::get('materialsCategoriesSizes')->getCuttingTypes($_POST['id']) ? $_POST['id'] : 0;
          DB::connect()->query("INSERT INTO cutting_types (id, name, size_type) VALUES ($id, '$name', '$size_type') ON DUPLICATE KEY UPDATE name = VALUES(name), size_type = VALUES(size_type)");
          $this->redirect('/a-panel/cuttingTypes');
        }
        else {
          return Views::getContent('a-panel/base', array('title' => 'Cutting types', 'content' => Views::getContent('a-panel/cutting_types', array('form' => true, 'errors' => $errors, 'cutting_type' => $_POST, 'size_types' => $this->cutting_types_size_types))));
        }
      }
      else {
        $this->redirect('/a-panel/cuttingTypes');
      }
    }
    else {
      $this->redirect('/a-panel/login');
    }
  }

  public function deleteCuttingTypeAction() {
    if (isset($_SESSION['admin_login'])) {
      if ($this->arg(2) && is_numeric($this->arg(2)) && Models::get('materialsCategoriesSizes')->getCuttingTypes($this->arg(2))) {
        DB::connect()->query("DELETE FROM cutting_types WHERE id = " . $this->arg(2));
      }
      $this->redirect('/a-panel/cuttingTypes');
    }
    else {
      $this->redirect('/a-panel/login');
    }
  }

  public function materialSizesAction() {
    if (isset($_SESSION['admin_login'])) {
      $args = array('form' => false);
      if ($this->arg(2) == 'add') {
        $args['form'] = true;
      }
      elseif ($this->arg(2) == 'edit' && is_numeric($this->arg(3)) && $this->arg(3) > 0 && $material_size = $this->getMaterialSizes($this->arg(3))) {
        $args['form'] = true;
        $args['material_size'] = $material_size;
      }
      else {
        $material_sizes = $this->getMaterialSizes();
        $navigation = new Navigation(20, isset($_GET['page']) ? $_GET['page'] : 1, $material_sizes);
        $args['materials'] = $navigation->getMaterialsList();
        $args['pager'] = $navigation->getPager();
        $args['total_material_sizes'] = count($material_sizes);
      }
      return Views::getContent('a-panel/base', array('title' => 'Material sizes', 'content' => Views::getContent('a-panel/material_sizes', $args)));
    }
    else return Views::getContent('403');
  }

  public function saveMaterialSizeAction() {
    if (isset($_SESSION['admin_login'])) {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        if (!isset($_POST['name']) || !is_string($_POST['name']) || !$_POST['name']) {
          $errors['name'] = 'Name is required';
        }
    
        if (!$errors) {
          $name = addslashes($_POST['name']);
          $id = isset($_POST['id']) && is_numeric($_POST['id']) && $this->getMaterialSizes($_POST['id']) ? $_POST['id'] : 0;
          DB::connect()->query("INSERT INTO material_sizes (id, name) VALUES ($id, '$name') ON DUPLICATE KEY UPDATE name = VALUES(name)");
          $this->redirect('/a-panel/materialSizes');
        }
        else {
          return Views::getContent('a-panel/base', array('title' => 'Material sizes', 'content' => Views::getContent('a-panel/material_sizes', array('form' => true, 'errors' => $errors, 'material_size' => $_POST))));
        }
      }
      else {
        $this->redirect('/a-panel/materialSizes');
      }
    }
    else {
      $this->redirect('/a-panel/login');
    }
  }

  public function deleteMaterialSizeAction() {
    if (isset($_SESSION['admin_login'])) {
      if ($this->arg(2) && is_numeric($this->arg(2)) && $this->getMaterialSizes($this->arg(2))) {
        DB::connect()->query("DELETE FROM material_sizes WHERE id = " . $this->arg(2));
      }
      $this->redirect('/a-panel/materialSizes');
    }
    else {
      $this->redirect('/a-panel/login');
    }
  }

  public function getMaterialSizes($id = false) {
    if ($id && is_numeric($id)) return DB::connect()->query("SELECT * FROM material_sizes WHERE id = $id")->fetch_assoc();
    $result = DB::connect()->query("SELECT * FROM material_sizes ORDER BY id DESC");
    $material_sizes = array();
    while ($res = $result->fetch_assoc()) {
      $material_sizes[] = $res;
    }
    return $material_sizes;
  }

  public function materialCategoriesAction() {
    if (isset($_SESSION['admin_login'])) {
      $args = array('form' => false);
      if ($this->arg(2) == 'add') {
        $args['form'] = true;
      }
      elseif ($this->arg(2) == 'edit' && is_numeric($this->arg(3)) && $this->arg(3) > 0 && $material_category = $this->getMaterialCategories($this->arg(3))) {
        $result = DB::connect()->query("SELECT * FROM materials WHERE category = " . $this->arg(3) . " ORDER BY id DESC");
        $materials = array();
        while ($res = $result->fetch_assoc()) {
          $materials[] = $res;
        }
        $navigation = new Navigation(20, isset($_GET['page']) ? $_GET['page'] : 1, $materials);
        $args['form'] = true;
        $args['material_category'] = $material_category;
        $args['materials'] = $navigation->getMaterialsList();
        $args['pager'] = $navigation->getPager();
        $args['total_materials'] = count($materials);
      }
      else {
        $material_categories = $this->getMaterialCategories();
        $navigation = new Navigation(20, isset($_GET['page']) ? $_GET['page'] : 1, $material_categories);
        $args['materials'] = $navigation->getMaterialsList();
        $args['pager'] = $navigation->getPager();
        $args['total_material_categories'] = count($material_categories);
      }
      return Views::getContent('a-panel/base', array('title' => 'Material categories', 'content' => Views::getContent('a-panel/material_categories', $args)));
    }
    else return Views::getContent('403');
  }

  public function saveMaterialCategoryAction() {
    if (isset($_SESSION['admin_login'])) {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        if (!isset($_POST['name']) || !is_string($_POST['name']) || !$_POST['name']) {
          $errors['name'] = 'Name is required';
        }
        if (isset($_POST['id']) && is_numeric($_POST['id'])) {
          $material_category = $this->getMaterialCategories($_POST['id']);
        }
        if ((!isset($material_category) || !$material_category || !$material_category['image'] || !CropImage::getImage($material_category['image'])) && (!isset($_FILES['image']['tmp_name']) || $_FILES['image']['error'])) {
          $errors['image'] = 'Image is required';
        }
        elseif (isset($_FILES['image']['tmp_name']) && !$_FILES['image']['error'] && !@getimagesize($_FILES['image']['tmp_name'])) {
          $errors['image'] = 'Wrong file type';
        }

        if (!$errors) {
          $name = addslashes($_POST['name']);
          $max_width = isset($_POST['max_width']) && is_numeric($_POST['max_width']) ? $_POST['max_width'] : 0;
          $max_height = isset($_POST['max_height']) && is_numeric($_POST['max_height']) ? $_POST['max_height'] : 0;
          $id = isset($material_category) && $material_category ? $_POST['id'] : 0;
          if (isset($_FILES['image']['tmp_name']) && !$_FILES['image']['error']) {
            $image_path = CropImage::saveUploadedImage($_FILES['image']['tmp_name']);
            if (isset($material_category['image'])) CropImage::deleteImage($material_category['image']);
          }
          else {
            $image_path = $material_category['image'];
          }
          DB::connect()->query("INSERT INTO material_categories (id, name, image, max_width, max_height) VALUES ($id, '$name', '$image_path', $max_width, $max_height) ON DUPLICATE KEY UPDATE name = VALUES(name), image = VALUES(image), max_width = VALUES(max_width), max_height = VALUES(max_height)");
          $this->redirect('/a-panel/materialCategories');
        }
        else {
          return Views::getContent('a-panel/base', array('title' => 'Material categories', 'content' => Views::getContent('a-panel/material_categories', array('form' => true, 'errors' => $errors, 'material_category' => $_POST))));
        }
      }
      else {
        $this->redirect('/a-panel/materialCategories');
      }
    }
    else {
      $this->redirect('/a-panel/login');
    }
  }

  public function deleteMaterialCategoryAction() {
    if (isset($_SESSION['admin_login'])) {
      if ($this->arg(2) && is_numeric($this->arg(2)) && $material_category = $this->getMaterialCategories($this->arg(2))) {
        DB::connect()->query("DELETE FROM material_categories WHERE id = " . $this->arg(2));
        if ($material_category['image']) {
          CropImage::deleteImage($material_category['image']);
        }
      }
      $this->redirect('/a-panel/materialCategories');
    }
    else {
      $this->redirect('/a-panel/login');
    }
  }

  public function getMaterialCategories($id = false) {
    if ($id && is_numeric($id)) return DB::connect()->query("SELECT * FROM material_categories WHERE id = $id")->fetch_assoc();
    $result = DB::connect()->query("SELECT * FROM material_categories ORDER BY id DESC");
    $material_categories = array();
    while ($res = $result->fetch_assoc()) {
      $material_categories[] = $res;
    }
    return $material_categories;
  }

  public function materialsAction() {
    if (isset($_SESSION['admin_login'])) {
      $args = array('form' => false);
      if ($this->arg(2) == 'add') {
        $args['form'] = true;
        $args['cutting_types'] = Models::get('materialsCategoriesSizes')->getCuttingTypes();
        $args['material_sizes'] = $this->getMaterialSizes();
        $args['material_categories'] = $this->getMaterialCategories();
        $args['material'] = array('category' => $this->arg(3));
      }
      elseif ($this->arg(2) == 'edit' && is_numeric($this->arg(3)) && $this->arg(3) > 0 && $material = DB::connect()->query("SELECT * FROM materials WHERE id = " . $this->arg(3))->fetch_assoc()) {
        $prices = unserialize($material['prices']);
        $args['form'] = true;
        $args['material'] = $material;
        $args['cutting_types'] = Models::get('materialsCategoriesSizes')->getCuttingTypes();
        $args['material_sizes'] = $this->getMaterialSizes();
        $args['material_categories'] = $this->getMaterialCategories();
        $args['material_prices'] = $prices['prices'];
        $args['material_speed'] = $prices['speed'];
        $args['material_images'] = $prices['images'];
      }
      else {
        $result = DB::connect()->query("SELECT * FROM materials ORDER BY id DESC");
        $materials = array();
        while ($res = $result->fetch_assoc()) {
          $materials[] = $res;
        }
        $navigation = new Navigation(20, isset($_GET['page']) ? $_GET['page'] : 1, $materials);
        $args['materials'] = $navigation->getMaterialsList();
        $args['pager'] = $navigation->getPager();
        $args['total_materials'] = count($materials);
      }
      return Views::getContent('a-panel/base', array('title' => 'Materials', 'content' => Views::getContent('a-panel/materials', $args)));
    }
    else return Views::getContent('403');
  }

  public function saveMaterialAction() {
    if (isset($_SESSION['admin_login'])) {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        if (!isset($_POST['name']) || !is_string($_POST['name']) || !$_POST['name']) {
          $errors['name'] = 'Name is required';
        }
        if (!isset($_POST['category']) || !is_numeric($_POST['category']) || !$_POST['category']) {
          $errors['category'] = 'Category is required';
        }
        elseif (!$this->getMaterialCategories($_POST['category'])) {
          $errors['category'] = 'Wrong category';
        }
        if (isset($_POST['prices']) && is_array($_POST['prices']) && $_POST['prices']) {
          foreach ($_POST['prices'] as $id => $price) {
            if (!is_numeric($price) && $price !== '') $errors['price' . $id] = 'Price must be numeric';
          }
        }
        if (isset($_POST['speed']) && is_array($_POST['speed']) && $_POST['speed']) {
          foreach ($_POST['speed'] as $id => $ct) {
            if (is_array($ct)) {
              foreach ($ct as $ct_id => $speed) {
                if (!is_numeric($speed) && $speed !== '') $errors['speed' . $id][$ct_id] = 'Speed must be numeric';
              }
            }
          }
        }
        if (isset($_FILES['size_image'])) {
          foreach ($_FILES['size_image']['error'] as $id => $e) {
            if (!$e && !@getimagesize($_FILES['size_image']['tmp_name'][$id])) {
              $errors['size_image' . $id] = 'Wrong file type';
            }
          }
        }
        if (isset($_POST['id']) && is_numeric($_POST['id'])) {
          $material = DB::connect()->query("SELECT * FROM materials WHERE id = " . $_POST['id'])->fetch_assoc();
        }
        if ((!isset($material) || !$material || !$material['image'] || !CropImage::getImage($material['image'])) && (!isset($_FILES['image']['tmp_name']) || $_FILES['image']['error'])) {
          $errors['image'] = 'Image is required';
        }
        elseif (isset($_FILES['image']['tmp_name']) && !$_FILES['image']['error'] && !@getimagesize($_FILES['image']['tmp_name'])) {
          $errors['image'] = 'Wrong file type';
        }

        if (!$errors) {
          $name = addslashes($_POST['name']);
          $id = isset($material) && $material ? $_POST['id'] : 0;
          $category = $_POST['category'];
          if (isset($material['prices'])) $old_prices = unserialize($material['prices']);
          $images = isset($old_prices['images']) ? $old_prices['images'] : array();
          if (isset($_FILES['size_image'])) {
            foreach ($_FILES['size_image']['error'] as $k => $e) {
              if (!$e) {
                if (isset($images[$k])) CropImage::deleteImage($images[$k]);
                $images[$k] = CropImage::saveUploadedImage($_FILES['size_image']['tmp_name'][$k]);
              }
            }
          }
          $prices = addslashes(serialize(array(
            'prices' => isset($_POST['prices']) && is_array($_POST['prices']) ? $_POST['prices'] : array(),
            'speed' => isset($_POST['speed']) && is_array($_POST['speed']) ? $_POST['speed'] : array(),
            'images' => $images
          )));
          if (isset($_FILES['image']['tmp_name']) && !$_FILES['image']['error']) {
            $image_path = CropImage::saveUploadedImage($_FILES['image']['tmp_name']);
            if (isset($material['image'])) CropImage::deleteImage($material['image']);
          }
          else {
            $image_path = $material['image'];
          }
          DB::connect()->query("INSERT INTO materials (id, name, category, prices, image) VALUES ($id, '$name', $category, '$prices', '$image_path') ON DUPLICATE KEY UPDATE name = VALUES(name), category = VALUES(category), prices = VALUES(prices), image = VALUES(image)");
          $this->redirect('/a-panel/materialCategories/edit/' . $category);
        }
        else {
          if (isset($material['image'])) $_POST['image'] = $material['image'];
          if (isset($material['prices'])) $prices = @unserialize($material['prices']);
          return Views::getContent('a-panel/base', array('title' => 'Materials', 'content' => Views::getContent('a-panel/materials', array('form' => true, 'errors' => $errors, 'material' => $_POST, 'material_prices' => $_POST['prices'], 'material_sizes' => $this->getMaterialSizes(), 'material_speed' => $_POST['speed'], 'material_images' => isset($prices['images']) ? $prices['images'] : array(), 'material_categories' => $this->getMaterialCategories(), 'cutting_types' => Models::get('materialsCategoriesSizes')->getCuttingTypes()))));
        }
      }
      else {
        $this->redirect('/a-panel/materialCategories');
      }
    }
    else {
      $this->redirect('/a-panel/login');
    }
  }

  public function deleteMaterialAction() {
    if (isset($_SESSION['admin_login'])) {
      if ($this->arg(2) && is_numeric($this->arg(2)) && $material = DB::connect()->query("SELECT * FROM materials WHERE id = " . $this->arg(2))->fetch_assoc()) {
        DB::connect()->query("DELETE FROM materials WHERE id = " . $this->arg(2));
        if ($material['image']) {
          CropImage::deleteImage($material['image']);
        }
        $this->redirect('/a-panel/materialCategories/edit/' . $material['category']);
      }
      $this->redirect('/a-panel/materialCategories');
    }
    else {
      $this->redirect('/a-panel/login');
    }
  }

  public function optionsAction() {
    if (isset($_SESSION['admin_login'])) {
      $options = array();
      $result = DB::connect()->query("SELECT * FROM options");
      while ($res = $result->fetch_assoc()) {
        $options[$res['name']] = $res['value'];
      }
      return Views::getContent('a-panel/base', array('title' => 'Options', 'content' => Views::getContent('a-panel/options', array('options' => $options))));
    }
  }

  public function saveOptionsAction() {
    if (isset($_SESSION['admin_login'])) {
      $values = array();
      foreach ($_POST['options'] as $name => $value) {
        if (is_scalar($name) && is_scalar($value)) $values[] = "('" . addslashes($name) . "', '" . addslashes($value) . "')";
      }
      DB::connect()->query("INSERT INTO options (name, value) VALUES " . implode(', ', $values) . " ON DUPLICATE KEY UPDATE value = VALUES(value)");
      $this->redirect('/a-panel/options');
    }
    else {
      $this->redirect('/a-panel/login');
    }
  }

  public function specialtiesAction() {
    if (isset($_SESSION['admin_login'])) {
      $args = array('form' => false);
      if ($this->arg(2) == 'add') {
        $args['form'] = true;
      }
      elseif ($this->arg(2) == 'edit' && is_numeric($this->arg(3)) && $this->arg(3) > 0 && $specialty = DB::connect()->query("SELECT * FROM specialties WHERE id = " . $this->arg(3))->fetch_assoc()) {
        $args['form'] = true;
        $args['specialty'] = $specialty;
      }
      else {
        $result = DB::connect()->query("SELECT * FROM specialties ORDER BY id DESC");
        $specialties = array();
        while ($res = $result->fetch_assoc()) {
          $specialties[] = $res;
        }
        $navigation = new Navigation(20, isset($_GET['page']) ? $_GET['page'] : 1, $specialties);
        $args['materials'] = $navigation->getMaterialsList();
        $args['pager'] = $navigation->getPager();
        $args['total_specialties'] = count($specialties);
      }
      return Views::getContent('a-panel/base', array('title' => 'Specialties', 'content' => Views::getContent('a-panel/specialties', $args)));
    }
    else return Views::getContent('403');
  }

  public function saveSpecialtyAction() {
    if (isset($_SESSION['admin_login'])) {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        if (!isset($_POST['name']) || !is_string($_POST['name']) || !$_POST['name']) {
          $errors['name'] = 'Name is required';
        }

        if (!$errors) {
          $name = addslashes($_POST['name']);
          $id = isset($_POST['id']) && is_numeric($_POST['id']) && DB::connect()->query("SELECT * FROM specialties WHERE id = " . $_POST['id'])->fetch_assoc() ? $_POST['id'] : 0;
          DB::connect()->query("INSERT INTO specialties (id, name) VALUES ($id, '$name') ON DUPLICATE KEY UPDATE name = VALUES(name)");
          $this->redirect('/a-panel/specialties');
        }
        else {
          return Views::getContent('a-panel/base', array('title' => 'Specialties', 'content' => Views::getContent('a-panel/specialties', array('form' => true, 'errors' => $errors, 'specialty' => $_POST))));
        }
      }
      else {
        $this->redirect('/a-panel/specialties');
      }
    }
    else {
      $this->redirect('/a-panel/login');
    }
  }

  public function deleteSpecialtyAction() {
    if (isset($_SESSION['admin_login'])) {
      if ($this->arg(2) && is_numeric($this->arg(2)) && $specialty = DB::connect()->query("SELECT * FROM specialties WHERE id = " . $this->arg(2))->fetch_assoc()) {
        DB::connect()->query("DELETE FROM specialties WHERE id = " . $this->arg(2));
      }
      $this->redirect('/a-panel/specialties');
    }
    else {
      $this->redirect('/a-panel/login');
    }
  }

  public function printOrdersAction() {
    if ($this->arg(2) == 3) $bids = Models::get('Orders')->getOrders(false, false, array(1));
    else if ($this->arg(2) == 2) {
      $bids = array();
      foreach (Models::get('Bids')->getPaidOrderBids() as $bid) {
        $bids[$bid['material_category_name']][] = $bid;
      }
    }
    else $bids = Models::get('Bids')->getPaidOrderBids();
    if (isset($_SESSION['admin_login'])) return Views::getContent('a-panel/print_orders', array('bids' => $bids, 'args' => $this->arg()));
  }

  public function ordersAction() {
    if (isset($_SESSION['admin_login'])) {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['id']) && is_numeric($_POST['id']) && ($order = Models::get('Orders')->getOrders($_POST['id'])) && isset($_POST['status']) && array_key_exists($_POST['status'], $this->statuses)) {
          DB::connect()->query("UPDATE orders SET status = " . $_POST['status'] . " WHERE id = " . $_POST['id']);
          $this->sendSmsEvent($order['phone'], 'order_status_' . $_POST['status'] . ($_POST['status'] == 3 && $order['delivery_date'] == 4 ? '_selfcheckout' : ''), array('!name' => $order['user_name'], '!order_id' => $_POST['id']));
          $this->redirect('/a-panel/orders/edit/' . $_POST['id']);
        }
        $this->redirect('/a-panel/orders');
      }
      else {
        $args = array('form' => false);
        if ($this->arg(2) == 'edit' && is_numeric($this->arg(3)) && $this->arg(3) > 0 && $order = Models::get('Orders')->getOrders($this->arg(3))) {
          $args['form'] = true;
          $args['order'] = $order;
          $args['order_owner'] = Models::get('Users')->get(array('id' => $order['user_id']));
          $args['order_owner'] = $args['order_owner'][$order['user_id']];
          $args['statuses'] = $this->statuses;
          $orders = Models::get('Orders')->getOrders(false, $order['user_id']);
          if ($orders) {
            $nav = new Navigation(20, isset($_GET['orders_page']) ? $_GET['orders_page'] : 1, $orders);
            $args['orders']['orders_list'] = $nav->getMaterialsList();
            $args['orders']['orders_pager'] = $nav->getPager();
            $args['orders']['total'] = count($orders);
          }
        }
        else {
          $orders = Models::get('Orders')->getOrders(false, false, false, 1);
          $navigation = new Navigation(20, isset($_GET['page']) ? $_GET['page'] : 1, $orders);
          $args['materials'] = $navigation->getMaterialsList();
          $args['pager'] = $navigation->getPager();
          $args['total_orders'] = count($orders);
          $args['statuses'] = $this->statuses;
        }
      }
      return Views::getContent('a-panel/base', array('title' => 'Orders', 'content' => Views::getContent('a-panel/orders', $args)));
    }
    else return Views::getContent('403');
  }

  public function changeOrderStatusAction() {
    if (isset($_SESSION['admin_login'])) {
      if (isset($_POST['orderId']) && is_numeric($_POST['orderId']) && ($order = Models::get('Orders')->getOrders($_POST['orderId'])) && isset($_POST['status']) && is_numeric($_POST['status']) && array_key_exists($_POST['status'], $this->statuses)) {
        DB::connect()->query("UPDATE orders SET status = " . $_POST['status'] . " WHERE id = " . $_POST['orderId']);
        $this->sendSmsEvent($order['phone'], 'order_status_' . $_POST['status'] . ($_POST['status'] == 3 && $order['delivery_date'] == 4 ? '_selfcheckout' : ''), array('!name' => $order['user_name'], '!order_id' => $_POST['orderId']));
        echo json_encode(array('status' => 'success', 'type' => 'Order status has been successfully updated', 'color' => $this->statuses[$_POST['status']]['color']));
      }
      else {
        echo json_encode(array('status' => 'error', 'type' => 'Order not found or wrong status'));
      }
    }
    else {
      echo json_encode(array('status' => 'error', 'type' => 'reload_page'));
    }
    exit;
  }

  public function publicFilesAction() {
    if (isset($_SESSION['admin_login'])) {
      $bids = Models::get('Bids')->getPublic();
      $navigation = new Navigation(20, isset($_GET['page']) ? $_GET['page'] : 1, $bids);
      return Views::getContent('a-panel/base', array('title' => 'Public bids', 'content' => Views::getContent('a-panel/public_files', array('materials' => $navigation->getMaterialsList(), 'pager' => $navigation->getPager(), 'total_files' => count($bids)))));
    }
    else return Views::getContent('403');
  }

  public function deleteOrderAction() {
    if (isset($_SESSION['admin_login'])) {
      if ($this->arg(2) && is_numeric($this->arg(2)) && $order = Models::get('Orders')->getOrders($this->arg(2))) {
        Models::get('Orders')->delete($this->arg(2));
      }
      $this->redirect(isset($_GET['return_to_user']) && is_numeric($_GET['return_to_user']) ? '/a-panel/users/edit/' . $_GET['return_to_user'] . '?orders_page=1' : '/a-panel/orders');
    }
    else {
      $this->redirect('/a-panel/login');
    }
  }

  public function bidsAction() {
    if (isset($_SESSION['admin_login'])) {
      $args = array('form' => false);
      if ($this->arg(2) == 'edit' && is_numeric($this->arg(3)) && $this->arg(3) > 0 && $bid = DB::connect()->query("SELECT b.*, u.name, m.name AS mname, mc.name AS mcname, ms.name AS msname FROM bids b LEFT JOIN users u ON u.id = b.user_id LEFT JOIN materials m ON m.id = b.material LEFT JOIN material_categories mc ON mc.id = m.category LEFT JOIN material_sizes ms ON ms.id = b.size WHERE b.id = " . $this->arg(3))->fetch_assoc()) {
        $result = DB::connect()->query("SELECT id, name FROM cutting_types");
        $cutting_types = array();
        while ($res = $result->fetch_assoc()) {
          $cutting_types[$res['id']] = $res['name'];
        }

        $args['form'] = true;
        $bid['data'] = unserialize($bid['data']);
        $args['bid'] = $bid;
        $args['cutting_types'] = $cutting_types;
        $args['statuses'] = $this->statuses;
        $args['bid_owner'] = Models::get('Users')->get(array('id' => $bid['user_id']));
        $args['bid_owner'] = $args['bid_owner'][$bid['user_id']];
        $bids = Models::get('Bids')->getByUser($bid['user_id']);
        if ($bids) {
          $nav = new Navigation(20, isset($_GET['bids_page']) ? $_GET['bids_page'] : 1, $bids);
          $args['bids']['bids_list'] = $nav->getMaterialsList();
          $args['bids']['bids_pager'] = $nav->getPager();
          $args['bids']['total'] = count($bids);
        }
      }
      else {
        $bids = Models::get('Bids')->getNewByUser();
        $navigation = new Navigation(20, isset($_GET['page']) ? $_GET['page'] : 1, $bids);
        $args['materials'] = $navigation->getMaterialsList();
        $args['pager'] = $navigation->getPager();
        $args['total_bids'] = count($bids);
      }
      return Views::getContent('a-panel/base', array('title' => 'Bids', 'content' => Views::getContent('a-panel/bids', $args)));
    }
    else return Views::getContent('403');
  }

  public function saveBidAction() {
    if (isset($_SESSION['admin_login'])) {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        if (!isset($_POST['status']) || !array_key_exists($_POST['status'], $this->statuses)) {
          $errors['status'] = 'Wrong status';
        }
        if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !$bid = DB::connect()->query("SELECT b.*, u.name, m.name AS mname, mc.name AS mcname, ms.name AS msname FROM bids b LEFT JOIN users u ON u.id = b.user_id LEFT JOIN materials m ON m.id = b.material LEFT JOIN material_categories mc ON mc.id = m.category LEFT JOIN material_sizes ms ON ms.id = b.size WHERE b.id = " . $_POST['id'])->fetch_assoc()) {
          $this->redirect('/a-panel/bids');
        }

        if (!$errors) {
          DB::connect()->query("UPDATE bids SET status = " . $_POST['status'] . " WHERE id = " . $_POST['id']);
          $this->redirect(isset($_POST['redirect']) ? $_POST['redirect'] : '/a-panel/bids');
        }
        else {
          $result = DB::connect()->query("SELECT id, name FROM cutting_types");
          $cutting_types = array();
          while ($res = $result->fetch_assoc()) {
            $cutting_types[$res['id']] = $res['name'];
          }

          return Views::getContent('a-panel/base', array('title' => 'Bids', 'content' => Views::getContent('a-panel/bids', array('form' => true, 'errors' => $errors, 'bid' => $bid, 'cutting_types' => $cutting_types, 'statuses' => $this->statuses))));
        }
      }
      else {
        $this->redirect('/a-panel/bids');
      }
    }
    else {
      $this->redirect('/a-panel/login');
    }
  }

  public function deleteBidAction() {
    if (isset($_SESSION['admin_login'])) {
      if ($this->arg(2) && is_numeric($this->arg(2)) && $bid = Models::get('Bids')->get($this->arg(2))) {
        Models::get('Bids')->delete($bid['id']);
      }
      $this->redirect(isset($_GET['redirect']) ? $_GET['redirect'] : '/a-panel/bids');
    }
    else {
      $this->redirect('/a-panel/login');
    }
  }

  public function usersAction() {
    if (isset($_SESSION['admin_login'])) {
      $args = array('form' => false);
      if ($this->arg(2) == 'add') {
        $args['form'] = true;
        $args['specialties'] = Models::get('Specialties')->get();
      }
      elseif ($this->arg(2) == 'edit' && is_numeric($this->arg(3)) && $this->arg(3) > 0 && $user = Models::get('Users')->get(array('id' => $this->arg(3)))) {
        $args['form'] = true;
        $args['user'] = $user[$this->arg(3)];
        $args['specialties'] = Models::get('Specialties')->get();
        $orders = Models::get('Orders')->getOrders(false, $this->arg(3));
        if ($orders) {
          $nav = new Navigation(20, isset($_GET['orders_page']) ? $_GET['orders_page'] : 1, $orders);
          $args['orders']['orders_list'] = $nav->getMaterialsList();
          $args['orders']['orders_pager'] = $nav->getPager();
          $args['orders']['total'] = count($orders);
        }
      }
      else {
        $users = Models::get('Users')->get();
        $navigation = new Navigation(20, isset($_GET['page']) ? $_GET['page'] : 1, $users);
        $args['materials'] = $navigation->getMaterialsList();
        $args['pager'] = $navigation->getPager();
        $args['total_users'] = count($users);
      }
      return Views::getContent('a-panel/base', array('title' => 'Users', 'content' => Views::getContent('a-panel/users', $args)));
    }
    else return Views::getContent('403');
  }

  public function saveUserAction() {
    if (isset($_SESSION['admin_login'])) {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        if (!isset($_POST['name']) || !$_POST['name'] || !is_string($_POST['name']) || !$this->removeScripts($_POST['name'])) {
          $errors['name'] = 'Name is required';
        }
        if (!isset($_POST['surname']) || !$_POST['surname'] || !is_string($_POST['surname']) || !$this->removeScripts($_POST['surname'])) {
          $errors['surname'] = 'Surname is required';
        }
        if (!isset($_POST['email']) || !is_string($_POST['email']) || !$_POST['email']) {
          $errors['email'] = 'Email is required field';
        }
        elseif (!$this->isValidEmail($_POST['email'])) {
          $errors['email'] = 'Wrong email format';
        }
        elseif ($ube = Models::get('Users')->get(array('email' => $_POST['email']))) {
          if ($ube && (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($ube[$_POST['id']]))) $errors['email'] = 'This email already in use';
        }
        if (!isset($_POST['phone']) || !$_POST['phone'] || !is_string($_POST['phone']) || !$this->removeScripts($_POST['phone'])) {
          $errors['phone'] = 'Phone is required';
        }
        elseif (!preg_match('/^(?:\+(?: )?)?(?:\d+ |\d+-)*\d+$/', $_POST['phone'])) {
          $errors['phone'] = 'Wrong format';
        }
        if (!isset($_POST['specialty']) || !is_numeric($_POST['specialty']) || !array_key_exists($_POST['specialty'], Models::get('Specialties')->get())) {
          $errors['specialty'] = 'Wrong specialty';
        }
        if (isset($_POST['educational_institution']) && !is_string($_POST['educational_institution'])) {
          $errors['educational_institution'] = 'Wrong educational institution';
        }
        if (isset($_POST['department']) && !is_string($_POST['department'])) {
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
        if (!isset($_POST['status']) || !is_numeric($_POST['status']) || !in_array($_POST['status'], array(0, 1, 2))) {
          $errors['status'] = 'Wrong status';
        }
        if ((!isset($_POST['password']) || !is_string($_POST['password']) || !$_POST['password']) && (!isset($_POST['id']) || !is_numeric($_POST['id']) || !Models::get('Users')->get(array('id' => $_POST['id'])))) {
          $errors['password'] = 'Password is required';
        }
        elseif (isset($_POST['password']) && $_POST['password'] && !is_string($_POST['password'])) {
          $errors['password'] = 'Wrong password';
        }
        if (!isset($_POST['newbie']) || !is_numeric($_POST['newbie']) || !in_array($_POST['newbie'], array('0', '1'), true)) {
          $errors['newbie'] = 'Wrong newbie value';
        }
  
        if (!$errors) {
          if (isset($_FILES['image']['error']) && !$_FILES['image']['error']) {
            $_POST['image'] = CropImage::saveUploadedImage($_FILES['image']['tmp_name']);
            if (isset($_POST['id']) && is_numeric($_POST['id']) && $user = Models::get('Users')->get(array('id' => $_POST['id'])))
              CropImage::deleteImage($user[$_POST['id']]['image']);
          }
          elseif (isset($_POST['delete_image'])) {
            $_POST['image'] = '';
            if (isset($_POST['id']) && is_numeric($_POST['id']) && $user = Models::get('Users')->get(array('id' => $_POST['id'])))
              CropImage::deleteImage($user[$_POST['id']]['image']);
          }
          if (isset($_POST['social'])) unset($_POST['social']);
          if (isset($_POST['register_date'])) unset($_POST['register_date']);
          if (isset($_POST['password']) && (!is_string($_POST['password']) || !$_POST['password'])) unset($_POST['password']);
          Models::get('Users')->save($_POST);
          $this->redirect('/a-panel/users');
        }
        else {
          return Views::getContent('a-panel/base', array('title' => 'Users', 'content' => Views::getContent('a-panel/users', array('form' => true, 'errors' => $errors, 'user' => $_POST, 'specialties' => Models::get('Specialties')->get()))));
        }
      }
      else {
        $this->redirect('/a-panel/users');
      }
    }
    else return Views::getContent('403');
  }

  public function deleteUserAction() {
    if (isset($_SESSION['admin_login'])) {
      if ($this->arg(2) && is_numeric($this->arg(2))) {
        Models::get('Users')->delete($this->arg(2));
      }
      $this->redirect('/a-panel/users');
    }
    else $this->redirect('/a-panel/login');
  }

  public function promptsAction() {
    if (isset($_SESSION['admin_login'])) {
      $args = array('form' => false);
      if ($this->arg(2) == 'add') {
        $args['form'] = true;
      }
      elseif ($this->arg(2) == 'edit' && is_numeric($this->arg(3)) && $this->arg(3) > 0 && $prompt = Models::get('Prompts')->get($this->arg(3))) {
        $args['form'] = true;
        $args['prompt'] = $prompt;
      }
      else {
        $prompts = Models::get('Prompts')->get();
        $navigation = new Navigation(20, isset($_GET['page']) ? $_GET['page'] : 1, $prompts);
        $args['materials'] = $navigation->getMaterialsList();
        $args['pager'] = $navigation->getPager();
        $args['total_prompts'] = count($prompts);
      }
      return Views::getContent('a-panel/base', array('title' => 'Prompts', 'content' => Views::getContent('a-panel/prompts', $args)));
    }
    else return Views::getContent('403');
  }

  public function savePromptAction() {
    if (isset($_SESSION['admin_login'])) {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
  
        if (!$errors) {
          Models::get('Prompts')->save($_POST); 
          $this->redirect('/a-panel/prompts');
        }
        else {
          return Views::getContent('a-panel/base', array('title' => 'Prompts', 'content' => Views::getContent('a-panel/prompts', array('form' => true, 'errors' => $errors, 'prompt' => $_POST))));
        }
      }
      else {
        $this->redirect('/a-panel/prompts');
      }
    }
    else return Views::getContent('403');
  }

  public function deletePromptAction () {
    if (isset($_SESSION['admin_login'])) {
      if ($this->arg(2) && is_numeric($this->arg(2))) {
        Models::get('Prompts')->delete($this->arg(2));
      }
      $this->redirect('/a-panel/prompts');
    }
    else $this->redirect('/a-panel/login');
  }

  public function deliverTimeAction() {
    if (isset($_SESSION['admin_login'])) {
      $args = array('form' => false);
      if ($this->arg(2) == 'add') {
        $args['form'] = true;
      }
      elseif ($this->arg(2) == 'edit' && is_numeric($this->arg(3)) && $this->arg(3) > 0 && $dtime = DB::connect()->query("SELECT * FROM delivery_time WHERE id = " . $this->arg(3))->fetch_assoc()) {
        $args['form'] = true;
        $args['dtime'] = $dtime;
      }
      else {
        $dtimes = Models::get('DeliveryTime')->get();
        $navigation = new Navigation(20, isset($_GET['page']) ? $_GET['page'] : 1, $dtimes);
        $args['materials'] = $navigation->getMaterialsList();
        $args['pager'] = $navigation->getPager();
        $args['total_dtimes'] = count($dtimes);
      }
      return Views::getContent('a-panel/base', array('title' => 'Delivery time', 'content' => Views::getContent('a-panel/delivery_times', $args)));
    }
    else return Views::getContent('403');
  }

  public function saveDeliveryTimeAction() {
    if (isset($_SESSION['admin_login'])) {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        if (!isset($_POST['name']) || !is_string($_POST['name']) || !$_POST['name']) {
          $errors['name'] = 'Name is required';
        }
        if (!isset($_POST['price']) || !is_numeric($_POST['price'])) {
          $errors['price'] = 'Price must be numeric';
        }

        if (!$errors) {
          $name = addslashes($_POST['name']);
          $price = $_POST['price'];
          $by_default = isset($_POST['by_default']) ? 1 : 0;
          $id = isset($_POST['id']) && is_numeric($_POST['id']) && DB::connect()->query("SELECT * FROM delivery_time WHERE id = " . $_POST['id'])->fetch_assoc() ? $_POST['id'] : 0;
          DB::connect()->query("INSERT INTO delivery_time (id, name, price, by_default) VALUES ($id, '$name', $price, $by_default) ON DUPLICATE KEY UPDATE name = VALUES(name), price = VALUES(price), by_default = VALUES(by_default)");
          $this->redirect('/a-panel/deliverTime');
        }
        else {
          return Views::getContent('a-panel/base', array('title' => 'Delivery time', 'content' => Views::getContent('a-panel/delivery_times', array('form' => true, 'errors' => $errors, 'dtime' => $_POST))));
        }
      }
      else {
        $this->redirect('/a-panel/deliverTime');
      }
    }
    else {
      $this->redirect('/a-panel/login');
    }
  }

  public function deleteDeliverTimeAction() {
    if (isset($_SESSION['admin_login'])) {
      if ($this->arg(2) && is_numeric($this->arg(2)) && $dtime = DB::connect()->query("SELECT * FROM delivery_time WHERE id = " . $this->arg(2))->fetch_assoc()) {
        DB::connect()->query("DELETE FROM delivery_time WHERE id = " . $this->arg(2));
      }
      $this->redirect('/a-panel/deliverTime');
    }
    else {
      $this->redirect('/a-panel/login');
    }
  }

  public function emailEventsAction() {
    if (isset($_SESSION['admin_login'])) {
      $errors = array();
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!$errors) {
          $field_values = array();
          foreach ($_POST['email_events'] as $key => $values) {
            if (is_string($key) && isset($values['subject']) && is_string($values['subject']) && isset($values['body']) && is_string($values['body']))
              $field_values[] = "('" . addslashes($this->removeScripts($key)) . "', '" . addslashes($this->removeScripts($values['subject'])) . "', '" . addslashes($this->removeScripts($values['body'])) . "')";
          }
          if ($field_values)
            DB::connect()->query("INSERT INTO email_events (event_key, subject, body) VALUES " . implode(', ', $field_values) . " ON DUPLICATE KEY UPDATE subject = VALUES(subject), body = VALUES(body)");
          $this->redirect('/a-panel/emailEvents');
        }
      }
      $email_events = array();
      $result = DB::connect()->query("SELECT * FROM email_events");
      while ($res = $result->fetch_assoc()) {
        $email_events[$res['event_key']] = $res;
      }
      return Views::getContent('a-panel/base', array('title' => 'Email events', 'content' => Views::getContent('a-panel/email_events', array('errors' => $errors, 'email_events' => $_SERVER['REQUEST_METHOD'] == 'POST' ? (isset($_POST['email_events']) && is_array($_POST['email_events']) ? $_POST['email_events'] : array()) : $email_events))));
    }
  }

  public function smsEventsAction() {
    if (isset($_SESSION['admin_login'])) {
      $errors = array();
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!$errors) {
          $field_values = array();
          foreach ($_POST['sms_events'] as $key => $value) {
            if (is_string($key) && is_string($value))
              $field_values[] = "('" . addslashes($this->removeScripts($key)) . "', '" . addslashes($this->removeScripts($value)) . "')";
          }
          if ($field_values)
            DB::connect()->query("INSERT INTO sms_events (event_key, text) VALUES " . implode(', ', $field_values) . " ON DUPLICATE KEY UPDATE text = VALUES(text)");
          $this->redirect('/a-panel/smsEvents');
        }
      }
      $sms_events = array();
      $result = DB::connect()->query("SELECT * FROM sms_events");
      while ($res = $result->fetch_assoc()) {
        $sms_events[$res['event_key']] = $res['text'];
      }
      return Views::getContent('a-panel/base', array('title' => 'Sms events', 'content' => Views::getContent('a-panel/sms_events', array('errors' => $errors, 'sms_events' => $_SERVER['REQUEST_METHOD'] == 'POST' ? (isset($_POST['sms_events']) && is_array($_POST['sms_events']) ? $_POST['sms_events'] : array()) : $sms_events))));
    }
  }

  public function citiesAction() {
    if (isset($_SESSION['admin_login'])) {
      $errors = array();
      $args = array('form' => false);
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_POST['name']) || !is_string($_POST['name']) || !$this->removeScripts(strip_tags($_POST['name']))) {
          $errors['name'] = 'Wrong name';
        }
        if (isset($_POST['id']) && (!is_numeric($_POST['id']) || !Models::get('Cities')->get(array('id' => $_POST['id'])))) {
          $errors['id'] = 'City not exists';
        }

        if (!$errors) {
          Models::get('Cities')->save($_POST);
          $this->redirect('/a-panel/cities');
        }
        else {
          $args['city'] = $_POST;
        }
      }
      else {
        if ($this->arg(2) == 'add') {
          $args['form'] = true;
        }
        elseif ($this->arg(2) == 'edit' && is_numeric($this->arg(3)) && $this->arg(3) > 0 && $city = Models::get('Cities')->get(array('id' => $this->arg(3)))) {
          $args['form'] = true;
          $args['city'] = $city;
        }
        elseif ($this->arg(2) == 'delete' && is_numeric($this->arg(3)) && $this->arg(3) > 0 && $city = Models::get('Cities')->get(array('id' => $this->arg(3)))) {
          Models::get('Cities')->delete($this->arg(3));
          $this->redirect('/a-panel/cities');
        }
        else {
          $cities = Models::get('Cities')->get();
          $navigation = new Navigation(20, isset($_GET['page']) ? $_GET['page'] : 1, $cities);
          $args['materials'] = $navigation->getMaterialsList();
          $args['pager'] = $navigation->getPager();
          $args['total_cities'] = count($cities);
        }
      }
      return Views::getContent('a-panel/base', array('title' => 'Cities', 'content' => Views::getContent('a-panel/cities', $args)));
    }
  }

  public function ipDataAction() {
    $ip = array();
    $result = DB::connect()->query("SELECT * FROM ip_address_data ORDER BY id DESC");
    while ($res = $result->fetch_assoc()) {
      $ip[] = $res;
    }
    $navigation = new Navigation(20, isset($_GET['page']) ? $_GET['page'] : 1, $ip);
    $args['materials'] = $navigation->getMaterialsList();
    $args['pager'] = $navigation->getPager();
    $args['total_ip'] = count($ip);
    return Views::getContent('a-panel/base', array('title' => 'IP', 'content' => Views::getContent('a-panel/ip', $args)));
  }

  public function mailingAction() {
    if (isset($_SESSION['admin_login'])) {
      return Views::getContent('a-panel/base', array('title' => 'Mailing', 'content' => Views::getContent('a-panel/mailing', array('specialties' => $specialties = Models::get('Specialties')->get()))));
    }
  }

  public function sendMailingAction() {
    $errors = array();
    if (!isset($_POST['subject']) || !is_string($_POST['subject']) || !$_POST['subject']) {
      $errors['subject'] = 'Subject is required';
    }
    if (!isset($_POST['message']) || !is_string($_POST['message']) || !$_POST['message']) {
      $errors['message'] = 'Message is required';
    }
    if (!$errors) {
      $users = isset($_POST['specialties']) && is_numeric($_POST['specialties']) && $_POST['specialties'] > 0 ? Models::get('Users')->get(array('specialty' => $_POST['specialties'])) : Models::get('Users')->get();
      foreach ($users as $user) {
        mail($user['email'], $_POST['subject'], $_POST['message'], 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=utf-8' . "\r\n");
      }
      $this->redirect('/a-panel/mailing');
    }
    else {
      return Views::getContent('a-panel/base', array('title' => 'Mailing', 'content' => Views::getContent('a-panel/mailing', array('specialties' => Models::get('Specialties')->get(), 'errors' => $errors, 'subject' => $_POST['subject'], 'message' => $_POST['message']))));
    }
  }

  public function couponMailingAction() {
    if (isset($_SESSION['admin_login'])) {
      return Views::getContent('a-panel/base', array('title' => 'Coupon mailing', 'content' => Views::getContent('a-panel/couponMailing', array('specialties' => Models::get('Specialties')->get()))));
    }
  }

  public function sendCouponMailingAction() {
    $errors = array();
    if (isset($_POST['email']) && $_POST['email'] && !is_string($_POST['email'])) {
      $errors['email'] = 'Wrong email';
    }
    elseif (isset($_POST['email']) && $_POST['email'] && (!isset($_POST['name']) || !$_POST['name'] || !is_string($_POST['name']))) {
      $errors['name'] = 'Name is required';
    }
    if (!isset($_POST['subject']) || !is_string($_POST['subject']) || !$_POST['subject']) {
      $errors['subject'] = 'Subject is required';
    }
    if (!isset($_POST['discount']) || !is_numeric($_POST['discount'])) {
      $errors['discount'] = 'Discount is required';
    }
    elseif ($_POST['discount'] < 0) {
      $errors['discount'] = 'Discount can not be less than 0';
    }
    elseif ($_POST['discount'] > 100) {
      $errors['discount'] = 'Discount can not be more than 100';
    }
    if (!isset($_POST['valid_till_day']) || !is_numeric($_POST['valid_till_day']) || $_POST['valid_till_day'] <= 0 || $_POST['valid_till_day'] > 31 ||
        !isset($_POST['valid_till_month']) || !is_numeric($_POST['valid_till_month']) || $_POST['valid_till_month'] <= 0 || $_POST['valid_till_month'] > 12 ||
        !isset($_POST['valid_till_year']) || !is_numeric($_POST['valid_till_year']) || $_POST['valid_till_year'] < date('Y') || $_POST['valid_till_year'] > date('Y') + 5 ||
        mktime(0, 0, 0, date('n'), date('j'), date('Y')) > mktime(0, 0, 0, $_POST['valid_till_month'], $_POST['valid_till_day'], $_POST['valid_till_year'])) {
      $errors['date'] = 'Wrong date';
    }
    if (!$errors) {
      $users = isset($_POST['email']) && $_POST['email'] ? array(array('email' => $_POST['email'], 'name' => $_POST['name'])) :
      (isset($_POST['specialties']) && is_numeric($_POST['specialties']) && $_POST['specialties'] > 0 ? Models::get('Users')->get(array('specialty' => $_POST['specialties'])) : Models::get('Users')->get());
      foreach ($users as $user) {
        $coupon = Models::get('Coupons')->create(array(
          'discount' => $_POST['discount'],
          'day' => $_POST['valid_till_day'],
          'month' => $_POST['valid_till_month'],
          'year' => $_POST['valid_till_year']
        ));
        mail($user['email'], $_POST['subject'], Views::getContent('a-panel/couponEmail', array('coupon' => $coupon, 'name' => $user['name'], 'discount' => $_POST['discount'])), 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=utf-8' . "\r\n");
      }
      $this->redirect('/a-panel/couponMailing');
    }
    else {
      return Views::getContent('a-panel/base', array('title' => 'Coupon mailing', 'content' => Views::getContent('a-panel/couponMailing', array('specialties' => Models::get('Specialties')->get(), 'errors' => $errors, 'valid_till_day' => $_POST['valid_till_day'], 'valid_till_month' => $_POST['valid_till_month'], 'valid_till_year' => $_POST['valid_till_year'], 'discount' => $_POST['discount'], 'subject' => $_POST['subject'], 'email' => $_POST['email'], 'name' => $_POST['name']))));
    }
  }

  public function loginAction() {
    if (!isset($_SESSION['admin_login']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
      if ($_POST['login'] == 'admin' && $_POST['password'] == 'qazwsx') {
        $_SESSION['admin_login'] = true;
        $this->redirect('/a-panel');
      }
      else {
        return Views::getContent('a-panel/login', array('error' => true));
      }
    }
    else {
      $this->redirect('/a-panel');
    }
  }

  public function logoutAction() {
    unset($_SESSION['admin_login']);
    $this->redirect('/a-panel');
  }
}


?>