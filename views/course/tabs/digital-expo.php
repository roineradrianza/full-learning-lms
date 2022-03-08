<v-row class="d-flex justify-center">
    <v-col class="course_news gradient pl-8 pl-md-16 py-16 expo-digital-br-radius-top" cols="12">
        <h1 class="white--text text-h4 text-md-h2 mb-3">Aliados</h1>
    </v-col>
    <v-col cols="12" style="background-color:#F6F6F6">
        <v-row class="px-16">
            <?php if (!empty($manage_course)): ?>
            <v-col class="d-flex justify-end" cols="12">
                <?php echo new Template('course/tabs/digital-expo/statistics-dialog') ?>
            </v-col>
            <?php endif?>
            <v-col class="pr-12 mb-n8" cols="12">
                <h3 class="text-h4 text-center text-md-left grey--text mb-6">Patrocinadores</h3>
                <v-col class="d-flex justify-center" cols="12">
                    <v-alert class="mb-2" border="top" colored-border type="info" elevation="2" dismissible>Al hacer
                        click en el logo de algún aliado podrás ver más fácil lo que tiene para mostrarte</v-alert>
                </v-col>
                <v-row class="d-flex justify-center align-center" v-if="sponsors.length > 0">
                    <v-col class="cursor-pointer course-card" cols="6" md="2" v-for="sponsor in sponsors"
                        @click="filterSponsorPosts(sponsor.sponsor_id);">
                        <v-img :src="sponsor.logo_url" max-width="250px"></v-img>
                    </v-col>
                </v-row>
                <v-divider></v-divider>
            </v-col>
            <v-col class="d-flex" cols="12" md="4" v-for="post in sponsors_posts_filtered"
                @click="saveSponsorPostView(post.sponsor_post_id)">
                <v-card :loading="loading" class="my-12 course-card flex-grow-1" max-width="95%">

                    <v-img class="post-image" width="100%" class="align-end" :src="post.post_image">
                        <v-card-title class="font-weight-bold ig-label float-right">
                            <v-icon class="float-right" dark x-large>mdi-instagram</v-icon>
                        </v-card-title>
                    </v-img>

                    <v-card-title class="text-h6 font-weight-normal no-word-break">
                        <template v-if="post.webiste != ''">
                            <a class="black--text" :href="post.website">{{ post.sponsor_name }}</a>
                        </template>
                        <template v-else>
                            {{ post.sponsor_name }}
                        </template>
                    </v-card-title>
                    <v-card-text class="grey--text text--lighten-1" v-html="post.description">

                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-col>
</v-row>