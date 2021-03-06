<?php
/*
 *    @var method
 * @var query
 */
if (empty($method)) {
    die(403);
}

require_once "models/Courses.php";
require_once "models/StudentCourses.php";
require_once "models/Members.php";
require_once "models/MembersMeta.php";
require_once "models/QuestionAttempts.php";

use Aws\S3\S3Client;

$course = new Course;
$helper = new Helper;
$student_course = new StudentCourse;
$question_attempt = new QuestionAttempt;
$user_meta = new MembersMeta;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : $query;

switch ($method) {
    case 'get':
        $results = $course->get($query);
        echo json_encode($results);
        break;

    case 'get-students':
        if (empty($query)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $results = $student_course->get_students(clean_string($query));
        $students = [];
        foreach ($results as $student) {
            $student['full_name'] = $student['first_name'] . ' ' . $student['last_name'];
            $meta = $user_meta->get($student['user_id']);
            $student['meta'] = [];
            foreach ($meta as $meta_data) {
                $student['meta'][$meta_data['meta_name']] = $meta_data['meta_val'];
            }
            $students[] = $student;
        }
        echo json_encode($students);
        break;

    case 'get-students-approved':
        if (empty($query)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }
        $results = $student_course->get_users_approved(clean_string($query));
        echo json_encode($results);
        break;
    
    case 'get-users':
        if (empty($query)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $results = $student_course->get_by_rol(clean_string($query), clean_string($data['rol']));
        $users = [];
        foreach ($results as $user) {
            $user['full_name'] = $user['first_name'] . ' ' . $user['last_name'];
            $meta = $user_meta->get($user['user_id']);
            $user['meta'] = [];
            foreach ($meta as $meta_data) {
                $user['meta'][$meta_data['meta_name']] = $meta_data['meta_val'];
            }
            $users[] = $user;
        }
        echo json_encode($users);
        break;

    case 'get-pending-students':
        if (empty($query)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $results = $student_course->get_pendings_students(clean_string($query));
        $students = [];
        foreach ($results as $student) {
            $student['full_name'] = $student['first_name'] . ' ' . $student['last_name'];
            $meta = $user_meta->get($student['user_id']);
            $student['meta'] = [];
            foreach ($meta as $i => $e) {
                $student['meta'][$e['meta_name']] = $e['meta_val'];
            }
            $students[] = $student;
        }
        echo json_encode($students);
        break;

    case 'get-pending-instructors':
        if (empty($query)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $results = $student_course->get_pendings_instructors(clean_string($query));
        $students = [];
        foreach ($results as $student) {
            $student['full_name'] = $student['first_name'] . ' ' . $student['last_name'];
            $meta = $user_meta->get($student['user_id']);
            $student['meta'] = [];
            foreach ($meta as $i => $e) {
                $student['meta'][$e['meta_name']] = $e['meta_val'];
            }
            $students[] = $student;
        }
        echo json_encode($students);
        break;

    case 'get-courses':
        $columns = ['course_id, title'];
        $query = empty($query) ? 0 : $query;
        $results = $course->get_courses($query, $columns);
        echo json_encode($results);
        break;

    case 'get-student-progress-total':
        require_once "models/CourseCertifieds.php";
        $course_certified = new CourseCertified;
        $data = sanitize($data);
        $data['user_id'] = empty($data['user_id']) ? $_SESSION['user_id'] : $data['user_id'];
        $course_percent = $student_course->get_user_progress($data['course_id'], $data['user_id']);
        $quizzes = $question_attempt->get_my_grades($data['course_id'], $data['user_id']);
        $certified = $course_certified->get_by_course($data['course_id'], $data['user_id']);
        $quizzes_approved = 0;
        $total_quizzes = count($quizzes);
        foreach ($quizzes as $quiz) {
            if (!empty($quiz['approved'])) {
                $quizzes_approved++;
            }
        }
        $results = [
            'progress' => count($course_percent) > 0 ? $course_percent[0]['progress'] : 'N/A',
            'quizzes_approved' => $quizzes_approved,
            'total_quizzes' => $total_quizzes,
            'quizzes' => $quizzes,
            'certified' => count($certified) > 0 ? $certified[0]['certified_url'] : '',
        ];
        if (empty($results['certified'])) {
            $course_result = $course->get($data['course_id']);
            if (!empty($course_result)) {
                $course_selected = $course_result[0];
                $isCertifiedPaid = !empty($course_selected['paid_certified']) ? true : false;
                $canGetCertified = $isCertifiedPaid ? false : true;
                if ($isCertifiedPaid) {
                    require_once "models/Orders.php";
                    $order = new Orders;
                    $canGetCertified = !empty($order->get_course_orders($_SESSION['user_id'], $course_selected['course_id'], status:1)) ? true : false;
                    require_once "models/QuestionAttempts.php";

                    $question_attempt = new QuestionAttempt;
                    $course_percent = $student_course->get_user_progress($course_selected['course_id'], $_SESSION['user_id']);
                    $quizzes = $question_attempt->get_my_grades($course_selected['course_id'], $_SESSION['user_id']);
                    $quizzes_approved = 0;
                    $total_quizzes = count($quizzes);
                    foreach ($quizzes as $quiz) {
                        if (!empty($quiz['approved'])) {
                            $quizzes_approved++;
                        }
                    }
                    $progress_data = [
                        'progress' => count($course_percent) > 0 ? $course_percent[0]['progress'] : 'N/A',
                        'quizzes_approved' => $quizzes_approved,
                        'total_quizzes' => $total_quizzes,
                        'quizzes' => $quizzes,
                    ];
                    if ($progress_data['progress'] == 100 && $progress_data['total_quizzes'] == $progress_data['quizzes_approved']) {
                        $data['requireCertifiedPaid'] = 1;
                    }
                }
                if ($canGetCertified) {
                    require_once "models/QuestionAttempts.php";

                    $question_attempt = new QuestionAttempt;
                    $course_percent = $student_course->get_user_progress($course_selected['course_id'], $_SESSION['user_id']);
                    $quizzes = $question_attempt->get_my_grades($course_selected['course_id'], $_SESSION['user_id']);
                    $quizzes_approved = 0;
                    $total_quizzes = count($quizzes);
                    foreach ($quizzes as $quiz) {
                        if (!empty($quiz['approved'])) {
                            $quizzes_approved++;
                        }
                    }
                    $progress_data = [
                        'progress' => count($course_percent) > 0 ? $course_percent[0]['progress'] : 'N/A',
                        'quizzes_approved' => $quizzes_approved,
                        'total_quizzes' => $total_quizzes,
                        'quizzes' => $quizzes,
                    ];
                    $isApprovedByQuizzes = round(($progress_data['quizzes_approved'] / $progress_data['total_quizzes']) * 100) >= 60 ? true : false;

                    if ($isApprovedByQuizzes) {
                        require_once "models/CourseCertifieds.php";

                        $course_certified = new CourseCertified;
                        $certified = $course_certified->get_by_course($course_selected['course_id'], $_SESSION['user_id']);
                        if (empty($certified) && !empty($course_selected['certified_template'])) {

                            $student = $_SESSION;
                            $file_name = $helper->convert_slug($student['first_name'] . ' ' . $student['last_name']) . '-' . $course_selected['course_id'] . '-' . time();
                            $tmp_dir = DIRECTORY . "/public/course-certifieds/";
                            $helper->generate_pdf(
                                new Template(
                                    "document_templates/certified_templates/{$course_selected['certified_template']}",
                                    ['first_name' => $student['first_name'], 'last_name' => $student['last_name']]
                                ), $file_name, $tmp_dir
                            );
                            $file_name .= '.pdf';
                            $path = $tmp_dir . $file_name;
                            $source = @fopen($path, 'r');
                            if (!empty($source)) {

                                $credentials = new Aws\Credentials\Credentials(AWS_S3_KEY, AWS_S3_SECRET);
                                $s3 = new S3Client([
                                    'version' => 'latest',
                                    'region' => 'us-east-2',
                                    'credentials' => $credentials,
                                ]);

                                try {
                                    $result = $s3->putObject([
                                        'Bucket' => AWS_S3_BUCKET,
                                        'Key' => AWS_CC_FOLDER . $file_name,
                                        'Body' => $source,
                                        'ACL' => 'public-read',
                                    ]);
                                    unlink($path);
                                    $results['certified'] = $result['ObjectURL'];
                                    $student_data = [
                                        'user_id' => $student['user_id'],
                                        'certified_url' => $results['certified'],
                                        'course_id' => $course_selected['course_id'],
                                    ];
                                    $course_certified->create($student_data);
                                } catch (Aws\S3\Exception\S3Exception$e) {
                                    unlink($path);
                                }
                            }
                        }
                    }
                }
            }
        }
        echo json_encode($results);
        break;

    case 'create':
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $result = $course->create($data, $columns);
        if (!$result) {
            $helper->response_message('Error', 'No se pudo crear el curso correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se creó el curso correctamente', 'success');
        break;

    case 'enroll-free-course':
        if (empty($data['course_id'])) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $results = $course->get($data['course_id']);
        if (empty($results[0]) || $results[0]['price'] > 1) {
            $helper->response_message('Error', 'No se pudo realizar la inscripción, el curso seleccionado no existe o no está gratis', 'error');
        }

        $data['user_id'] = $_SESSION['user_id'];
        $data['user_rol'] = 'estudiante';
        $data['course_id'] = clean_string($data['course_id']);
        $result = $student_course->create($data);
        if (!$result) {
            $helper->response_message('Error', 'No se pudo procesar la inscripción', 'error');
        }

        $helper->response_message('Éxito', 'Te has inscrito al curso, espera un momento...', 'success');
        break;

    case 'add-user':
        if (empty($data) || empty($data['user_id']) || empty($data['course_id'])) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $data['user_rol'] = 'profesor';
        $result = $student_course->create($data);
        if (!$result) {
            $helper->response_message('Error', 'No se pudo añadir el profesor al curso', 'error');
        }

        $helper->response_message('Éxito', 'Se añadió el profesor correctamente');
        break;

    case 'update':
        if (empty($_POST)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $data = $_POST;
        $id = intval($data['course_id']);
        $result = $course->edit($id, $data);
        if (!$result) {
            $helper->response_message('Error', 'No se pudo editar el curso correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se editó el curso correctamente', data:['featured_image' => $data['featured_image'], 'slug' => $data['slug']]);
        break;

    case 'remove-user':
        $result = $student_course->delete(clean_string($data['user_id']), clean_string($data['course_id']));
        if (!$result) {
            $helper->response_message('Error', 'No se pudo remover el estudiante del curso correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se removió el estudiante del curso correctamente');
        break;

}
