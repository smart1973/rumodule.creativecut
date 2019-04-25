<?php

class CropImage {

  private $src, $gif_src, $gif, $pnt = 0, $gl_mn = '', $gl_palet = '', $gl_mod = '', $gl_mode = '', $int_w = 0, $int_h = 0, $au = 0, $er = 0, $nt = 0, $lp_frm = 0, $ar_frm = Array(), $gn_fld = Array(), $dl_frmf = Array(), $dl_frms = Array();
	private static $presets = array(), $exts = array('gif', 'jpeg', 'png');

	public function __construct($file_src, $opt) {
		if ($image = getimagesize($file_src)) {
			if ($image[2] === 1) {
				$this->gif_src = $file_src;
				$this->gif = file_get_contents($file_src);
				$this->gl_mn = $this->gtb(13);
				if (substr($this->gl_mn, 0, 3) != "GIF") {
						$this->er = 1;
						return 0;
				}
				$this->int_w = $this->rl_int($this->gl_mn[6] . $this->gl_mn[7]);
				$this->int_h = $this->rl_int($this->gl_mn[8] . $this->gl_mn[9]);
				if (($vt = ord($this->gl_mn[10])) & 128 ? 1 : 0) {
					$this->gl_palet = $this->gtb(pow(2, ($vt & 7) + 1) * 3);
				}
				$buffer_add = "";
				if($this->gif[$this->pnt] == "\x21") {		
					while ($this->gif[$this->pnt + 1] != "\xF9" && $this->gif[$this->pnt] != "\x2C") {
						switch ($this->gif[$this->pnt + 1]) {
							case "\xFE":
								$sum = 2;
								while (($lc_i = ord($this->gif[$this->pnt + $sum])) != 0x00) {
									$sum += $lc_i + 1;
								}
								$opt ? $this->gtb($sum + 1) : $buffer_add .= $this->gtb($sum + 1);
								break;
		
							case "\xFF":
								$sum = 14;
								while (($lc_i = ord($this->gif[$this->pnt + $sum])) != 0x00) {
									$sum += $lc_i + 1;
								}
								$buffer_add .= $this->gtb($sum + 1);
								break;
		
							case "\x01":
								$sum = 15;
								while (($lc_i = ord($this->gif[$this->pnt + $sum])) != 0x00) {
									$sum += $lc_i + 1;
								}
								$opt ? $this->gtb($sum + 1) : $buffer_add.=$this->gtb($sum + 1);
						}
					}
					$this->gl_mod = $buffer_add;
				}
		
				while ($this->gif[$this->pnt] != "\x3B" && $this->gif[$this->pnt + 1] != "\xFE" && $this->gif[$this->pnt + 1] != "\xFF" && $this->gif[$this->pnt + 1] != "\x01") {
					$lc_palet = '';
					$pzs_xy = Array();
					$gr_mod = '';
					$this->lp_frm++;
					while ($this->gif[$this->pnt] != "\x2C") {
						switch ($this->gif[$this->pnt + 1]) {
							case "\xF9":
								$this->gn_fld[] = $this->gif[$this->pnt + 3];
								$this->dl_frmf[] = $this->gif[$this->pnt + 4];
								$this->dl_frms[] = $this->gif[$this->pnt + 5];
								$gr_mod = $buffer_add = $this->gtb(8);
								break;
		
							case "\xFE":
								$sum = 2;
								while (($lc_i = ord($this->gif[$this->pnt + $sum])) != 0x00) {
									$sum+=$lc_i + 1;
								}
								$opt ? $this->gtb($sum + 1) : $buffer_add.=$this->gtb($sum + 1);
								break;
		
							case "\xFF":
								$sum = 14;
								while (($lc_i = ord($this->gif[$this->pnt + $sum])) != 0x00) {
									$sum+=$lc_i + 1;
								}
								if (substr($tmp_buf = $this->gtb($sum + 1), 3, 8) == "NETSCAPE") {
									if (!$this->nt) {
										$this->nt = 1;
										$this->gl_mod.=$tmp_buf;
									}
								}
								else {
									$buffer_add.=$tmp_buf;
								}
								break;
		
							case "\x01":
								$sum = 15;
								while (($lc_i = ord($this->gif[$this->pnt + $sum])) != 0x00) {
									$sum+=$lc_i + 1;
								}
								$opt ? $this->gtb($sum + 1) : $buffer_add.=$this->gtb($sum + 1);
						}
					}
					$lc_mod = $buffer_add;
					$pzs_xy[] = $this->ms_int(1, 2);
					$pzs_xy[] = $this->ms_int(3, 2);
					$pzs_xy[] = $this->ms_int(5, 2);
					$pzs_xy[] = $this->ms_int(7, 2);
					$head = $this->gtb(10);
		
					if((($pzs_xy[0] + $pzs_xy[2])-$this->int_w) > 0) {
						$head[1]= "\x00";
						$head[2]= "\x00";
						$head[5]= $this->int_raw($this->int_w);
						$head[6]= "\x00";
						
						$pzs_xy[0]=0;
						$pzs_xy[2]=$this->int_w;
					}
		
					if((($pzs_xy[1] + $pzs_xy[3])-$this->int_h) > 0) {
						$head[3] = "\x00";
						$head[4] = "\x00";
						$head[7] = $this->int_raw($this->int_h);
						$head[8] = "\x00";			
						$pzs_xy[1] = 0;
						$pzs_xy[3] = $this->int_h;
					}
					if ((ord($this->gif[$this->pnt - 1]) & 128 ? 1 : 0)) {
						$lc_i = pow(2, (ord($this->gif[$this->pnt - 1]) & 7) + 1) * 3;
						$lc_palet = $this->gtb($lc_i);
					}
					$sum = 0;
					$this->pnt++;
					while (($lc_i = ord($this->gif[$this->pnt + $sum])) != 0x00) {
						$sum += $lc_i + 1;
					}
					$this->pnt--;
					$this->ar_frm[] = new FRM($lc_mod, $lc_palet, $this->gtb($sum + 2), $head, $pzs_xy, $gr_mod);
				}
				$buffer_add = "";
				while ($this->gif[$this->pnt] != "\x3B") {
					switch ($this->gif[$this->pnt + 1]) {
						case "\xFE":
							$sum = 2;
							while (($lc_i = ord($this->gif[$this->pnt + $sum])) != 0x00) {
								$sum += $lc_i + 1;
							}
							$opt ? $this->gtb($sum + 1) : $buffer_add .= $this->gtb($sum + 1);
							if ($sum == 17) {
								$this->au = 1;
							}
							break;
		
						case "\xFF":	
							$sum = 14;
							while (($lc_i = ord($this->gif[$this->pnt + $sum])) != 0x00) {
								$sum += $lc_i + 1;
							}
							$buffer_add .= $this->gtb($sum + 1);
							break;
		
						case "\x01":	
							$sum = 15;
							while (($lc_i = ord($this->gif[$this->pnt + $sum])) != 0x00) {
								$sum += $lc_i + 1;
							}
							$opt ? $this->gtb($sum + 1) : $buffer_add.=$this->gtb($sum + 1);
					}
				}
				$this->gl_mode = $buffer_add;
				$this->gif = "";
			}
			else {
				$this->src = $file_src;
			}
		}
	}

