    
    <v-row>

      <v-col cols="12" md="12">
        <label class="body-1 font-weight-thin pl-1">Descripción</label>
        <vue-editor id="lesson_editor" class="mt-3 fl-text-input" v-model="lessons.item.meta.description" placeholder="Descripción del curso" />
      </v-col>

     <?php echo new Template('course/edit/parts/resources') ?>
     <?php echo new Template('components/alert') ?>

    </v-row>
    