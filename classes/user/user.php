<?php
	class User {
		public $id;

		public function __construct($id) {
			global $database;
			$this->id = $id;

			$stmt = $database->prepare("SELECT * FROM `users` WHERE `id` = ?");
			$stmt->bind_param('s', $this->id);
			$stmt->execute();

			$parameters = array();
			$meta = $stmt->result_metadata();
			while($field = $meta->fetch_field()) {
				$parameters[] = &$row[$field->name]; 
			}

			call_user_func_array(array($stmt, 'bind_result'), $parameters);

			while($stmt->fetch()) {
				foreach($row as $key => $val) {
					$this->{$key} = $val;
				}
			}

			$stmt->close();
		}

		public static function logged_in_redirect() {
			if(self::logged_in()) {
				$_SESSION['error'][] = "You can't access this page at the moment !";
				redirect();
			}
		}

		public static function logged_in() { 
			if(isset($_COOKIE['email']) && isset($_COOKIE['password']) && User::login($_COOKIE['email'], $_COOKIE['password']) !== false && $_COOKIE['id'] == User::login($_COOKIE['email'], $_COOKIE['password'])) {
				return true;
			} elseif(isset($_SESSION['id'])) {
				return true;
			} else return false;
		}


		public static function login($email, $password) {
			global $database;

			$stmt = $database->prepare("SELECT `id` FROM `users` WHERE `email` = ? AND `password` = ?");
			$stmt->bind_param('ss', $email, $password);
			$stmt->execute();
			$stmt->bind_result($result);
			$stmt->fetch();
			$stmt->close();
			return (!is_null($result)) ? $result : false;
		}

		public static function logout() {
			session_destroy();
			redirect('login');
		}


		public static function x_exists($x, $x_value, $from = 'users') {
			global $database;
			$stmt = $database->prepare("SELECT `{$x}` FROM `{$from}` WHERE `{$x}` = ?");
			$stmt->bind_param('s', $x_value);
			$stmt->execute();
			$stmt->bind_result($result);
			$stmt->fetch();
			$stmt->close();
			if(!is_null($result)) return true;
			else return false;
		}

		public static function encrypt_password($email, $password) {
			//using $email as salt
			$email = hash('sha512', $email);
			$hash	  = hash('sha512', $password . $email);
			
			//iterating the hash
			for($i = 1;$i <= 1000;$i++) {
				$hash = hash('sha512', $hash);
			}		
			return $hash;
		}


		public static function check_permission($level = 1) {
			global $account_user_id;

			if(!self::logged_in()) {
				$_SESSION['error'][] = "You can't access this page at the moment !";

				if(isset($_SERVER['HTTP_REFERER'])) Header('Location: ' . $_SERVER['HTTP_REFERER']); else redirect();
				die();
			}
		}

		public static function is_valid_password($password) {
		    return preg_match_all('$S*(?=S{8,})(?=S*[a-z])(?=S*[A-Z])(?=S*[d])(?=S*[W])S*$', $password) ? true : false;
		}
		
		
	}
?>
