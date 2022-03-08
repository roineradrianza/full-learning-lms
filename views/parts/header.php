  <v-col cols="12" class="menu-color mb-md-0 mb-8 py-0" style="max-height:150px !important;">
    <v-row class="px-md-4 px-0">
      <v-col class="mb-n4 mb-md-0" cols="12" md="6">
        <v-tabs class="menu-items d-flex d-md-inline justify-center" background-color="transparent" dark>
          <v-tab class="subtitle-2"><span>Ing </span> - <span> Esp</span></v-tab>
        </v-tabs>
      </v-col>
      <v-col class="d-none d-md-inline" cols="12" md="6">
        <v-tabs v-model="tab" class="menu-items" background-color="transparent" dark right>
          <v-tab key="courses_tab" href="<?php echo SITE_URL ?>/courses">Cursos</v-tab>
          <v-tab key="plan_tab" v-if="1 == 2">Planes</v-tab>
          <v-tab key="about_us_tab" v-if="1 == 2">Nosotros</v-tab>
          <v-tab href="<?php echo SITE_URL ?>/contact" key="contact_tab">Contáctanos</v-tab>
          <v-tab class="pr-6 d-flex justify-center" href="https://www.instagram.com/full_learning_/" target="_blank"><v-icon>mdi-instagram</v-icon></v-tab>
        </v-tabs>
      </v-col>
      <v-col class="d-inline d-md-none" cols="12" md="6" center>
        <v-tabs v-model="tab" class="menu-items d-flex justify-center" background-color="transparent" dark center>
          <v-tab key="courses_tab" href="<?php echo SITE_URL ?>/courses">Cursos</v-tab>
          <v-tab key="plan_tab" v-if="1 == 2">Planes</v-tab>
          <v-tab key="about_us_tab" v-if="1 == 2">Nosotros</v-tab>
          <v-tab href="<?php echo SITE_URL ?>/contact" key="contact_tab">Contáctanos</v-tab>
          <v-tab class="pr-md-0" href="https://www.instagram.com/full_learning_/" key="ig_tab" target="_blank"><v-icon>mdi-instagram</v-icon></v-tab>
        </v-tabs>
      </v-col>
    </v-row>
  </v-col>