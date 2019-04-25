<?php

class Specialties {

	public function get() {
		$specialties = array();
		$result = DB::connect()->query("SELECT * FROM specialties");
		while ($res = $result->fetch_assoc()) {
			$specialties[$res['id']] = $res['name'];
		}
		return $specialties;
	}

}

?>