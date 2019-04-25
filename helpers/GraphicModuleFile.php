<?php

class GraphicModuleFile {

  protected static $allowedExtensions = array('dxf');

  protected $path;

  protected $data;

  public function __construct($path) {
    if (in_array($ext = strtolower(substr(strrchr($path, '.'), 1)), self::$allowedExtensions)) {
      $this->path = $path;
    }
    else {
      $this->data = array();
    }
  }

  public function getData($sections = array()) {
    $this->parseFileDXF($this->path, false, $sections);
    $data = $this->data;
    $this->data = array();
    return $data;
  }

  public function getContext($ext) {
    $contexts = array('2d' => array('dxf'), '3d' => array());
    foreach ($contexts as $context => $extensions) {
      if (in_array($ext, $extensions)) return $context;
    }
    return false;
  }

  public static function getAllowedExtensions() {
    return self::$allowedExtensions;
  }

  public function changeSizes($d, $entities_to_delete = array(), $turn = false) {
    if (!is_numeric($d) || $d < 0) $d = 1;
    $this->parseFileDXF($this->path, false, array('TABLES'));
    $tables = $this->data['TABLES'];
    $this->parseFileDXF($this->path, true);
    $data = $this->data;
    $this->data = array();
    if (isset($data['HEADER'])) {
      foreach ($data['HEADER'] as $line => $value) {
        if (in_array(trim($value), array('$EXTMIN', '$EXTMAX'))) {
          if (is_numeric(trim($data['HEADER'][$line + 2]))) $data['HEADER'][$line + 2] = trim($data['HEADER'][$line + 2]) * $d;
          if (is_numeric(trim($data['HEADER'][$line + 4]))) $data['HEADER'][$line + 4] = trim($data['HEADER'][$line + 4]) * $d;
          if (is_numeric(trim($data['HEADER'][$line + 6]))) $data['HEADER'][$line + 6] = trim($data['HEADER'][$line + 6]) * $d;
          if ($turn && is_numeric(trim($data['HEADER'][$line + 2])) && is_numeric(trim($data['HEADER'][$line + 4]))) {
            $x_value = trim($data['HEADER'][$line + 2]);
            $data['HEADER'][$line + 2] = trim($data['HEADER'][$line + 4]);
            $data['HEADER'][$line + 4] = $x_value;
          }
        }
      }
    }
    if (isset($data['ENTITIES'])) {
      $entity = '';
      $lines_to_delete = array();
      if ($turn) {
        $line_correction = 0;
        $splice_entities = function () use (&$line_correction, &$data, &$lines) {
          foreach (array('11' => array('1', '1.0'), '21' => array('11', '0.0'), '31' => array('21', '0.0')) as $v => $bv) {
            if (!isset($lines[$v]) && isset($lines[$bv[0]])) {
              array_splice($data['ENTITIES'], $lines[$bv[0]] + 2 + $line_correction, 0, array(' ' . $v . PHP_EOL, $bv[1] . PHP_EOL));
              $line_correction += 2;
              $lines[$v] = $lines[$bv[0]];
            }
          }
        };
        foreach ($data['ENTITIES'] as $line => $value) {
          if (!($line % 2)) {
            if (trim($value) === '0') {
              if (isset($entity) && $entity === 'MTEXT') {
                $splice_entities();
              }
              $lines = array();
              $entity = trim($data['ENTITIES'][$line + 1 + $line_correction]);
            }
            if ($entity === 'MTEXT' && in_array(trim($value), array('1', '11', '21', '31'))) {
              $lines[trim($value)] = $line;
            }
          }
        }
        if (isset($entity) && $entity === 'MTEXT') {
          $splice_entities();
        }
        foreach ($data['ENTITIES'] as $line => $value) {
          if (!($line % 2)) {
            if (trim($value) === '0') {
              $entity = trim($data['ENTITIES'][$line + 1]);
            }
            if (trim($value) === '10' && is_numeric(trim($data['ENTITIES'][$line + 1])) && trim($data['ENTITIES'][$line + 2]) === '20' && is_numeric(trim($data['ENTITIES'][$line + 3]))) {
              $x_value = trim($data['ENTITIES'][$line + 1]);
              $data['ENTITIES'][$line + 1] = trim($data['ENTITIES'][$line + 3]);
              $data['ENTITIES'][$line + 3] = - $x_value;
            }
            if (in_array($entity, array('ELLIPSE', 'MTEXT', 'LINE')) && trim($value) === '11' && is_numeric(trim($data['ENTITIES'][$line + 1])) && trim($data['ENTITIES'][$line + 2]) === '21' && is_numeric(trim($data['ENTITIES'][$line + 3]))) {
              $x_value = trim($data['ENTITIES'][$line + 1]);
              $data['ENTITIES'][$line + 1] = trim($data['ENTITIES'][$line + 3]);
              $data['ENTITIES'][$line + 3] =  - $x_value;
            }
            if ($entity === 'ARC' && trim($value) === '50' && is_numeric(trim($data['ENTITIES'][$line + 1])) && trim($data['ENTITIES'][$line + 2]) === '51' && is_numeric(trim($data['ENTITIES'][$line + 3]))) {
              $data['ENTITIES'][$line + 1] = number_format($this->checkDegree(trim($data['ENTITIES'][$line + 1]) - 90), 1, '.', ',');
              $data['ENTITIES'][$line + 3] = number_format($this->checkDegree(trim($data['ENTITIES'][$line + 3]) - 90), 1, '.', ',');
            }
          }
          $entity_lines[] = $line;
        }
      }
      foreach ($data['ENTITIES'] as $line => $value) {
        if (!($line % 2)) {
          if (trim($value) === '0') {
            if (isset($entity_delete) && ($entity_delete || ($entity_delete === '' && in_array(0, $entities_to_delete)))) {
              $lines_to_delete = array_merge($lines_to_delete, $entity_lines);
            }

            $entity = trim($data['ENTITIES'][$line + 1]);
            $entity_delete = '';
            $entity_lines = array();
          }
          if (trim($value) === '62') {
            if (in_array(trim($data['ENTITIES'][$line + 1]), $entities_to_delete) || (trim($data['ENTITIES'][$line + 1]) == 7 && in_array(0, $entities_to_delete))) $entity_delete = true;
            else $entity_delete = false;
          }
          if (trim($value) === '8' && $entity_delete === '') {
            if (isset($tables['LAYER'])) {
              foreach ($tables['LAYER'] as $colomn) {
                if (isset($colomn[2]) && $colomn[2] == trim($data['ENTITIES'][$line + 1]) && isset($colomn[62])) {
                  if (in_array($colomn[62], $entities_to_delete) || ($colomn[62] == 7 && in_array(0, $entities_to_delete))) $entity_delete = true;
                  else $entity_delete = false;
                  break;
                }
              }
            }
          }
          if ((in_array(trim($value), array('10', '20', '30', '11', '21', '31')) || (in_array($entity, array('MTEXT', 'ARC', 'CIRCLE')) && trim($value) === '40')) && is_numeric(trim($data['ENTITIES'][$line + 1]))) {
            $data['ENTITIES'][$line + 1] = trim($data['ENTITIES'][$line + 1]) * $d;
          }
        }
        $entity_lines[] = $line;
      }
      if (isset($entity_delete) && ($entity_delete || ($entity_delete === '' && in_array(0, $entities_to_delete)))) {
        $lines_to_delete = array_merge($lines_to_delete, $entity_lines);
      }
      foreach ($lines_to_delete as $line) unset($data['ENTITIES'][$line]);
    }
    $file_data = '';
    $first = true;
    foreach ($data as $section => $content) {
      if ($first) $first = false;
      else $file_data .= PHP_EOL;
      $file_data .= '  0' . PHP_EOL . 'SECTION' . PHP_EOL . '  2' . PHP_EOL . $section;
      foreach ($content as $val) {
        $file_data .= PHP_EOL . str_replace(array("\n", "\r"), '', $val);
      }
      $file_data .= PHP_EOL . '  0' . PHP_EOL . 'ENDSEC';
    }
    file_put_contents($this->path, $file_data);
  }