	private function gtb($n) {
		$b = substr($this->gif, $this->pnt, $n);
		$this->pnt += $n;
		return $b;
	}

	private function rl_int($hw) {
		$z = ord(@$hw[1]) << 8;
		$c = ord(@$hw[0]);
		$x = $z | $c;
		return $x;
	}

	private function ms_int($g_f, $g_s) {
		return $this->rl_int(substr($this->gif, $this->pnt + $g_f, $g_s));
	}

	private function int_raw($t) {
		return chr($t & 255) . chr(($t & 0xFF00) >> 8);
	}

	private function cr_img($i) {
		return $this->gl_mn . $this->gl_palet . $this->gl_mod . $this->ar_frm[$i]->lc_mod . $this->ar_frm[$i]->head . $this->ar_frm[$i]->lc_palet . $this->ar_frm[$i]->image . "\x3B";
	}

	private function resize_img($b, $ind_f, $des) {
		$buf_n = round($this->ar_frm[$ind_f]->width_f * $des[0]);
		$n_width = $buf_n ? $buf_n : 1;
		$buf_n = round($this->ar_frm[$ind_f]->height_f * $des[1]);
		$n_height = $buf_n ? $buf_n : 1;
		$n_pos_x = round($this->ar_frm[$ind_f]->pos_x * $des[0]);
		$n_pos_y = round($this->ar_frm[$ind_f]->pos_y * $des[1]);
		$this->ar_frm[$ind_f]->off_xy = $this->int_raw($n_pos_x) . $this->int_raw($n_pos_y);
		$str_img = @imagecreatefromstring($b);
		if ($this->lp_frm == 1 || $des[3]) {
			$img_s = @imagecreatetruecolor($n_width + $des[2][0], $n_height + $des[2][1]); 
		}
		else {
			$img_s = @imagecreate($n_width + $des[2][0], $n_height + $des[2][1]);
		}
		if ($this->ar_frm[$ind_f]->tr_frm) {
			$in_trans = @imagecolortransparent($str_img);
			if ($in_trans >= 0 && $in_trans < @imagecolorstotal($img_s)) {
				$tr_clr = @imagecolorsforindex($str_img, $in_trans);
			}
			if ($this->lp_frm == 1 || $des[3]) {
				$n_trans = @imagecolorallocatealpha($img_s, 255, 255, 255, 127);
			}
			else {
				$n_trans = @imagecolorallocate($img_s, $tr_clr['red'], $tr_clr['green'], $tr_clr['blue']);
			}
			@imagecolortransparent($img_s, $n_trans);
			@imagefill($img_s, 0, 0, $n_trans);
		}
		@imagecopyresampled($img_s, $str_img, $des[2][0] / 2, $des[2][1] / 2, 0, 0, $n_width, $n_height, $this->ar_frm[$ind_f]->width_f, $this->ar_frm[$ind_f]->height_f);
		if (isset($des[4])) {
			$wm_s = imagecreatefromgif($des[4][4]);
			@imagecopyresampled($img_s, $wm_s, $des[4][2] - $n_pos_x, $des[4][3] - $n_pos_y, 0, 0, $des[4][0], $des[4][1], $des[4][0], $des[4][1]);
			@imagedestroy($wm_s);
		}
		@ob_start();
		@imagegif($img_s);
		$t_img = ob_get_clean();
		@imagedestroy($str_img);
		@imagedestroy($img_s);

		return $t_img;
	}

