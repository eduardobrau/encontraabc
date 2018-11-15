<?php

namespace core;

class View {

	public function load($file, $data = null) {

		$file = strtolower($file);
		
		include("../app/views/header.tpl.php");
		include("../app/views/$file.tpl.php");
		include("../app/templates/modal-confirm.tpl.php");
		include("../app/views/footer.tpl.php");

  }
  

}