  public function checkDegree($d) {
    while ($d < 0) $d += 360;
    while ($d > 360) $d -= 360;
    return $d;
  }

  protected function parseFileDXF($content, $default_section = false, $only_sections = array()) {
    $file = file($content);
    $section = '';
    $this->data = array();
    for ($i = 0; $i < count($file); $i++) {
      if (trim($file[$i]) === '0') {
        if (trim($file[$i + 1]) === 'SECTION' && trim($file[$i + 2]) === '2' && (!$only_sections || in_array(trim($file[$i + 3]), $only_sections))) {
          $section = trim($file[$i + 3]);
          $i = $i + 4;
          if (trim($file[$i + 1]) !== 'ENDSEC') {
            if (!$default_section && method_exists($this, $method = 'DXFSection' . $section)) {
              $this->data[$section] = $this->$method($i, $file);
            }
            else {
              $this->data[$section] = $this->DXSDefaultSection($i, $file);
            }
          }
          else $i++;
        }
        elseif (trim($file[$i + 1]) === 'ENDSEC') {
          $section = '';
          $i++;
        }
      }
    }
  }

  public function DXSDefaultSection(&$line, $file) {
    $data = array();
    while (trim($file[$line + 1]) !== '0' || trim($file[$line + 2]) !== 'ENDSEC') {
      $data[] = $file[$line++];
    }
    $data[] = $file[$line];
    return $data;
  }

