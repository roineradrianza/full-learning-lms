<?php 

class KeepSession  
{
	function __construct() {
		$isLoggedIn = false;
		if (!empty($_SESSION["user_id"])) {
		  $isLoggedIn = true;
		}
		else if (! empty($_COOKIE["u"]) && ! empty($_COOKIE["p"]) && !$isLoggedIn){
			if (!empty($_COOKIE["u"]) && !empty($_COOKIE["p"])) {
				require_once('models/Members.php');
				$member = new Members;
				$helper = new Helper;
				$result = $member->check_user($helper->decrypt($_COOKIE["u"]), $_COOKIE["p"], false);
				if (!empty($result)) {
					$_SESSION['user_id'] = $result->user_id;
					$_SESSION['username'] = $result->username;
					$_SESSION['avatar'] = $result->avatar;
					$_SESSION['first_name'] = $result->first_name;
					$_SESSION['last_name'] = $result->last_name;
					$_SESSION['email'] = $result->email;
					$_SESSION['gender'] = $result->gender;
					$_SESSION['birthdate'] = $result->birthdate;
					$_SESSION['user_type'] = $result->user_type;
					$_SESSION['meta'] = [];
					require_once('models/MembersMeta.php');
					$user_meta = new MembersMeta();
					foreach ($user_meta->get($result->user_id) as $meta) {
						$_SESSION['meta'][$meta['meta_name']] = $meta['meta_val'];
					}
					$_SESSION['redirect_url'] = $result->user_type == 'administrador' ? SITE_URL.'/admin/' : SITE_URL.'/profile/';
				}
				else {
				  setcookie( 'u' , "", time() - 1, '/');
					setcookie( 'p' , "", time() - 1, '/');
				}
			}
		}
	}
}