	private function rm_fld($str_img, $gr_i) {
		$hd = $offset = 13 + pow(2, (ord($str_img[10]) & 7) + 1) * 3;
		$palet = "";
		$i_hd = 0;
		$m_off = 0;
		for ($i = 13; $i < $offset; $i++) {
			$palet .= $str_img[$i];
		}
		if ($this->ar_frm[$gr_i]->tr_frm) {
			while ($str_img[$offset + $m_off] != "\xF9") {
				$m_off++;
			}
			$str_img[$offset + $m_off + 2] = $this->gn_fld[$gr_i];
			$str_img[$offset + $m_off + 3] = $this->dl_frmf[$gr_i];
			$str_img[$offset + $m_off + 4] = $this->dl_frms[$gr_i];
		}
		while($str_img[$offset] != "\x2C"){
			$offset = $offset + $this->rl_int($str_img[$offset+2]) + 4;
			$i_hd = $i_hd + $this->rl_int($str_img[$offset+2]) + 8;
		}
		$str_img[$offset + 1] = $this->ar_frm[$gr_i]->off_xy[0];
		$str_img[$offset + 2] = $this->ar_frm[$gr_i]->off_xy[1];
		$str_img[$offset + 3] = $this->ar_frm[$gr_i]->off_xy[2];
		$str_img[$offset + 4] = $this->ar_frm[$gr_i]->off_xy[3];
		$str_img[$offset + 9] = chr($str_img[$offset + 9] | 0x80 | (ord($str_img[10]) & 0x7));
		$ms1 = substr($str_img, $hd, $i_hd + 10);
		if (!$this->ar_frm[$gr_i]->tr_frm) {
			$ms1 = $this->ar_frm[$gr_i]->gr_mod . $ms1;
		}
		return $ms1 . $palet . substr(substr($str_img, $offset + 10), 0, -1);
	}