  public function DXFSectionHEADER(&$line, $file) {
    $data = array();
    if (trim($file[$line]) === '9') {
      while (trim($file[$line]) !== '0') {
        $var_name = trim($file[++$line]);
        while (trim($file[$line + 1]) !== '9' && trim($file[$line + 1]) !== '0') {
          $data[$var_name][trim($file[++$line])] = trim($file[++$line]);
        }
        $line++;
      }
    }
    return $data;
  }

  //public function DXFSectionCLASSES(&$line, $file) {
  //  $data = array();
  //  while (trim($file[$line]) === '0' && trim($file[$line + 1]) === 'CLASS') {
  //    $line++;
  //    $class = array();
  //    for ($n = 3; $n--;) {
  //      $class[trim($file[++$line])] = trim($file[++$line]);
  //    }
  //    while (trim($file[$line + 1]) !== '0') {
  //      $class['flags'][trim($file[++$line])] = trim($file[++$line]);
  //    }
  //    $line++;
  //    $data[] = $class;
  //  }
  //  return $data;
  //}

  public function DXFSectionTABLES(&$line, $file) {
    $data = array();
    while (trim($file[$line]) === '0' && trim($file[$line + 1]) === 'TABLE') {
      $line++;
      $table_name = trim($file[$line + 2]);
      $table = array();
      while (trim($file[$line + 1]) !== '0' || trim($file[$line + 2]) !== 'ENDTAB') {
        $line = $line + 2;
        $colomn = array();
        while (trim($file[$line + 1]) !== '0') {
          $colomn[trim($file[++$line])] = trim($file[++$line]);
        }
        $table[] = $colomn;
      }
      $line = $line + 3;
      $data[$table_name] = $table;
    }
    return $data;
  }

  public function DXFSectionBLOCKS(&$line, $file) {
    $data = array();
    while (trim($file[$line]) === '0' && trim($file[$line + 1]) === 'BLOCK') {
      $line++;
      $block = array();
      $entities = array();
      while (trim($file[$line + 1]) !== '0' || !in_array(trim($file[$line + 2]), array('BLOCK', 'ENDSEC'), true)) {
        if (trim($file[$line + 1]) === '0' && trim($file[$line + 2]) !== 'ENDBLK') {
          if (method_exists($this, $method = 'DXFEntity' . ($type = trim($file[$line += 2])))) {
            $entities[] = $this->DXFPreEntity($this->$method($line, $file));
          }
          else {
            $line++;
            while (trim($file[$line]) !== '0') $line = $line + 2;
          }
          $line--;
        }
        else $block[trim($file[++$line])] = trim($file[++$line]);
      }
      $line++;
      $block['entities'] = $entities;
      $data[$block[2]] = $block;
    }
    return $data;
  }

  public function DXFSectionENTITIES(&$line, $file) {
    $data = array();
    while (trim($file[$line]) === '0' && trim($file[$line + 1]) !== 'ENDSEC') {
      if (method_exists($this, $method = 'DXFEntity' . ($type = trim($file[++$line])))) {
        $data[] = $this->DXFPreEntity($this->$method($line, $file));
      }
      else {
        $line++;
        while (trim($file[$line]) !== '0') $line = $line + 2;
      }
    }
    $this->DXFParseINSERT($data);
    return $data;
  }

