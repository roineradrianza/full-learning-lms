			<template class="mb-5">
			  <v-card
			    class="mx-auto elevation-5"
			    max-width="344"
			  >
			    <v-img
			      src="public/img/profile.jpg"
			      height="200px"
			    ></v-img>

			    <v-card-title>
			     	<?php echo $data['full_name'] ?>
			    </v-card-title>

			    <v-card-subtitle>
			     	<?php echo $data['job_title'] ?>
			    </v-card-subtitle>
			  </v-card>
			</template>