<?php

class Navigation {

  protected $per_page;

  protected $page;

  protected $materials;

  protected $pager_size;

  protected $pages;
  
  public function __construct($per_page, $page, $materials, $pager_size = 6) {
    $this->per_page = $per_page;
    $this->pages = ceil(count($materials) / $per_page);
    $this->setPage($page);
    $this->materials = array_values($materials);
    $this->pager_size = $pager_size;
  }

  public function getMaterialsList() {
    $materials = array();
    for ($i = $this->per_page * ($this->page - 1); $i < $this->per_page * $this->page; $i++) {
      if (isset($this->materials[$i])) $materials[] = $this->materials[$i];
      else break;
    }
    return $materials;
  }

  public function getPager() {
    if (count($this->materials) <= $this->per_page) return array();
    if ($this->page > 1) $pager = array(array('link' => 1, 'num' => '<<'), array('link' => $this->page - 1, 'num' => '<'));
    else $pager = array();
    $from = $this->page < ceil($this->pager_size / 2) || $this->pages <= $this->pager_size ? 1 : ($this->page >= $this->pages - ceil($this->pager_size / 2) + 1 ? $this->pages - $this->pager_size + 1 : $this->page - ceil($this->pager_size / 2) + 1);
    for ($i = 0; $i < $this->pager_size; $i++) {
      if ($from > $this->pages) break;
      $pager[] = array('link' => $from, 'num' => $from);
      $from++;
    }
    if ($this->page < $this->pages) {
      $pager[] = array('link' => $this->page + 1, 'num' => '>');
      $pager[] = array('link' => $this->pages, 'num' => '>>');
    }
    return $pager;
  }

  public function setPage($page) {
    $this->page = is_numeric($page) ? ($page > 0 ? ($page > $this->pages ? $this->pages : $page) : 1) : 1;
  }
}

?>