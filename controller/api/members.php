<?php 
/*
*	@var method
* @var query
*/
if (empty($method)) die(403);
require_once("models/Members.php");
require_once("models/MembersMeta.php");

use Aws\S3\S3Client;

$member = New Members();
$user_meta = New MembersMeta();
$helper = New Helper();

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : $query;

switch ($method) {
	case 'get':
		if (strlen($query) > 40) {
			$query = $helper->decrypt($query);
		}
		$query = intval($query);
		$results = $member->get($query);
		$members = [];
		if ($results > 0) {
			foreach ($results as $member) {
				$result['user_id'] = $member['user_id'];
				$result['username'] = $member['username'];
				$result['avatar'] = $member['avatar'];
				$result['first_name'] = $member['first_name'];
				$result['last_name'] = $member['last_name'];
				$result['user_type'] = $member['user_type'];
				$result['email'] = $member['email'];
				$result['birthdate'] = $member['birthdate'];
				$result['gender'] = $member['gender'];

				$meta = $user_meta->get($result['user_id']);
				$result['meta'] = [];
				foreach ($meta as $i => $e) {
					$result['meta'][$e['meta_name']] = $e['meta_val'];
				}
				$members[] = $result;
			}
		}
		echo json_encode($members);
		break;

	case 'get-by-members':
		$results = $member->get_by_members();
		$members = [];
		if ($results > 0) {
			foreach ($results as $member) {
				$result['user_id'] = $member['user_id'];
				$result['username'] = $member['username'];
				$result['avatar'] = $member['avatar'];
				$result['first_name'] = $member['first_name'];
				$result['last_name'] = $member['last_name'];
				$result['user_type'] = $member['user_type'];
				$result['email'] = $member['email'];
				$result['birthdate'] = $member['birthdate'];
				$result['gender'] = $member['gender'];

				$meta = $user_meta->get($result['user_id']);
				$result['meta'] = [];
				foreach ($meta as $i => $e) {
					$result['meta'][$e['meta_name']] = $e['meta_val'];
				}
				$members[] = $result;
			}
		}
		echo json_encode($members);
		break;

	case 'search-user':
		$results = $member->search_user(clean_string($query));
		echo json_encode($results);
		break;

	case 'create':
		if (!isset($_SESSION['user_type']) && $_SESSION['user_type'] != 'administrador') {
			die(403);
		}
		if (empty($data)) $helper->response_message('Advertencia', 'Ninguna informaci??n fue recibida', 'warning');
		$columns = ['username', 'first_name', 'last_name', 'email', 'gender', 'birthdate', 'user_type', 'password'];
		$result = $member->create(sanitize($data), $columns);
		if (!$result) $helper->response_message('Error', 'No se pudo registrar el miembro correctamente', 'error');
		if (isset($data['meta']) && !empty($data['meta'])) {
			foreach ($data['meta'] as $meta_key => $meta_value) {
				$meta = ['meta_name' => $meta_key, 'meta_val' => $meta_value, 'user_id' => $result]; 
				$user_meta->create($meta);
			}
		}
		$helper->response_message('??xito', 'Se registr?? el miembro correctamente', data: ['user_id' => $result]);
		break;

	case 'register':
		if (empty($data)) $helper->response_message('Advertencia', 'Ninguna informaci??n fue recibida', 'warning');
		$columns = ['username', 'first_name', 'last_name', 'email', 'gender', 'birthdate', 'user_type', 'password'];
		$data['user_type'] = 'miembro';
		if ($member->check_exist_credential($data['username'])) {
			$helper->response_message('Error', 'Ya el nombre de usuario se encuentra registrado, utilice otro nombre de usuario', 'error');
		}
		else if ($member->check_exist_credential($data['email'])) {
			$helper->response_message('Error', 'El correo electr??nico ya se encuentra registrado, revise en su correo electr??nico si sus credenciales fueron enviadas con anterioridad.', 'error');
		}
		$result = $member->create(sanitize($data), $columns);
		if (!$result) $helper->response_message('Error', 'No se pudo registrar completar el registro', 'error');
		if (isset($data['meta']) && !empty($data['meta'])) {
			foreach ($data['meta'] as $meta_key => $meta_value) {
				$meta = ['meta_name' => $meta_key, 'meta_val' => $meta_value, 'user_id' => $result]; 
				$user_meta->create($meta);
			}
		}
		if (isset($data['register_to_course'])) {
			require_once("models/StudentCourses.php");
			$student_course = new StudentCourse;
			$enroll_data = ['course_id' => $data['register_to_course']['course_id'], 'user_id' => $result, 'user_rol' => $data['register_to_course']['user_rol']]; 
			$student_course->create($enroll_data);
		}
		$_SESSION = $data;
		$_SESSION['user_id'] = $result;
		$cookie_email = $helper->encrypt($_SESSION['email']);
		$cookie_password = md5($data['password']);
		setcookie( 'u' , "$cookie_email", time()+60*60*24*365, '/');
		setcookie( 'p' , "$cookie_password", time()+60*60*24*365, '/');
		$helper->response_message('??xito', 'Te haz registrado correctamente, espera unos momentos para continuar');
		break;	

	case 'update':
		if (empty($data)) $helper->response_message('Advertencia', 'Ninguna informaci??n fue recibida', 'warning');
		if (strlen($data['user_id']) > 40) {
			$data['user_id'] = Helper::decrypt($data['user_id']);
		}
		$id = intval($data['user_id']);
		$result = $member->edit($id,sanitize($data));
		if (!$result) $helper->response_message('Error', 'No se pudo editar el miembro correctamente', 'error');
		if (isset($data['meta']) && !empty($data['meta'])) {
			foreach ($data['meta'] as $meta_key => $meta_value) {
				$meta = ['meta_name' => $meta_key, 'meta_val' => $meta_value];
				$user_meta->edit($id, $meta);
			}
		}
		$helper->response_message('??xito', 'Se edit?? el miembro correctamente');
		break;	
	case 'sign-in':
		if (empty($data)) $helper->response_message('Advertencia', 'Ninguna informaci??n fue recibida', 'warning');
		$result = null;
		if (isset($data['gid']) && !empty($data['gid'])) {
			$existsGid = $member->check_google_id($data['gid'], $data['email']);
			if (empty($existsGid)) {
				$credentials = [
					'google_id' => clean_string($data['gid']),
					'avatar' => clean_string($data['avatar']),
					'first_name' => clean_string($data['first_name']),
					'last_name' => clean_string($data['last_name']),
					'email' => clean_string($data['email']),
					'gender' => clean_string($data['gender']),
					'user_type' => 'miembro',
					'password' => $helper->rand_string()
				];
				$columns = ['google_id', 'avatar', 'first_name', 'last_name', 'email', 'gender', 'user_type', 'password'];
				$result = $member->create_with_google($credentials, $columns);
				if (!$result) $helper->response_message('Error', 'No se logr?? procesar el registro correctamente, intente de nuevo', 'error');
				if (isset($data['meta']) && !empty($data['meta'])) {
					foreach ($data['meta'] as $meta_key => $meta_value) {
						$meta = ['meta_name' => $meta_key, 'meta_val' => $meta_value, 'user_id' => $result]; 
						$user_meta->create($meta);
					}
				}
				$result = json_encode($member->get($result));
				$result = json_decode($result);
				$result = $result[0];
				if (isset($data['register_to_course'])) {
					require_once("models/StudentCourses.php");
					$student_course = new StudentCourse;
					$enroll_data = ['course_id' => $data['register_to_course']['course_id'], 'user_id' => $result->user_id, 'user_rol' => $data['register_to_course']['user_rol']]; 
					$student_course->create($enroll_data);
				}
			}
			else{
				$result = $existsGid;
			}
		}
		else{
			$email = clean_string($data['email']);
			$password = clean_string($data['password']);
			$result = $member->check_user($email, $password);
		}
		if (!empty($result)) {
			//We declare the session variables
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
			foreach ($user_meta->get($result->user_id) as $meta) {
				$_SESSION['meta'][$meta['meta_name']] = $meta['meta_val'];
			}
			$_SESSION['redirect_url'] = $result->user_type == 'administrador' ? SITE_URL.'/admin/' : SITE_URL.'/profile/';
			$cookie_email = $helper->encrypt($_SESSION['email']);
			$cookie_password = $result->password;
			setcookie( 'u' , "$cookie_email", time()+60*60*24*365, '/');
			setcookie( 'p' , "$cookie_password", time()+60*60*24*365, '/');
			$_COOKIE['u'] = $cookie_email;
			$_COOKIE['p'] = $cookie_password;
			$helper->response_message('??xito', 'Has iniciado sesi??n exitosamente, espera un momento', 'success', $_SESSION['redirect_url']);	
		}
		else{
			$helper->response_message('Error', 'Credenciales incorrectas, por favor, intente de nuevo', 'error');	
		}
		break;	

	case 'delete':
		$result = $member->delete(intval($data['user_id']));
		if (!$result) $helper->response_message('Error', 'No se pudo eliminar el miembro correctamente', 'error');
		$helper->response_message('??xito', 'Se elimin?? el miembro correctamente');
		break;
		
	case 'update-profile':
		if (empty($data)) $helper->response_message('Advertencia', 'Ninguna informaci??n fue recibida', 'warning');
		$id = $_SESSION['user_id'];
		$data['username'] = isset($data['username']) ? $data['username'] : $_SESSION['username'];
		$result = $member->edit_profile($id,sanitize($data));
		if (!$result) $helper->response_message('Error', 'No se pudo editar tu informaci??n correctamente', 'error');
		if (isset($data['meta']) && !empty($data['meta'])) {
			foreach ($data['meta'] as $meta_key => $meta_value) {
				$meta = ['meta_name' => $meta_key, 'meta_val' => $meta_value];
				$user_meta->edit($id, $meta);
			}
		}
		$_SESSION['first_name'] = $data['first_name'];
		$_SESSION['last_name'] = $data['last_name'];
		$_SESSION['email'] = $data['email'];
		$_SESSION['gender'] = $data['gender'];
		$_SESSION['birthdate'] = $data['birthdate'];
		$_SESSION['meta'] = $data['meta'];
		$helper->response_message('??xito', 'Tu informaci??n ha sido actualizada correctamente', 'success');
		break;	
	
	case 'complete-register':
		if (empty($data)) $helper->response_message('Advertencia', 'Ninguna informaci??n fue recibida', 'warning');
		$id = $_SESSION['user_id'];
		$data['username'] = isset($data['username']) ? $data['username'] : $_SESSION['username'];
		$result = $member->edit_profile($id,sanitize($data));
		if (!$result) $helper->response_message('Error', 'No se pudo editar tu informaci??n correctamente', 'error');
		if (isset($data['meta']) && !empty($data['meta'])) {
			foreach ($data['meta'] as $meta_key => $meta_value) {
				$meta = ['meta_name' => $meta_key, 'meta_val' => $meta_value, 'user_id' => $id];
				$check_meta = $user_meta->get_meta($id, $meta_key);
					if (empty($check_meta)) {
						$user_meta->create($meta);
						continue;
				}
				$user_meta->edit($id, $meta);
			}
		}
		$_SESSION['username'] = $data['username'];
		$_SESSION['first_name'] = $data['first_name'];
		$_SESSION['last_name'] = $data['last_name'];
		$_SESSION['email'] = $data['email'];
		$_SESSION['gender'] = $data['gender'];
		$_SESSION['birthdate'] = $data['birthdate'];
		$_SESSION['meta'] = $data['meta'];
		$helper->response_message('??xito', 'Tu informaci??n ha sido actualizada correctamente', 'success');
		break;	

	case 'update-member-avatar':
 		$id = intval($_POST['user_id']);
		if (empty($id)) die(403);
		$avatar_file = $_FILES['avatar'];
		$ext = explode(".", $_FILES['avatar']['name']);
		$file_name = 'siac_avatar_' .time() .'.' . end($ext);
		if(!move_uploaded_file($_FILES["avatar"]["tmp_name"], DIRECTORY . "/public/img/avatars/" . $file_name)) $helper->response_message('Error', 'No se pudo guardar correctamente la im??gen de perfil del miembro', 'error');
		$result = $member->update_avatar($id, $file_name);
		$helper->response_message('??xito', 'Tu im??gen de perfil ha sido actualizada correctamente', 'success');
		break;

	case 'update-avatar':
		if (empty($_POST) || empty($_SESSION['user_id'])) $helper->response_message('Advertencia', 'Ninguna informaci??n fue recibida', 'warning');
		$data = $_POST;
		$credentials = new Aws\Credentials\Credentials(AWS_S3_KEY, AWS_S3_SECRET);
		$s3 = new S3Client([
	    'version' => 'latest',
	    'region'  => 'us-east-2',
	    'credentials' => $credentials
		]);
		$id = $_SESSION['user_id'];
		$ext = explode(".", $_FILES['avatar']['name']);
		$tmp_file = $_FILES['avatar']['tmp_name'];
		$file_name = "avatar-$id-" .time() .'.' . end($ext);
		$path = DIRECTORY . "/public/img/avatar/$file_name";
		if (move_uploaded_file($tmp_file, $path)) {
			$source = @fopen($path, 'r');
			$keyname = AWS_A_FOLDER . $file_name;
			try {
			    $result = $s3->putObject([
		        'Bucket' => AWS_S3_BUCKET,
		        'Key'    => AWS_A_FOLDER . $file_name,
		        'Body'   => $source,
		        'ACL'    => 'public-read',
			    ]);
			    unlink($path);
					$data['avatar'] = $result['ObjectURL'];
			} catch (Aws\S3\Exception\S3Exception $e) {
					unlink($path);
					$helper->response_message('Error', 'No se pudo subir la im??gen de perfil a S3, intente nuevamente', 'error', ['err' => 'Hubo un error al intentar subir el archivo a Amazon S3.\n']);
			}
		}
		else{
			if (!$result) $helper->response_message('Error', 'No se pudo subir la im??gen de perfil, intente nuevamente', 'error');
		}
		if (!empty($data['old_avatar'])) {
			$old_avatar_url = explode('/', $data['old_avatar']);
			try {
		    $result = $s3->deleteObject([
	        'Bucket' => AWS_S3_BUCKET,
	        'Key'    => AWS_A_FOLDER . end($old_avatar_url)
		    ]);
			}
			catch (S3Exception $e) {
			    
			}
		}
		$result = $member->update_avatar($id, $data['avatar']);
		$_SESSION['avatar'] = $data['avatar'];
		$helper->response_message('??xito', 'Tu im??gen de perfil ha sido actualizada correctamente', data: ['avatar' => $data['avatar']]);
		break;

	case 'logout':
		//We clean the session variables
		session_unset();
	  //Destroy the session
	  session_destroy();
	  //We redirect the user to the login page
	  setcookie( 'u' , "", time() - 1, '/');
		setcookie( 'p' , "", time() - 1, '/');
	  header("Location: ".SITE_URL."/login");
	break;

}