<template lang='pug'>
form(@submit.prevent='updateProfile')

	.form-group
		FileUpload(@uploadSuccess='uploadSuccess')
			Ava(:image='image')

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
import FileUpload from './FileUpload.vue'
import Ava from './Ava.vue'

export default {
	components: {
		FileUpload,
		Ava,
	},
	data () 
	{
		return {
			loading: false,
			error: {
				name: '',
				email: '',
				image: '',
			},
			image: null,
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
			axios.post(api.updateUserProfile, this.form)
				.then((res) => {
					this.loading = false
					this.$noty.success('Profile Updated')
					this.$emit('updateSuccess', res.data)
				})
				.catch(err => {
					(err.response.data.error) && this.$noty.error(err.response.data.error)

					(err.response.data.errors)
						? this.setErrors(err.response.data.errors)
						: this.clearErrors()

					this.loading = false
				});
		},
		setErrors (errors)
		{
			this.error.name = errors.name ? errors.name[0] : null
			this.error.email = errors.email ? errors.email[0] : null
			this.error.image = errors.image ? errors.image[0] : null
		},
		clearErrors ()
		{
			this.error.name = null
			this.error.email = null
			this.error.image = null
		},
		uploadSuccess (data) 
		{
			this.image = data.image
			this.form.image = data.image
		},
	},
	mounted ()
	{
		// let src = '/upload/ava/' + this.form.id + '.jpg'

		// let ava = new Image()
		// ava.src = src
		// ava.onerror = function ()
		// {
		// 	src = 'https://via.placeholder.com/150'
		// }

		// this.image = src
	}
}
</script>
