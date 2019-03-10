<template lang='pug'>
form(@submit.prevent='updateProfile')

	.form-group
		.profile-avaload
			.profile-ava
				img(:src='image' alt=' ')

			.custom-file(:class='{"is-invalid" : error.file}')
				input.custom-file-input#imageFile(
					ref='file'
					type='file' 
					v-on:change='onFileChange'
					:class='{"is-invalid" : error.file}'
				)
				label.custom-file-label(for='imageFile' :class='{"is-invalid" : error.file}') 
					span(v-if='filename') {{ filename }}
					span(v-else) Choose image
					
				.invalid-feedback(v-if='error.file') {{ error.file }}			

	.form-group
		label(for='name') Name
		input.form-control(
			type='text'
			:class='{"is-invalid" : error.name}'
			id='name'
			v-model='form.name'
			:disabled='loading'
		)
		.invalid-feedback(v-show='error.name') {{ error.name }}

	.form-group
		label(for='email') Email
		input.form-control(
			type='email'
			:class='{"is-invalid" : error.email}'
			id='email'
			v-model='form.email'
			:disabled='loading'
		)
		.invalid-feedback(v-show='error.email') {{ error.email }}

	button.btn.btn-primary(type='submit' :disabled='loading')
		span(v-show='loading') Updating Profile
		span(v-show='!loading') Update Profile

</template>

<script>
import {api} from '../../config'
import {mapState} from 'vuex'

export default {
	data () 
	{
		return {
			formData: new FormData(),
			loading: false,
			error: {
				name: null,
				email: null,
				file: null,
			},
			image: null,
			file: null,
			filename: null,
		};
	},
	computed: mapState({
		form: state => {
			return {...state.auth}
		}
	}),
	methods: {
		updateProfile ()
		{
			this.loading = true

			for ( let key in this.form ) {
				this.formData.append(key, this.form[key])
			}
			//console.log(this.formData.get('file'))
			
			axios.post(
				api.updateUserProfile, 
				this.formData, { 
					headers: { 
						'Content-Type': 'multipart/form-data' 
					} 
				}
			)
			.then((res) => {
				this.loading = false
				this.$noty.success('Profile Updated')
				this.$emit('updateSuccess', res.data)
			})
			.catch(err => {
				//console.log(err.response.data) //file: ["The file must be a file of type: jpeg, jpg, png, gif."]
				if (err.response.data.errors) {
					this.$noty.error(err.response.data.message)
					this.setErrors(err.response.data.errors)
				} else {
					this.clearErrors()
				}
					
				this.loading = false
			});
		},

		uploadSuccess (data) 
		{
			this.image = data.image
			this.form.file = data.file
		},

		onFileChange () 
		{
			this.file = this.$refs.file.files[0]
			this.formData.append('file', this.file)
			this.filename = this.file.name

			this.createImage()
		},

		createImage () 
		{
			let fileReader = new FileReader()
			let _this = this

			fileReader.onload = (e) => {
				_this.image = e.target.result
			};
			fileReader.readAsDataURL(this.file)
		},

		setErrors (err)
		{
			this.error.name = err.name ? err.name[0] : null
			this.error.email = err.email ? err.email[0] : null
			this.error.file = err.file ? err.file[0] : null
		},

		clearErrors ()
		{
			this.error.name = null
			this.error.email = null
			this.error.file = null
		},
	},
	mounted ()
	{

	}
}
</script>

<style scoped lang='scss'>
.profile-ava {
	margin-bottom: 15px;

		img {
			display: block;
			max-height: 160px;
			width: auto;
		}
}
</style>