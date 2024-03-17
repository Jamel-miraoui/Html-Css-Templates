<div class="masterstudy-certificate-templates">
	<div class="masterstudy-certificate-templates__header">
		<div class="masterstudy-certificate-templates__header-title">
			<?php esc_html_e( 'Certificates', 'masterstudy-lms-learning-management-system-pro' ); ?>
		</div>
		<div class="masterstudy-certificate-templates__header-quantity">
			{{ Object.keys(certificates).length }}
		</div>
		<span class="masterstudy-certificate-templates__header-add" @click="openCreatePopup()"></span>
	</div>
	<div class="masterstudy-certificate-templates__content">
		<label
			v-for="(certificate, key) in certificates"
			class="masterstudy-certificate-templates__item"
			:class="{'masterstudy-certificate-templates__item_active': currentCertificate === key}"
		>
			<span class="masterstudy-certificate-templates__item-delete" @click="openDeletePopupCertificate(key)"></span>
			<div
				class="masterstudy-certificate-templates__item-image"
				:class="{'masterstudy-certificate-templates__item-image_portrait': certificate.data.orientation === 'portrait'}"
			>
				<img v-if="certificate?.image" :src="certificate.image"/>
			</div>
			<div class="masterstudy-certificate-templates__item-content">
				<span class="masterstudy-certificate-templates__item-title">{{certificate.title}}</span>
				<span class="masterstudy-certificate-templates__item-id">{{certificate.id}}</span>
			</div>
			<input type="radio" v-model="currentCertificate" :value="key" class="masterstudy-certificate-templates__item-input"/>
		</label>
	</div>
</div>
