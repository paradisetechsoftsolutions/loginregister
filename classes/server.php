<?php

	function display_notifications() {
		global $language;

		$types = array("error", "success", "info");
		foreach($types as $type) {
			if(isset($_SESSION[$type]) && !empty($_SESSION[$type])) {
				if(!is_array($_SESSION[$type])) $_SESSION[$type] = array($_SESSION[$type]);

				foreach($_SESSION[$type] as $message) {
					echo '
					<div class="container">	
						<div class="row">
							<div class="alert alert-' . $type . '">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<strong>' . $language['alerts'][$type] . '</strong> ' . $message . '
							</div>
						</div>
					</div>
					';
				}
				unset($_SESSION[$type]);
			}
		}

	}




?>