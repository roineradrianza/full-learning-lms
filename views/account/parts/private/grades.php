<v-col class="white px-12 py-md-8 info-container mt-10 mx-md-6" cols="12" md="7" v-if="grades_container">
    <v-dialog v-model="grades.dialog" max-width="1200px">
        <v-card>
            <v-toolbar class="gradient" elevation="0">
                <v-toolbar-title class="white--text">{{ grades.course.title }}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn icon dark @click="grades.dialog = false">
                        <v-icon color="white">mdi-close</v-icon>
                    </v-btn>
                </v-toolbar-items>
            </v-toolbar>

            <v-divider></v-divider>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col class="mb-n6" cols="12">
                            <p class="body-1 text-right secondary--text font-weight-bold"> {{ GradesAverage }}</p>
                        </v-col>
                        <v-col cols="12">
                            <v-data-table :headers="grades.headers" :items="grades.items" class="elevation-1"
                                :loading="grades.loading">
                                <template #item.score="{ item }">
                                    <template v-if="item.score === null">
                                        N/A
                                    </template>
                                    <template v-else>
                                        {{ item.score }}
                                    </template>
                                </template>
                                <template #item.approved="{ item }">
                                    <template v-if="item.approved === null">
                                        N/A
                                    </template>
                                    <template v-else>
                                        <v-chip class="ma-2" color="success" text-color="white"
                                            v-if="parseInt(item.approved)">
                                            Aprobado
                                        </v-chip>
                                        <v-chip class="ma-2" color="error" text-color="white" v-else>
                                            Reprobado
                                        </v-chip>
                                    </template>
                                </template>

                                <template #item.action="{ item }">
                                    <v-btn color="secondary"
                                        :href="'<?php echo SITE_URL ?>/courses/'+ grades.course.slug + '/' + item.lesson_id"
                                        text>
                                        Ir al quiz
                                    </v-btn>
                                </template>
                                <template #no-data>
                                    No hay quizzes disponibles a??n para este curso
                                </template>
                            </v-data-table>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
        </v-card>
    </v-dialog>
    <v-row v-if="my_courses.length > 0">
        <v-col class="mb-n8" cols="12">
            <h3 class="text-h5 mb-4">Selecciona un curso para ver tus calificaciones</h3>
            <v-divider></v-divider>
        </v-col>
        <v-col cols="12" md="4" v-for="course in my_courses"
            @click="grades.dialog = true; grades.course = course; loadMyGrades();">
            <v-card :loading="loading" class="my-12 course-card" max-width="95%" color="secondary">

                <v-img width="100vw" class="align-end" :src="course.featured_image">
                </v-img>

                <v-card-title class="text-h6 font-weight-normal white--text no-word-break">{{ course.title }}
                </v-card-title>

                <v-divider class="mx-4"></v-divider>
            </v-card>
        </v-col>
    </v-row>
    <v-row class="px-16" v-else>
        <v-col class="d-flex justify-center" cols="12">
            <v-img src="<?php echo SITE_URL ?>/public/img/no-grades.svg" max-width="40%"></v-img>
        </v-col>
        <v-col class="m-0" cols="12">
            <h4 class="text-h5 text-center">Qu?? l??stima, no podremos mostrarte tus calificaciones si no te has inscrito
                a alg??n curso, busca alg??n curso e
                inscr??bete.</h4>
        </v-col>
        <v-col class="m-0 d-flex justify-center" cols="12">
            <v-btn class="secondary white--text" href="<?php echo SITE_URL ?>/courses">Ver cursos</v-btn>
        </v-col>
    </v-row>
</v-col>