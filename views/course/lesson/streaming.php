<v-row class="px-6 pb-16 d-flex align-center" style="min-height: 83vh">
    <?php echo new Template('course/parts/course_approved', $data['course']) ?>
    <?php echo new Template('course/parts/lesson_streaming_content', $data) ?>
    <?php echo new Template('course/parts/footer', [ 'course' => $data['course'], 'curriculum' => $data['curriculum']]) ?>
</v-row>