	public function resize($file_dst, $new_x, $new_y, $op) {
		if ($this->src) {
			return $this->imageTransform($this->src, $file_dst, $new_x, $new_y, $op);
		}
		else {
			$des = Array(0, 0, 0);
			switch ($op) {
				case 'crop':
				case 'resize with background':
					$pr = 1; $sm = 0; $fs = 1; $wm = '';
					break;

				case 'resize proportional':
					$pr = 1; $sm = 1; $fs = 0; $wm = '';
					break;

				case 'water mark':
					if (!file_exists($file_dst) || !$wm = getimagesize($file_dst)) return 0;
					if ($wm[2] !== 1) return 0;
					$coords = array('new_x' => array('int_w', 0), 'new_y' => array('int_h', 1));
          foreach ($coords as $coord => $param) {
            if (substr($$coord, -1) == '%' && is_numeric($proc = substr($$coord, 0, strlen($$coord) - 1))) {
              $$coord = round($this->$param[0] / 100 * $proc);
            }
            elseif ($$coord == 'top') {
              $$coord = 0;
            }
            elseif ($$coord == 'center') {
              $$coord = round(($this->$param[0] - $wm[$param[1]]) / 2);
            }
            elseif ($$coord == 'bottom') {
              $$coord = $this->$param[0] - $wm[$param[1]];
            }
          }
					$des[4] = array($wm[0], $wm[1], $new_x, $new_y, $file_dst);
					$new_x = $this->int_w; $new_y = $this->int_h;
					$pr = 1; $sm = 1; $fs = 0;
					$file_dst = $this->gif_src;
					break;
			}
			if ($this->er) {
				printf("ERROR: signature file is incorrectly");
				return 0;
			}
			if ($new_x == 0 || $new_y == 0) {
				printf("ERROR: size height or width can not be equal to zero");
				return 0;
			}
			$f_buf = "";
			$des[0] = $new_x / $this->int_w;
			$des[1] = $new_y / $this->int_h;
			$des[2] = array(0, 0);
			$des[3] = $sm;
			$des[5] = array($new_x, $new_y);
			if ($pr) {
				$rt = min($des[0], $des[1]);
				$des[0] == $rt ? $des[1] = $rt : $des[0] = $rt;
				if ($fs) $des[2] = array($new_x - $this->int_w * $rt, $new_y - $this->int_h * $rt);
				else $des[5] = array($this->int_w * $rt, $this->int_h * $rt);
			}
			for ($i = 0; $i < $this->lp_frm; $i++) {
				$f_buf .= $this->rm_fld($this->resize_img($this->cr_img($i), $i, $des), $i);
			}
			$gm = $this->gl_mn;
			$gm[10] = $gm[10] & 0x7F;
			$bf_t = round($this->int_w * $des[0] + $des[2][0]);
			$t = $this->int_raw($bf_t ? $bf_t : 1);
			$gm[6] = $t[0];
			$gm[7] = $t[1];
			$bf_t = round($this->int_h * $des[1] + $des[2][1]);
			$t = $this->int_raw($bf_t ? $bf_t : 1);
			$gm[8] = $t[0];
			$gm[9] = $t[1];
			if (strlen($this->gl_mode)) {
				$con = $this->gl_mode . "\x3B";
			}
			else {
				$con = "\x3B";
			}
			if (!$this->au) {
				$con = "\x21\xFE\x0\x00" . $con;
			}
			file_put_contents($file_dst, $gm . $this->gl_mod . $f_buf . $con);
			return 1;
		}
	}

