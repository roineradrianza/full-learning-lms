<v-row class="mt-n3">
    <v-col cols="12" class="pl-0 pr-md-16 pr-0 pb-0" md="7">
        <video id="my-video" class="video-js vjs-fluid vjs-big-play-centered" controls preload="auto" width="100%"
            height="100vh" poster="<?php echo SITE_URL ?>/public/assets/posters/video-image-cover.jpg" data-setup="{}"
            autoplay muted loop>
            <source src="<?php echo SITE_URL ?>/public/assets/media/cover-video.mp4" type="video/mp4" />
            <p class="vjs-no-js">
                Para ver este video por favor habilita Javascript, y considera actualizar a un navegador
                <a href="https://videojs.com/html5-video-support/" target="_blank">que soporte videos HTML5</a>
            </p>
        </video>
        <h2 class="py-3 pl-12 course-title" white>Invierte en tu futuro</h2>
    </v-col>
    <v-col cols="12" md="5" class="CTA-container mt-16">
        <h1 class="text-md-h1 text-h2 grey--text text--darken-2 mt-md-16 text-center text-md-left">Comienza</h1>
        <h2 class="text-md-h1 text-h2 font-weight-thin text-center text-md-left">a invertir en ti</h2>
        <h3 class="font-weight-thin text-center text-md-left">Contribuimos con el propósito de tu proyecto de vida
        </h3>
        <v-col cols="12" md="10">
            <v-text-field v-model="search" class="rounded-pill font-weight-light mt-16" label="Buscar cursos"
                single-line solo>
                <template v-slot:append>
                    <v-btn class="search_button py-10 px-12 px-md-0" color="secondary"
                        :href="'<?php echo SITE_URL ?>/courses/?search=' + search" dark>
                        <v-icon>mdi-magnify</v-icon>
                    </v-btn>
                </template>
            </v-text-field>
        </v-col>
        <v-row class="CTA d-fle justify-space-between align-center">
            <v-col cols="12" md="12">
                <img src="<?php echo SITE_URL ?>/public/img/flecha.svg" class="CTA-button"></img>
                <h4 class="primary--text text-uppercase text-right d-md-inline CTA-title"><a
                        href="<?php echo SITE_URL ?>/register">Ingresa gratis</a></h4>
            </v-col>
        </v-row>
    </v-col>
</v-row>
<v-row>
    <v-col cols="12" sm="12" class="menu-color py-8">
        <h2 class="text-center grey--text text--darken-1 font-weight-thin">Aprovecha nuestros
            <strong>cursos</strong>
        </h2>
    </v-col>
</v-row>
<?php if (!empty($data)): ?>

<v-row class="px-16 mt-4">
    <v-col cols="12" sm="12">
        <h2 class="text-h4 font-weight-bold secondary--text text-center text-md-left">Cursos</h2>
        <h3 class="subtitle-desc d-block d-md-inline text-center text-md-left" v-if="1 == 2">Aquí un texto que
            explique qué son los cursos</h3>
        <v-row class="d-flex justify-center justify-md-end">
            <v-btn class="px-10 py-0 mr-md-4 mt-4 mt-md-0 rounded-pill secondary--text font-weight-light"
                href="<?php echo SITE_URL ?>/courses/" outlined>Ver más</v-btn>

        </v-row>
    </v-col>
</v-row>

<?php echo new Template('courses/parts/recent_courses', $data) ?>

<?php endif ?>
<?php echo new Template('components/news') ?>
<?php echo new Template('components/teachers_grid') ?>