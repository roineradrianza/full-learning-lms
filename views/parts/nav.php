
			  <v-row class="px-md-4 mt-n3 elevation-2 white d-flex align-center">
			    <v-col class="px-8 d-flex justify-center justify-md-start" cols="12" md="3">
			    	<a href="/">
				      <v-img class="d-none d-md-inline-block d-lg-none" src="<?php echo SITE_URL ?>/public/img/full-learning-logo.png" max-width="22vw"></v-img>
				      <v-img class="d-none d-lg-inline-block d-md-none" src="<?php echo SITE_URL ?>/public/img/full-learning-logo.png" max-width="16vw"></v-img>
				      <v-img class="d-inline-block d-lg-none d-md-none" src="<?php echo SITE_URL ?>/public/img/full-learning-logo.png" width="85vw"></v-img>
			    	</a>
			    </v-col>
			    <v-col cols="12" md="9" class="mt-md-2 mt-n8 d-none d-md-flex justify-center justify-md-end align-center">
		        <v-tabs v-model="nav_tab" class="menu-items" background-color="transparent" right>
		          <v-tab class="black--text font-weight-bold"  key="become_teacher" v-if="1 == 2">Conviértete en Profesor</v-tab>
		          <v-tab class="black--text font-weight-bold"  key="enterprise" v-if="1 == 2">Empresas</v-tab>
		          <?php if (!isset($_SESSION['user_id'])): ?>
		          <v-tab href="<?php echo SITE_URL ?>/login" key="login" class="black--text font-weight-bold">Iniciar sesión</v-tab>
		         	<v-btn href="<?php echo SITE_URL ?>/register" class="white--text rounded-pill px-12 py-3 mt-1 secondary text-uppercase font-weight-light">Registrate</v-btn>
		          <?php endif ?>
		        </v-tabs>
		      	<?php if (isset($_SESSION['user_id'])): ?>
				    <v-menu content-class="notification" center bottom transition="slide-y-transition">
			        <template v-slot:activator="{ on, attrs }">
			          <v-btn class="ml-2 mr-4" icon v-bind="attrs" v-on="on" @click="$http.post('/api/notifications/mark-seen', {notifications: notifications.filter( (notification) => {return notification.seen == 0})})">
			          	<v-badge color="secondary" v-if="notifications.filter( (notification) => {return notification.seen == 0}).length > 0" dot>
			          		<v-icon class="grey--text text--lighten-1" size="34">mdi-bell</v-icon>	
			          	</v-badge>
			          	<v-icon class="grey--text text--lighten-1" size="34" v-else>mdi-bell</v-icon>	
			          </v-btn>
			        </template>
			        <v-row></v-row>
			        <v-list>
			        	<p class="text-center secondary--text font-weight-bold mb-n2">Notificaciones</p>
			        	<v-row class="d-flex justify-center align-center">
			        		<template v-for="notification in notifications" v-if="notifications.length > 0">
				        		<v-col cols="12">
				        			<v-divider></v-divider>
				        		</v-col>
					        	<v-col class="px-4" cols="2">
					        		<v-avatar color="secondary" size="56">
					        			<v-img :src="notification.course_featured_image" v-if="notification.course_featured_image != null"></v-img>
					        			<v-icon light v-else>mdi-bell</v-icon>
					        		</v-avatar>
					        	</v-col>
					        	<v-col class="pl-8 pl-4 pr-4" cols="9" v-html="notification.description">
					        		
					        		<br>
					        		<br>
					        	</v-col>
				        		<v-col cols="12" class="d-flex justify-end p-0 mt-n8" v-if="notification.redirect_url != null">
					        		<v-btn class="px-6" color="secondary" :href="notification.redirect_url" right light>Ver</v-btn>					        			
				        		</v-col>
			        		</template>
			        		<template v-IF="notifications.length == 0">
			        			<v-col class="d-flex justify-center" cols="12" md="8">
			        				<img class="ml-n4" src="<?php echo SITE_URL ?>/public/img/empty-notifications.svg" width="70%"></img>
			        			</v-col>
			        			<v-col class="d-flex justify-center" cols="12" md="9">
			        				<h5 class="text-h6 text-center secondary--text font-weight-bold">No tienes notificaciones aún</h5>
			        			</v-col>
			        		</template>
			        	</v-row>
			        	<v-col class="gradient p-0 py-1 mb-n2" cols="12"></v-col>
			        </v-list>
			      </v-menu>
				    <v-menu content-class="notification" center bottom transition="slide-y-transition">
			        <template v-slot:activator="{ on, attrs }">
			          <v-btn icon v-bind="attrs" v-on="on">
			          	<?php if ($_SESSION['avatar'] == null): ?>
			          	<v-icon color="primary" md>mdi-account</v-icon>	
			          	<?php else: ?>
							    <v-avatar>
							      <img src="<?php echo $_SESSION['avatar'] ?>" alt="<?php echo $_SESSION['first_name'] ?>">
							    </v-avatar>
			          	<?php endif ?>
			          </v-btn>
			        </template>
			        <v-list>
			        	<?php if ($_SESSION['user_type'] == 'administrador'): ?>
			         	<v-list-item href="<?php echo SITE_URL ?>">
						      <v-list-item-content>
						        <v-list-item-title class="text-center">Inicio</v-list-item-title>
						      </v-list-item-content>
				    		</v-list-item>
			         	<v-list-item href="<?php echo SITE_URL ?>/admin/">
						      <v-list-item-content>
						        <v-list-item-title class="text-center">Panel Administrativo</v-list-item-title>
						      </v-list-item-content>
				    		</v-list-item>
			        	<?php endif ?>
			          <v-list-item href="<?php echo SITE_URL ?>/profile/">
						      <v-list-item-content>
						        <v-list-item-title class="text-center">Perfil</v-list-item-title>
						      </v-list-item-content>
			          </v-list-item>
			          <v-list-item>
			            <v-btn color="red" href="<?php echo SITE_URL ?>/api/members/logout" text onclick="gapi.auth2.getAuthInstance().signOut()">Cerrar sesión</v-btn>
			          </v-list-item>
			        </v-list>
			      </v-menu>
			    	<?php endif ?>
			    </v-col>

			    <?php if (isset($_SESSION['user_id'])): ?>
			    <v-col cols="12" class="mt-md-2 mt-n8 d-flex justify-center justify-md-end align-center d-inline d-md-none">
				    <v-menu content-class="notification" center bottom transition="slide-y-transition">
			        <template v-slot:activator="{ on, attrs }">
			          <v-btn class="ml-2 mr-4" icon v-bind="attrs" v-on="on" @click="$http.post('/api/notifications/mark-seen', {notifications: notifications.filter( (notification) => {return notification.seen == 0})})">
			          	<v-badge color="secondary" v-if="notifications.filter( (notification) => {return notification.seen == 0}).length > 0" dot>
			          		<v-icon class="grey--text text--lighten-1" size="34">mdi-bell</v-icon>	
			          	</v-badge>
			          	<v-icon class="grey--text text--lighten-1" size="34" v-else>mdi-bell</v-icon>	
			          </v-btn>
			        </template>
			        <v-row></v-row>
			        <v-list>
			        	<p class="text-center secondary--text font-weight-bold mb-n1">Notificaciones</p>
			        	<v-row class="d-flex justify-center align-center">
			        		<template v-for="notification in notifications" v-if="notifications.length > 0">
				        		<v-col cols="12">
				        			<v-divider></v-divider>
				        		</v-col>
					        	<v-col class="px-4" cols="2">
					        		<v-avatar color="secondary" size="56">
					        			<v-img :src="notification.course_featured_image" v-if="notification.course_featured_image != null"></v-img>
					        			<v-icon light v-else>mdi-bell</v-icon>
					        		</v-avatar>
					        	</v-col>
					        	<v-col class="pl-8 pl-4 pr-4" cols="9" v-html="notification.description">
					        		
					        		<br>
					        		<br>
					        	</v-col>
				        		<v-col cols="12" class="d-flex justify-end p-0 mt-n8" v-if="notification.redirect_url != null">
					        		<v-btn class="px-6" color="secondary" :href="notification.redirect_url" right light>Ver</v-btn>					        			
				        		</v-col>
			        		</template>
			        		<template v-IF="notifications.length == 0">
			        			<v-col class="d-flex justify-center" cols="12" md="8">
			        				<img class="ml-n4" src="<?php echo SITE_URL ?>/public/img/empty-notifications.svg" width="70%"></img>
			        			</v-col>
			        			<v-col class="d-flex justify-center" cols="12" md="9">
			        				<h5 class="text-h6 text-center secondary--text font-weight-bold">No tienes notificaciones aún</h5>
			        			</v-col>
			        		</template>
			        	</v-row>
			        	<v-col class="gradient p-0 py-1 mb-n2" cols="12"></v-col>
			        </v-list>
			      </v-menu>   
				    <v-menu content-class="notification" right bottom>
			        <template v-slot:activator="{ on, attrs }">
			          <v-btn icon v-bind="attrs" v-on="on">
			          	<?php if ($_SESSION['avatar'] == null): ?>
			          	<v-icon color="primary" md>mdi-account</v-icon>	
			          	<?php else: ?>
							    <v-avatar>
							      <img src="<?php echo $_SESSION['avatar'] ?>" alt="<?php echo $_SESSION['first_name'] ?>">
							    </v-avatar>
			          	<?php endif ?>
			          </v-btn>
			        </template>
			        <v-list>
			        	<?php if ($_SESSION['user_type'] == 'administrador'): ?>
			          <v-list-item class="d-flex justify-center">
			            <v-btn href="<?php SITE_URL ?>" text>Inicio</v-btn>
			          </v-list-item>
			          <v-list-item class="d-flex justify-center">
			            <v-btn href="<?php SITE_URL ?>/admin/" text>Panel Administrativo</v-btn>
			          </v-list-item>
			        	<?php endif ?>
			          <v-list-item class="d-flex justify-center">
			            <v-btn href="<?php SITE_URL ?>/profile/" text>Perfil</v-btn>
			          </v-list-item>
			          <v-list-item class="d-flex justify-center" v-if="1 == 2">
			            <v-btn href="<?php SITE_URL ?>/become-teacher" text>Conviértete en profesor</v-btn>
			          </v-list-item>
			          <v-list-item class="d-flex justify-center" v-if="1 == 2">
			            <v-btn href="<?php SITE_URL ?>/my-courses" text>Mis cursos</v-btn>
			          </v-list-item>
			          <v-list-item class="d-flex justify-center" v-if="1 == 2">
			            <v-btn href="<?php SITE_URL ?>/api/members/logout" text>Empresas</v-btn>
			          </v-list-item>
			          <v-list-item class="d-flex justify-center">
			            <v-btn color="red" href="<?php SITE_URL ?>/api/members/logout" text onclick="gapi.auth2.getAuthInstance().signOut()">Cerrar sesión</v-btn>
			          </v-list-item>
			        </v-list>
			      </v-menu> 	
			    </v-col>
			    <?php else: ?>

			    <v-col cols="12" md="9" class="mt-md-2 mt-n8 d-flex d-md-none justify-center">
			    	<v-menu :offset-y="true" bottom transition="slide-y-transition">
			        <template v-slot:activator="{ on, attrs }">
			          <v-btn icon v-bind="attrs" v-on="on">
			          	<v-icon color="primary" md>mdi-menu</v-icon>	
			          </v-btn>
			        </template>
			        <v-list>
			         	<v-list-item href="<?php echo SITE_URL ?>">
						      <v-list-item-content>
						        <v-list-item-title class="text-center">Conviértete en Profesor</v-list-item-title>
						      </v-list-item-content>
				    		</v-list-item>
			         	<v-list-item href="<?php echo SITE_URL ?>/admin/">
						      <v-list-item-content>
						        <v-list-item-title class="text-center">Empresas</v-list-item-title>
						      </v-list-item-content>
				    		</v-list-item>
			          <v-list-item href="<?php echo SITE_URL ?>/login">
						      <v-list-item-content>
						        <v-list-item-title class="text-center">Iniciar Sesión</v-list-item-title>
						      </v-list-item-content>
			          </v-list-item>
			          <v-list-item href="<?php echo SITE_URL ?>/register">
						      <v-list-item-content>
						        <v-list-item-title class="text-center"><v-btn href="<?php echo SITE_URL ?>/register" class="white--text rounded-pill px-12 py-3 mt-1 secondary text-uppercase font-weight-light">Registrarse</v-btn></v-list-item-title>
						      </v-list-item-content>
			          </v-list-item>
			        </v-list>
			      </v-menu>
			    </v-col>

			  	<?php endif ?>
			  </v-row>