	private function imageTransform($oi, $ni, $w, $h, $op) {
		if (file_exists($oi) && ($imageinfo = @getimagesize($oi))) {
			switch ($op) {
				case 'resize with background':
					if ($imageinfo[0] > $w || $imageinfo[1] > $h) {
						$nw = $w;
						$nh = round($nw / $imageinfo[0] * $imageinfo[1]);
						$x = 0;
						$y = ($h - $nh) / 2;
						if ($nh > $h) {
							$nh = $h;
							$nw = round($nh / $imageinfo[1] * $imageinfo[0]);
							$x = ($w - $nw) / 2;
							$y = 0;
						}
						$imagecreate = 'imagecreatefrom' . self::$exts[$imageinfo[2] - 1];
						$oi_descriptor = $imagecreate($oi);
						$ni_descriptor = imagecreatetruecolor($w, $h);
						if ($imageinfo[2] === 3) {
							$transparent = imagecolorallocatealpha($ni_descriptor, 0, 0, 0, 127);
							imagefill($ni_descriptor, 0, 0, $transparent);
							imagealphablending($ni_descriptor, FALSE);
							imagesavealpha($ni_descriptor, TRUE);
						}
						else {
							$color = imagecolorallocate($ni_descriptor, 255, 255, 255);
							imagefill($ni_descriptor, 0, 0, $color);
						}
						imagecopyresampled($ni_descriptor, $oi_descriptor, $x, $y, 0, 0, $nw, $nh, $imageinfo[0], $imageinfo[1]);
						$ni_save = 'image' . self::$exts[$imageinfo[2] - 1];
						return $ni_save($ni_descriptor, $ni) ? array($nw, $nh) : FALSE;
					}
					else {
						return copy($oi, $ni) ? array($imageinfo[0], $imageinfo[1]) : FALSE;
					}
					break;
	
				case 'resize proportional':
					if ($imageinfo[0] > $w || $imageinfo[1] > $h) {
						$nw = $w;
						$nh = round($nw / $imageinfo[0] * $imageinfo[1]);
						if ($nh > $h) {
							$nh = $h;
							$nw = round($nh / $imageinfo[1] * $imageinfo[0]);
						}
						$imagecreate = 'imagecreatefrom' . self::$exts[$imageinfo[2] - 1];
						$oi_descriptor = $imagecreate($oi);
						$ni_descriptor = imagecreatetruecolor($nw, $nh);
						imagealphablending($ni_descriptor, FALSE);
						imagesavealpha($ni_descriptor, TRUE);
						imagecopyresampled($ni_descriptor, $oi_descriptor, 0, 0, 0, 0, $nw, $nh, $imageinfo[0], $imageinfo[1]);
						$ni_save = 'image' . self::$exts[$imageinfo[2] - 1];
						return $ni_save($ni_descriptor, $ni) ? array($nw, $nh) : FALSE;
					}
					else {
						return copy($oi, $ni) ? array($imageinfo[0], $imageinfo[1]) : FALSE;
					}
					break;
	
				case 'crop':
					if ($imageinfo[0] > $w && $imageinfo[1] > $h) {
						$nw = $imageinfo[0];
						$nh = round($h / $w * $imageinfo[0]);
						$x = 0;
						$y = ($imageinfo[1] - $nh) / 2;
						if ($nh > $imageinfo[1]) {
							$nh = $imageinfo[1];
							$nw = round($w / $h * $imageinfo[1]);
							$x = ($imageinfo[0] - $nw) / 2;
							$y = 0;
						}
						$imagecreate = 'imagecreatefrom' . self::$exts[$imageinfo[2] - 1];
						$oi_descriptor = $imagecreate($oi);
						$ni_descriptor = imagecreatetruecolor($w, $h);
						imagealphablending($ni_descriptor, FALSE);
						imagesavealpha($ni_descriptor, TRUE);
						imagecopyresampled($ni_descriptor, $oi_descriptor, 0, 0, $x, $y, $w, $h, $nw, $nh);
						$ni_save = 'image' . self::$exts[$imageinfo[2] - 1];
						return $ni_save($ni_descriptor, $ni) ? array($w, $h) : FALSE;
					}
					else {
						return copy($oi, $ni) ? array($imageinfo[0], $imageinfo[1]) : FALSE;
					}
					break;
	
				case 'water mark':
					if ($watermark_info = @getimagesize($ni)) {
						$coords = array('x' => array('w', 0), 'y' => array('h', 1));
						foreach ($coords as $coord => $param) {
							if (is_numeric($$param[0])) {
								$$coord = $$param[0];
							}
							elseif (substr($$param[0], -1) == '%' && is_numeric($proc = substr($$param[0], 0, strlen($$param[0]) - 1))) {
								$$coord = round($imageinfo[$param[1]] / 100 * $proc);
							}
							elseif ($$param[0] == 'top') {
								$$coord = 0;
							}
							elseif ($$param[0] == 'center') {
								$$coord = round(($imageinfo[$param[1]] - $watermark_info[$param[1]]) / 2);
							}
							elseif ($$param[0] == 'bottom') {
								$$coord = $imageinfo[$param[1]] - $watermark_info[$param[1]];
							}
						}
						if (isset($x) && isset($y)) {
							$imagecreate_image = 'imagecreatefrom' . self::$exts[$imageinfo[2] - 1];
							$image_descriptor = $imagecreate_image($oi);
	
							$imagecreate_water_mark = 'imagecreatefrom' . self::$exts[$watermark_info[2] - 1];
							$water_mark_descriptor = $imagecreate_water_mark($ni);
	
							$canvas = imagecreatetruecolor($imageinfo[0], $imageinfo[1]);
							$color = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
							imagefill($canvas, 0, 0, $color);
							imagecolortransparent($canvas, $color);
							imagesavealpha($canvas, TRUE);
	
							imagecopyresampled($canvas, $image_descriptor, 0, 0, 0, 0, $imageinfo[0], $imageinfo[1], $imageinfo[0], $imageinfo[1]);
							imagecopyresampled($canvas, $water_mark_descriptor, $x, $y, 0, 0, $watermark_info[0], $watermark_info[1], $watermark_info[0], $watermark_info[1]);
	
							$image_save = 'image' . self::$exts[$imageinfo[2] - 1];
							return $image_save($canvas, $oi);
						}
						return FALSE;
					}
					break;
			}
		}
	}

