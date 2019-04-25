<?php

class DB {

  protected $databases = array(
    'default' => array(
      'host' => 'localhost',
      'user' => 'root',
      'passwrod' => 'admin',
      'name' => 'rumodule'
    )
    /* G7s2O9i6
       rumodule
    */
  );

  protected static $object;

  protected $connections = array();

  protected $db = 'default';

  protected function __construct($set_default) {
    if ($set_default) {
      $this->connections[$this->db] = new mysqli($this->databases[$this->db]['host'], $this->databases[$this->db]['user'], $this->databases[$this->db]['passwrod'], $this->databases[$this->db]['name']);
      $this->connections[$this->db]->set_charset('utf8');
    }
  }

  public static function setActiveDB($db = 'default') {
    self::checkObject();
    if (is_string($db) && array_key_exists($db, self::$object->databases)) {
      if ($db != self::$object->db) {
        self::$object->db = $db;
        if (!array_key_exists($db, self::$object->connections)) {
          self::$object->connections[$db] = new mysqli(self::$object->databases[$db]['host'], self::$object->databases[$db]['user'], self::$object->databases[$db]['passwrod'], self::$object->databases[$db]['name']);
          self::$object->connections[$db]->set_charset('utf8');
        }
      }
      return true;
    }
    return false;
  }
  
  protected static function checkObject($set_default = false) {
    if (!(self::$object instanceof self)) {
      self::$object = new self($set_default);
    }
    elseif ($set_default && !array_key_exists(self::$object->db, self::$object->connections)) self::$object->__construct(true);
  }

  public static function connect() {
    self::checkObject(true);
    return self::$object->connections[self::$object->db];
  }

}

?>