  public function DXFParseINSERT(&$data) {
    $splice = 0;
    $original_data = $data;
    foreach ($original_data as $k => $entity) {
      if (in_array($entity['type'], array('INSERT', 'DIMENSION'))) {
        if (isset($entity['2']) && isset($this->data['BLOCKS'][$entity['2']]) && $new_data = $this->data['BLOCKS'][$entity['2']]['entities']) {
          if ($entity['type'] == 'INSERT') {
            foreach ($new_data as &$new_entity) {
              if (isset($new_entity[10]) && isset($entity[10])) $new_entity[10] += $entity[10];
              if (isset($new_entity[20]) && isset($entity[20])) $new_entity[20] += $entity[20];
              if (isset($new_entity[30]) && isset($entity[30])) $new_entity[30] += $entity[30];
              if ($new_entity['type'] == 'LINE') {
                if (isset($new_entity[11]) && isset($entity[10])) $new_entity[11] += $entity[10];
                if (isset($new_entity[21]) && isset($entity[20])) $new_entity[21] += $entity[20];
                if (isset($new_entity[31]) && isset($entity[30])) $new_entity[31] += $entity[30];
              }
            }
          }
          $this->DXFParseINSERT($new_data);
          array_splice($data, $k + $splice, 1, $new_data);
          $splice += count($new_data) - 1;
        }
      }
    }
  }

  public function DXFPreEntity($entity) {
    if (!isset($entity[62]) && isset($entity[8]) && isset($this->data['TABLES']['LAYER'])) {
      foreach ($this->data['TABLES']['LAYER'] as $colomn) {
        if (isset($colomn[2]) && $colomn[2] == $entity[8] && isset($colomn[62])) {
          $entity[62] = $colomn[62];
          break;
        }
      }
    }
    if (isset($entity[62]) && $entity[62] == 7) $entity[62] = 0;
    return $entity;
  }

