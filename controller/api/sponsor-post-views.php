<?php
/*
*	@var method
* @var query
*/
if (empty($method)) die(403);
require_once("models/SponsorPostViews.php");

$helper = New Helper;
$sponsor_post_view = New SponsorPostViews;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : $query;

switch ($method) {

	case 'get-by-courses':
		$query = empty($query) ? 0 : $query;
		$results = $sponsor_post_view->get_by_course($query);
		echo json_encode($results);
		break;

	case 'create':
		if (empty($data)) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
    $data['ip'] = $_SERVER['REMOTE_ADDR'];
    $geoipdata = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=". $data['ip']));
    $data['country'] = $geoipdata->geoplugin_countryName;
		$result = $sponsor_post_view->create($data);
		if (!$result) $helper->response_message('Error', 'No se pudo registrar la vista correctamente', 'error');
		$helper->response_message('Éxito', 'Se registró la vista correctamente');
		break;

	case 'delete':
		$result = $media->delete(intval($data['user_id']));
		if (!$result) $helper->response_message('Error', 'No se pudo eliminar la vista correctamente', 'error');
		$helper->response_message('Éxito', 'Se eliminó la vista correctamente');
		break;

}