	public static function addPreset($name, $actions) {
		self::$presets[$name] = $actions;
	}

	public static function saveUploadedImage($src) {
		if ($src && $imagesize = @getimagesize($src)) {
			$file = uniqid(); $ext = self::$exts[$imagesize[2] - 1];
			if (@move_uploaded_file($src, $_SERVER['DOCUMENT_ROOT'] . '/files/' . $file . '.' . $ext)) {
				return $file . '.' . $ext;
			}
		}
		return '';
	}

	public static function deleteImage($src) {
		if ($src) {
			if (file_exists($path = $_SERVER['DOCUMENT_ROOT'] . '/files/' . $src)) @unlink($path);
			foreach (self::$presets as $name => $values) {
				if (file_exists($path = $_SERVER['DOCUMENT_ROOT'] . '/files/' . $name . '/' . $src)) @unlink($path);
			}
		}
	}

	public static function getImage($image, $preset = 'full') {
		if ($image && $preset) {
			$path = $_SERVER['DOCUMENT_ROOT'] . '/files/' . $image;
			$preset_path = $_SERVER['DOCUMENT_ROOT'] . '/files/' . $preset . '/' . $image;
			if ($preset != 'full' && file_exists($preset_path) && @getimagesize($preset_path)) {
				return '/files/' . $preset . '/' . $image;
			}
			elseif (file_exists($path) && @getimagesize($path)) {
				if ($preset == 'full') return '/files/' . $image;
				elseif ($preset && array_key_exists($preset, self::$presets)) {
					if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/files/' . $preset)) @mkdir($_SERVER['DOCUMENT_ROOT'] . '/files/' . $preset);
					if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/files/' . $preset)) {
						if (@copy($path, $preset_path)) {
							foreach (self::$presets[$preset] as $action) {
								$new_image = new self($preset_path, 0);
								if ($preset == 'water mark') {
									if (isset($action[3])) $new_image->resize($action[3], $action[0], $action[1], $action[2]);
								}
								else {
									$new_image->resize($preset_path, $action[0], $action[1], $action[2]);
								}
							}
							return '/files/' . $preset . '/' . $image;
						}
					}
				}
			}
		}
		return '';
	}
}

class FRM {

  public $pos_x, $pos_y, $width_f, $height_f, $tr_frm = 0, $lc_mod, $gr_mod, $off_xy, $head, $lc_palet, $image;

	public function __construct($lc_mod, $lc_palet, $image, $head, $pzs_xy, $gr_mod) {
		$this->lc_mod = $lc_mod;
		$this->lc_palet = $lc_palet;
		$this->image = $image;
		$this->head = $head;
		$this->pos_x = $pzs_xy[0];
		$this->pos_y = $pzs_xy[1];
		$this->width_f = $pzs_xy[2];
		$this->height_f = $pzs_xy[3];
		$this->gr_mod = $gr_mod;
		$this->tr_frm = ord($gr_mod[3]) & 1 ? 1 : 0;
	}

}

?>