  public function DXFEntity3DFACE(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntity3DSOLID(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityACAD_PROXY_ENTITY(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityARC(&$line, $file) {
    $entity = array('type' => trim($file[$line]));

    while (trim($file[$line + 1]) !== '0') {
      $entity[trim($file[++$line])] = trim($file[++$line]);
    }
    $line++;

    return $entity;
  }

  public function DXFEntityARCALIGNEDTEXT(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityATTDEF(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityATTRIB(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityBODY(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityCIRCLE(&$line, $file) {
    $entity = array('type' => trim($file[$line]));

    while (trim($file[$line + 1]) !== '0') {
      $entity[trim($file[++$line])] = trim($file[++$line]);
    }
    $line++;

    return $entity;
  }

  public function DXFEntityDIMENSION(&$line, $file) {
    $entity = array('type' => trim($file[$line]));

    while (trim($file[$line + 1]) !== '0') {
      $entity[trim($file[++$line])] = trim($file[++$line]);
    }
    $line++;

    return $entity;
  }

  public function DXFEntityELLIPSE(&$line, $file) {
    $entity = array('type' => trim($file[$line]));

    while (trim($file[$line + 1]) !== '0') {
      switch (trim($file[$line + 1])) {
        case '10':
          for ($p = 3; $p--;) {
            $entity['center'][trim($file[++$line])] = trim($file[++$line]);
          }
          break;

        case '11':
          for ($p = 3; $p--;) {
            $entity['endpoint_of_major_axis'][trim($file[++$line])] = trim($file[++$line]);
          }
          break;

        case '210':
          for ($p = 3; $p--;) {
            $entity['extrusion_direction'][trim($file[++$line])] = trim($file[++$line]);
          }
          break;

        default:
          $entity[trim($file[++$line])] = trim($file[++$line]);
      }
    }
    $line++;

    return $entity;
  }

  public function DXFEntityHATCH(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityIMAGE(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityINSERT(&$line, $file) {
    $entity = array('type' => trim($file[$line]));

    while (trim($file[$line + 1]) !== '0') {
      $entity[trim($file[++$line])] = trim($file[++$line]);
    }
    $line++;

    return $entity;
  }

  public function DXFEntityLEADER(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityLINE(&$line, $file) {
    $entity = array('type' => trim($file[$line]));

    while (trim($file[$line + 1]) !== '0') {
      $entity[trim($file[++$line])] = trim($file[++$line]);
    }
    $line++;

    return $entity;
  }

  public function DXFEntityLWPOLYLINE(&$line, $file) {
    $entity = array('type' => trim($file[$line]));

    while (trim($file[$line + 1]) !== '0') {
      switch (trim($file[$line + 1])) {
        case '10':
          $primary_point = array();
          for ($p = 2; $p--;) {
            $primary_point[trim($file[++$line])] = trim($file[++$line]);
          }
          if (trim($file[$line + 1]) === '42') {
            $primary_point[trim($file[++$line])] = trim($file[++$line]);
          }
          $entity['control_points'][] = $primary_point;
          break;

        default:
          $entity[trim($file[++$line])] = trim($file[++$line]);
      }
    }
    $line++;

    return $entity;
  }

  public function DXFEntityMLINE(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityMTEXT(&$line, $file) {
    $entity = array('type' => trim($file[$line]));

    while (trim($file[$line + 1]) !== '0') {
      switch (trim($file[$line + 1])) {
        case '3':
          $entity['additional_texts'][] = trim($file[$line += 2]);
          break;

        case '1000':
          $entity['acad_mtext_column_info'][] = trim($file[$line += 2]);
          break;

        case '1040':
          $entity['data_float'][] = trim($file[$line += 2]);
          break;

        case '1070':
          $entity['data_integer'][] = trim($file[$line += 2]);
          break;

        case '1071':
          $entity['data_long'][] = trim($file[$line += 2]);
          break;

        default:
          $entity[trim($file[++$line])] = trim($file[++$line]);
      }
    }
    $line++;

    return $entity;
  }

  public function DXFEntityOLEFRAME(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityOLE2FRAME(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityPOINT(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityPOLYLINE(&$line, $file) {
    $entity = array('type' => trim($file[$line]));

    while (trim($file[$line + 1]) !== '0') {
      $entity[trim($file[++$line])] = trim($file[++$line]);
    }
    while (trim($file[$line + 2]) == 'VERTEX') {
      $line = $line + 2;
      $vertex = array();
      while (trim($file[$line + 1]) !== '0') {
        $vertex[trim($file[++$line])] = trim($file[++$line]);
      }
      $entity['control_points'][] = $vertex;
    }
    while (trim($file[$line + 2]) == 'SEQEND') {
      $line = $line + 2;
      $seqend = array();
      while (trim($file[$line + 1]) !== '0') {
        $seqend[trim($file[++$line])] = trim($file[++$line]);
      }
      $entity['seqend'][] = $vertex;
    }
    $line++;

    return $entity;
  }

  public function DXFEntityRAY(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityREGION(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityRTEXT(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntitySEQEND(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntitySHAPE(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntitySOLID(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntitySPLINE(&$line, $file) {
    $entity = array('type' => trim($file[$line]));

    while (trim($file[$line + 1]) !== '0') {
      switch (trim($file[$line + 1])) {
        case '40':
          $entity['knot_values'][] = trim($file[$line = $line + 2]);
          break;

        case '10':
          $primary_point = array();
          for ($p = 3; $p--;) {
            $primary_point[trim($file[++$line])] = trim($file[++$line]);
          }
          $entity['control_points'][] = $primary_point;
          break;

        default:
          $entity[trim($file[++$line])] = trim($file[++$line]);
      }
    }
    $line++;

    return $entity;
  }

  public function DXFEntityTEXT(&$line, $file) {
    $entity = array('type' => trim($file[$line]));

    while (trim($file[$line + 1]) !== '0') {
      $entity[trim($file[++$line])] = trim($file[++$line]);
    }
    $line++;

    return $entity;
  }

  public function DXFEntityTOLERANCE(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityTRACE(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityVERTEX(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityVIEWPORT(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityWIPEOUT(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }

  public function DXFEntityXLINE(&$line, $file) {
    $entity = array('type' => trim($file[$line]));
    $line++;
    while (trim($file[$line]) !== '0') $line = $line + 2;
    return $entity;
  }
}


?>