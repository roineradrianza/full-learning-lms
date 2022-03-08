				<v-row class="course_news gradient pt-12 pb-12 pl-md-16 pr-md-10">
					<v-col class="pl-10" cols="12">
						<h1 class="white--text text-h2">Resultados para "<?php echo $data['search_item'] ?>"</h1>
					</v-col>
				</v-row>	
				<v-row class="d-flex justify-center">
					<v-col class="CTA ml-md-n2" cols="12" md="6">
						<v-text-field v-model="search" class="rounded-pill font-weight-light mt-16" label="Buscar cursos" single-line solo>
			      	<template v-slot:append>
			      		<v-btn class="search_button py-10 px-12 px-md-0" color="secondary" :href="'<?php echo SITE_URL ?>/courses/?search=' + search" dark><v-icon x-large>mdi-magnify</v-icon></v-btn>
			      	</template>
			      </v-text-field>
					</v-col>
					<?php if (empty($courses)): ?>
						<?php echo new Template('courses/parts/not_results'); ?>
					<?php else: ?>
					<v-col cols="12" md="10">
						<?php echo new Template('courses/parts/search_results', $courses) ?>
					</v-col>
					<?php endif ?>
				</v-row>			