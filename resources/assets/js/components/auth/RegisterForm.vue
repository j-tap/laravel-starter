<template lang='pug'>
form(@submit.prevent='register')
	.form-group
		label(for='name') Name
		input.form-control(
			type='text'
			:class='{"is-invalid": error.name}'
			id='name'
			v-model='form.name'
			autocomplete='off'
			:disabled='loading'
		)
		.invalid-feedback(v-show='error.name') {{ error.name }}
		
	.form-group
		label(for='email') Email
		input.form-control(
			type='email'
			:class='{"is-invalid": error.email}'
			id='email'
			v-model='form.email'
			autocomplete='off'
			:disabled='loading'
		)
		.invalid-feedback(v-show='error.email') {{ error.email }}
		
	.form-group
		label(for='password') Password
		input.form-control(
			type='password'
			:class='{"is-invalid": error.password}'
			id='password'
			v-model='form.password'
			:disabled='loading'
		)
		.invalid-feedback(v-show='error.password') {{ error.password }}

	.form-group
		button.btn.btn-primary.btn-block(type='submit' :disabled='loading')
			span(v-show='loading') Wait...
			span(v-show='!loading') Registration

</template>

<script>
import {api} from '../../config'

export default {
	data () {
		return {
			loading: false,
			form: {
				name: null,
				email: null,
				password: null
			},
			error: {
				name: null,
				email: null,
				password: null
			}
		}
	},
	methods: {
		register ()
		{
			this.loading = true
			axios.post(api.register, this.form)
				.then(res => {
					this.$noty.success(res.data.message)
					this.$emit('registrationSuccess', res.data)
					this.$router.push({name: 'index'})
				})
				.catch(err => {
					const res = err.response.data

					if (typeof res.error === 'string') {
						this.$noty.error(res.error)

					} else if (typeof res.error === 'object') {
						this.setErrors(res.error)

					} else {
						
						if (res.errors) {
							this.setErrors(res.errors)
						} else {
							this.clearErrors()
						}
					}
				})
				.finally(() => {
					this.loading = false
				})
		},
		setErrors (errors)
		{
			this.error.name = errors.name ? errors.name[0] : null
			this.error.email = errors.email ? errors.email[0] : null
			this.error.password = errors.password ? errors.password[0] : null
		},
		clearErrors ()
		{
			this.error.name = null
			this.error.email = null
			this.error.password = null
		}
	}
}
</script>
