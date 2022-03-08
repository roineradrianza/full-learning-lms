<?php 
/*
*	@var method
* @var query
*/
if (empty($method)) die(403);
require_once("models/Lessons.php");
require_once("models/LessonViews.php");
require_once("models/StudentCourses.php");
require_once("models/Questions.php");
require_once("models/QuestionAttemptAnswers.php");
require_once("models/QuestionAttempts.php");

$lesson = New Lesson;
$lesson_view = New LessonViews;
$student_course = New StudentCourse;
$question = New Question;
$question_attempt_answer = New QuestionAttemptAnswer;
$question_attempt = New QuestionAttempt;
$helper = New Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : $query;


switch ($method) {
	
	case 'get':
		if (empty($query)) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		$course_id = clean_string($query);
		$lesson_quizzes = $lesson->get_quizzes($course_id);
		$data_vars = [
			'quizzes' => $lesson_quizzes,
			'students_quizzes' => $student_course->get_all_students_quizzes($course_id)
		];
		echo json_encode($data_vars);
		break;

}