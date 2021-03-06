<?php echo new Template('course/parts/lesson_menu', [
'course_slug' => $course['slug'], 
'sections' => $course['sections']
]) 
?>
<v-row class="px-md-6 pb-16">
    <?php echo new Template('course/parts/course_approved', $data['course']) ?>
    <?php echo new Template('course/parts/lesson_video_content', $data) ?>
    <?php echo new Template('course/parts/lesson_sidebar', $data) ?>
    <?php echo new Template('course/parts/footer', [ 'course' => $data['course'], 'curriculum' => $data['curriculum']]) ?>
</v-row>