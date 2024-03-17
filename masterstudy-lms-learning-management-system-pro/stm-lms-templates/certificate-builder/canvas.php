<div v-if="certificates[currentCertificate]" class="masterstudy-certificate-canvas__axis-vertical-wrapper"></div>
<div class="masterstudy-certificate-canvas" dir="ltr">
	<div v-if="certificates[currentCertificate]" class="masterstudy-certificate-canvas__axis-horizontal-wrapper">
		<img
			v-if="certificates[currentCertificate]?.data?.orientation === 'landscape'"
			src="<?php echo esc_url( STM_LMS_PRO_URL . 'assets/img/certificate-builder/long-axis-horizontal.svg' ); ?>"
			class="masterstudy-certificate-canvas__axis-horizontal landscape-axis"
		/>
		<img
			v-else
			src="<?php echo esc_url( STM_LMS_PRO_URL . 'assets/img/certificate-builder/short-axis-horizontal.svg' ); ?>"
			class="masterstudy-certificate-canvas__axis-horizontal"
		/>
	</div>
	<div
		v-if="certificates[currentCertificate]"
		class="masterstudy-certificate-canvas__wrapper"
		:class="certificates[currentCertificate]?.data?.orientation ?? 'landscape'"
		dir="ltr"
	>
		<div class="masterstudy-certificate-canvas-wrap">
			<img
				v-if="certificates[currentCertificate] && certificates[currentCertificate]?.data?.orientation === 'landscape'"
				src="<?php echo esc_url( STM_LMS_PRO_URL . 'assets/img/certificate-builder/short-axis-vertical.svg' ); ?>"
				class="masterstudy-certificate-canvas__axis-vertical landscape-axis"
			/>
			<img
				v-if="certificates[currentCertificate] && certificates[currentCertificate]?.data?.orientation === 'portrait'"
				src="<?php echo esc_url( STM_LMS_PRO_URL . 'assets/img/certificate-builder/long-axis-vertical.svg' ); ?>"
				class="masterstudy-certificate-canvas__axis-vertical"
			/>
			<div :class="(certificates[currentCertificate]?.data?.orientation ?? 'landscape') + ' canvas-wrap'">
				<span class="masterstudy-certificate-canvas__dash masterstudy-certificate-canvas__dash_top"></span>
				<span class="masterstudy-certificate-canvas__dash masterstudy-certificate-canvas__dash_bottom"></span>
				<span class="masterstudy-certificate-canvas__dash masterstudy-certificate-canvas__dash_left"></span>
				<span class="masterstudy-certificate-canvas__dash masterstudy-certificate-canvas__dash_right"></span>
				<div class="masterstudy-certificate-canvas-wrap__zone">
					<div class="masterstudy-certificate-canvas-background" v-if="certificates[currentCertificate]?.thumbnail">
						<img :src="certificates[currentCertificate].thumbnail" class="masterstudy-certificate-canvas-background__image" />
					</div>
					<vue-draggable-resizable
						v-if="certificates[currentCertificate]?.data?.fields !== undefined"
						:parent="true" v-for="(field, key) in certificates[currentCertificate].data.fields"
						:key="`draggable-${certificates[currentCertificate].id}`"
						:w="field.w"
						:h="field.h"
						:x="field.x"
						:y="field.y"
						:lockAspectRatio="field.type === 'image' ? true : false"
						drag-cancel=".settings"
						@resizestop="onResize"
						@activated="activeField = key"
						@dragstop="onDrag">
						<div v-if="field.type === 'image'" class="image-wrap">
							<img v-if="typeof field.imageId !== 'undefined'" v-bind:src="field.content"/>
							<div v-else @click="uploadFieldImage(key)" class="uploader">
								<span>
									<?php echo esc_html__( 'Select Image', 'masterstudy-lms-learning-management-system-pro' ); ?>
								</span>
							</div>
							<i class="fa fa-trash" @click="deleteField(key)" title="<?php echo esc_attr__( 'Delete field', 'masterstudy-lms-learning-management-system-pro' ); ?>"></i>
						</div>
						<div
							v-else
							:class="[
								'field-content',
								field.classes,
								{ 'field-fullwidth': certificates[currentCertificate]?.data?.orientation === 'portrait' ? field.w > 580 : field.w > 890 }
							]"
							@click="handleFieldClick(field.x, field.y)"
						>
							<textarea v-model="field.content"
									:readonly="field.type !== 'text'"
									v-bind:style="{
									'fontSize': field.styles.fontSize,
									'fontFamily': field.styles.fontFamily === 'OpenSans' ? 'Open Sans' : field.styles.fontFamily,
									'color': field.styles.color.hex,
									'textAlign': field.styles.textAlign,
									'textDecoration': field.styles.textDecoration ? 'underline' : 'none',
									'fontStyle': (field.styles.fontStyle && field.styles.fontStyle !== 'false') ? 'italic' : 'normal',
									'fontWeight': (field.styles.fontWeight && field.styles.fontWeight !== 'false') ? 'bold' : '400',
									}"
							></textarea>
							<div class="settings">
								<div class="font">
									<select v-model="field.styles.fontFamily">
										<option value="OpenSans">OpenSans</option>
										<option value="Montserrat">Montserrat</option>
										<option value="Merriweather">Merriweather</option>
										<option value="Katibeh">Katibeh (arab)</option>
										<option value="Amiri">Amiri (arab)</option>
										<option value="Oswald">Oswald</option>
									</select>
									<select v-model="field.styles.fontSize">
										<option value="8px">8px</option>
										<option value="10px">10px</option>
										<option value="12px">12px</option>
										<option value="14px">14px</option>
										<option value="16px">16px</option>
										<option value="18px">18px</option>
										<option value="20px">20px</option>
										<option value="24px">24px</option>
										<option value="28px">28px</option>
										<option value="32px">32px</option>
										<option value="40px">40px</option>
										<option value="60px">60px</option>
										<option value="80px">80px</option>
										<option value="100px">100px</option>
									</select>
								</div>
								<div class="font-style" @click="colorPickerShow()">
									<div class="color">
										<div class="color-value">
											<div v-bind:style="{'backgroundColor': typeof field.styles.color.hex !== 'undefined' ? field.styles.color.hex : '#000'}"></div>
										</div>
										<photoshop-picker v-show="colorPickerVisible" v-model="field.styles.color"></photoshop-picker>
									</div>
									<div class="align">
										<div class="checkbox-wrap">
											<input v-bind:id="'text-align-left-' + key" type="radio" v-model="field.styles.textAlign" value="left"/>
											<label class="left" v-bind:for="'text-align-left-' + key">
												<i class="fa fa-align-left"></i>
											</label>
										</div>
										<div class="checkbox-wrap">
											<input v-bind:id="'text-align-center-' + key" type="radio" v-model="field.styles.textAlign" value="center"/>
											<label class="center" v-bind:for="'text-align-center-' + key">
												<i class="fa fa-align-center"></i>
											</label>
										</div>
										<div class="checkbox-wrap">
											<input v-bind:id="'text-align-right-' + key" type="radio" v-model="field.styles.textAlign" value="right"/>
											<label class="right" v-bind:for="'text-align-right-' + key">
												<i class="fa fa-align-right"></i>
											</label>
										</div>
									</div>
									<div class="decoration">
										<div class="checkbox-wrap">
											<input v-bind:id="'font-weight-bold-' + key" type="checkbox" v-model="field.styles.fontWeight" value="bold"/>
											<label v-bind:for="'font-weight-bold-' + key">
												<i class="fa fa-bold"></i>
											</label>
										</div>
										<div class="checkbox-wrap">
											<input v-bind:id="'font-style-italic-' + key" type="checkbox" v-model="field.styles.fontStyle" value="italic"/>
											<label v-bind:for="'font-style-italic-' + key">
												<i class="fa fa-italic"></i>
											</label>
										</div>
									</div>
								</div>
							</div>
							<i class="fa fa-trash" @click="deleteField(key)" title="<?php echo esc_attr__( 'Delete field', 'masterstudy-lms-learning-management-system-pro' ); ?>"></i>
						</div>
					</vue-draggable-resizable>
				</div>
			</div>
		</div>
		<div class="masterstudy-certificate-canvas__actions" v-if="certificates[currentCertificate]?.id !== undefined">
			<div class="masterstudy-certificate-canvas__actions-wrapper">
				<div
					ref="titleContainer"
					class="masterstudy-certificate-canvas__actions-title"
					:class="{'masterstudy-certificate-canvas__actions-title_active': titleActive}"
					@click="addTitleActiveClass()"
				>
					<div
						contenteditable="true"
						ref="editCertificateTitle"
						@input="updateCertificateTitle($event.target.textContent)"
						class="masterstudy-certificate-canvas__actions-input"
					>
					</div>
					<span v-if="!titleActive" class="masterstudy-certificate-canvas__actions-icon" @click="focusOnEditCertificate()"></span>
					<span v-else class="masterstudy-certificate-canvas__actions-icon-accept" @click.stop="removeTitleActiveClass()"></span>
				</div>
				<a
					v-if="certificates[currentCertificate]?.id"
					href="#"
					class="masterstudy-button masterstudy-button_style-tertiary masterstudy-button_size-sm masterstudy_preview_certificate"
					:class="{'masterstudy-button_loading': previewLoading}"
					@click.prevent="previewCertificate($event)"
					:data-id="certificates[currentCertificate].id"
				>
					<span class="masterstudy-button__title">
						<?php echo esc_html__( 'Preview', 'masterstudy-lms-learning-management-system-pro' ); ?>
					</span>
				</a>
				<a
					href="#"
					class="masterstudy-button masterstudy-button_style-primary masterstudy-button_size-sm"
					:class="{'masterstudy-button_loading': loadingSaveButton}"
					@click.prevent="saveCertificate()"
				>
					<span v-if="certificateSaved" class="masterstudy-button__title">
						<?php echo esc_html__( 'Saved!', 'masterstudy-lms-learning-management-system-pro' ); ?>
					</span>
					<span v-else class="masterstudy-button__title">
						<?php echo esc_html__( 'Save Certificate', 'masterstudy-lms-learning-management-system-pro' ); ?>
					</span>
				</a>
			</div>
		</div>
	</div>
</div>
