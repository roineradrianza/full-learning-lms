<v-col class="grey lighten-1 px-6" cols="12" md="2">
    <?php echo new Template('components/snackbar') ?>
    <div class="d-flex justify-center mt-5" v-if="preview_avatar_image != null && preview_avatar_image != ''">
        <v-avatar class="avatar">
            <img :src="preview_avatar_image">
        </v-avatar>
    </div>
    <div class="d-flex justify-center mt-5" v-else>
        <v-icon class="avatar-icon" color="secondary">mdi-account-circle</v-icon>
    </div>

    <div class="d-flex justify-center mt-2">
        <v-row>
            <template v-if="image_btns && !avatar_loading">
                <v-col class="d-flex justify-end py-0" cols="6">
                    <v-btn color="success" @click="updateAvatarImage" text>
                        <v-icon>mdi-check</v-icon>
                    </v-btn>
                </v-col>
                <v-col class="d-flex justify-start py-0" cols="6">
                    <v-btn color="error" @click="undoImagePreview" text>
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-col>
            </template>
            <v-col class="d-flex justify-center py-0" cols="12" v-if="avatar_loading">
                <v-btn color="warning" @click="undoImagePreview" :loading="avatar_loading"></v-btn>
            </v-col>
            <v-col class="d-flex justify-center py-0" cols="12">
                <template v-if="image_upload_btn && !avatar_loading">
                    <label for="avatar_image">
                        <p class="text-uppercase cursor-pointer secondary--text">Seleccionar imágen</p>
                        <input type="file" name="avatar_image" id="avatar_image" class="d-none" accept="image/*"
                            v-on:change="prevImage" />
                    </label>
                </template>
                <v-btn color="primary" v-if="!image_upload_btn && !avatar_loading" @click="image_upload_btn = true"
                    text>Actualizar imágen</v-btn>
            </v-col>
        </v-row>
    </div>

    <h4 class="font-weight-thin text-h5 mt-4">{{ full_name }} <v-icon v-if="parseInt(profile.meta.become_teacher)"
            class="secondary--text">mdi-check-circle</v-icon>
    </h4>
    <v-list color="transparent">
        <v-list-item class="pl-0 pb-0 pt-0">

            <v-list-item-content>
                <v-list-item-title class="font-weight-thin">@{{ profile.username }}</v-list-item-title>
            </v-list-item-content>

        </v-list-item>
        <v-list-item class="pl-0 pb-0 pt-0" v-if="parseInt(profile.meta.become_teacher)">

            <v-list-item-content>
                <v-list-item-title class="font-weight-thin">{{ teacher_gender }}</v-list-item-title>
            </v-list-item-content>

        </v-list-item>
        <v-list-item class="pl-0 pb-0 pt-0">

            <v-list-item-content>
                <v-list-item-title class="font-weight-thin">{{ location }}</v-list-item-title>
            </v-list-item-content>

        </v-list-item>
        <v-divider></v-divider>
        <v-list-item-group>
            <v-list-item class="pl-0 pb-0 pt-0" v-if="1 == 2">

                <v-list-item-content>
                    <v-list-item-title class="grey--text text--darken-1 font-weight-thin">Actividad</v-list-item-title>
                </v-list-item-content>

            </v-list-item>
            <v-list-item class="pl-0 pb-0 pt-0" @click="courses_container = true">

                <v-list-item-content>
                    <v-list-item-title class="grey--text text--darken-1 font-weight-thin">Cursos</v-list-item-title>
                </v-list-item-content>

            </v-list-item>
            <v-list-item class="pl-0 pb-0 pt-0" @click="orders_container = true">

                <v-list-item-content>
                    <v-list-item-title class="grey--text text--darken-1 font-weight-thin">Pagos</v-list-item-title>
                </v-list-item-content>

            </v-list-item>
            <v-list-item class="pl-0 pb-0 pt-0" v-if="profile.hasOwnProperty('rol')">

                <v-list-item-content>
                    <v-list-item-title class="grey--text text--darken-1 font-weight-thin">Portafolio</v-list-item-title>
                </v-list-item-content>

            </v-list-item>
            <v-list-item class="pl-0 pb-0 pt-0" v-if="1 == 2">

                <v-list-item-content>
                    <v-list-item-title class="grey--text text--darken-1 font-weight-thin">Más</v-list-item-title>
                </v-list-item-content>

            </v-list-item>
            <v-divider></v-divider>
            <v-list-item class="pl-0 pb-0 pt-0" @click="grades_container = true">

                <v-list-item-content>
                    <v-list-item-title class="grey--text text--darken-1 font-weight-thin">Mis Calificaciones
                    </v-list-item-title>
                </v-list-item-content>

            </v-list-item>
            <v-list-item class="pl-0 pb-0 pt-0" @click="profile_container = true">

                <v-list-item-content>
                    <v-list-item-title class="grey--text text--darken-1 font-weight-thin">Editar perfil
                    </v-list-item-title>
                </v-list-item-content>

            </v-list-item>
        </v-list-item-group>
    </v-list>
</v-col>