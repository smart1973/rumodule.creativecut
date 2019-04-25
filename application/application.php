<?php

Map::setPath(array('path' => 'a-panel(/%)', 'folder' => 'a-panel'));
Map::setPath(array('path' => 'save-file', 'action' => 'saveFile'));
Map::setPath(array('path' => 'register', 'action' => 'register'));
Map::setPath(array('path' => 'logout', 'action' => 'logout'));
Map::setPath(array('path' => 'login', 'action' => 'login'));
Map::setPath(array('path' => 'registration', 'action' => 'registration'));
Map::setPath(array('path' => 'save-bid', 'action' => 'saveBid'));
Map::setPath(array('path' => 'personal', 'action' => 'personal'));
Map::setPath(array('path' => 'your-objects', 'action' => 'yourObjects'));
Map::setPath(array('path' => 'your-orders', 'action' => 'yourOrders'));
Map::setPath(array('path' => 'deleteBid/[0-9]+', 'action' => 'deleteBid'));
Map::setPath(array('path' => 'cart', 'action' => 'cart'));
Map::setPath(array('path' => 'facebook', 'action' => 'facebook'));
Map::setPath(array('path' => 'google', 'action' => 'google'));
Map::setPath(array('path' => 'userAdditionalData', 'action' => 'userAdditionalData'));
Map::setPath(array('path' => 'file/\d+/?', 'action' => 'file'));
Map::setPath(array('path' => 'load-file', 'action' => 'loadFile'));
Map::setPath(array('path' => 'cron(/%)'));
Map::setPath(array('path' => 'sendSms', 'action' => 'sendSms'));
Map::setPath(array('path' => 'forgot-password', 'action' => 'forgotPassword'));
Map::setPath(array('path' => 'public-files', 'action' => 'publicFiles'));
Map::setPath(array('path' => 'save-mce-image', 'action' => 'saveMceImage'));
Map::setPath(array('path' => 'check-coupon', 'action' => 'checkCoupon'));
Map::setPath(array('path' => 'notify-payment', 'action' => 'notifyPayment'));
Map::setPath(array('path' => 'insert-ip-data', 'action' => 'insertIpData'));

CropImage::addPreset('50x50', array(array(50, 50, 'crop')));
CropImage::addPreset('200x200', array(array(200, 200, 'resize with background')));

?>