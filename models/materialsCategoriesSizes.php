<?php

class materialsCategoriesSizes {

  public function getCuttingTypes($id = false) {
    if ($id && is_numeric($id)) return DB::connect()->query("SELECT * FROM cutting_types WHERE id = $id")->fetch_assoc();
    $result = DB::connect()->query("SELECT * FROM cutting_types ORDER BY id DESC");
    $cutting_types = array();
    while ($res = $result->fetch_assoc()) {
      $cutting_types[$res['id']] = $res;
    }
    return $cutting_types;
  }

  public function getMaterials($id = false) {
    if ($id && is_numeric($id)) return DB::connect()->query("SELECT * FROM materials WHERE id = $id")->fetch_assoc();
    $result = DB::connect()->query("SELECT * FROM materials ORDER BY id DESC");
    $materials = array();
    while ($res = $result->fetch_assoc()) {
      $materials[$res['id']] = $res;
    }
    return $materials;
  }

  public function getMaterialsCategories($id = false) {
    if ($id && is_numeric($id)) return DB::connect()->query("SELECT * FROM material_categories WHERE id = $id")->fetch_assoc();
    $result = DB::connect()->query("SELECT * FROM material_categories ORDER BY id DESC");
    $material_categories = array();
    while ($res = $result->fetch_assoc()) {
      $material_categories[$res['id']] = $res;
    }
    return $material_categories;
  }

  public function getMaterialsSizes($id = false) {
    if ($id && is_numeric($id)) return DB::connect()->query("SELECT * FROM material_sizes WHERE id = $id")->fetch_assoc();
    $result = DB::connect()->query("SELECT * FROM material_sizes ORDER BY id DESC");
    $material_sizes = array();
    while ($res = $result->fetch_assoc()) {
      $material_sizes[$res['id']] = $res;
    }
    return $material_sizes;
  }
}

?>