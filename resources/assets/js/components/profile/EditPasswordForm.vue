<template lang='pug'>
form(@submit.prevent='updatePassword')
	.form-group
		label(for='new-password') New Password
		input.form-control(
			type='password'
			:class='{"is-invalid" : error.new_password}'
			id='new-password'
			v-model='form.new_password'
			:disabled='loading'
		)
		.invalid-feedback(v-show='error.new_password') {{ error.new_password }}

	.form-group
		label(for='confirm-new-password') Confirm New Password
		input.form-control(
			type='password'
			:class='{"is-invalid" : error.confirm_new_password}'
			id='confirm-new-password'
			v-model='form.confirm_new_password'
			:disabled='loading'
		)
		.invalid-feedback(v-show='error.confirm_new_password') {{ error.confirm_new_password }}

	button.btn.btn-primary(type='submit' :disabled='loading')
		span(v-show='loading') Updating Password
		span(v-show='!loading') Update Password

	.form-text.text-muted.mt-4 
		| Update Profile is disabled for demo purpose. 
		br
		| Please, enable it from 
		code updatePassword()
		| method in EditPasswordForm.vue component

</template>

<script>
import {mapState} from 'vuex'
import {api} from '../../config'

export default {
	data () {
		return {
			loading: false,
			form: {
				new_password: '',
				confirm_new_password: ''
			},
			error: {
				new_password: '',
				confirm_new_password: ''
			}
		}
	},
	methods: {
		updatePassword ()
		{
			this.loading = true
			axios.post(api.updateUserPassword, this.form)
				.then((res) => {
					this.$noty.success('Password updated')
					this.$emit('updateSuccess')
				})
				.catch(err => {
					(err.response.data.error) && this.$noty.error(err.response.data.error)

					(err.response.data.errors)
						? this.setErrors(err.response.data.errors)
						: this.clearErrors()
				})
				.finally(() => {
					this.loading = false
				})
		},
		setErrors (errors)
		{
			this.error.new_password = errors.new_password ? errors.new_password[0] : null
			this.error.confirm_new_password = errors.confirm_new_password ? errors.confirm_new_password[0] : null
		},
		clearErrors ()
		{
			this.error.new_password = null
			this.error.confirm_new_password = null
		}
	}
}
</script>
