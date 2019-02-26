<template lang='pug'>
form(@submit.prevent='login')
	.form-group
		label(for='email') Email
		input.form-control(
			type='email'
			:class='{"is-invalid": error.email}'
			id='email'
			v-model='form.email'
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
			span(v-show='!loading') Login

</template>

<script>
import {api} from '../../config'

export default {
	data () {
		return {
			loading: false,
			form: {
				email: null,
				password: null
			},
			error: {
				email: null,
				password: null
			}
		}
	},
	methods: {
		login ()
		{
			this.loading = true;
			axios.post(api.login, this.form)
				.then(res => {
					this.loading = false;
					//this.$noty.success('Welcome back!');
					this.$emit('loginSuccess', res.data);
					this.$router.push({name: 'profile'});
				})
				.catch(err => {
					const res = err.response.data;

					if (typeof res.error === 'string') {
						this.$noty.error(res.error)

					} else if (typeof res.error === 'object') {
						this.setErrors(res.error)

					} else {
						
						if (res.errors) {
							this.setErrors(res.errors)
						} else {
							this.clearErrors();
						}
					}

					this.loading = false;
				});
		},
		setErrors (errors)
		{
			this.error.email = errors.email ? errors.email[0] : null;
			this.error.password = errors.password ? errors.password[0] : null;
		},
		clearErrors ()
		{
			this.error.email = null;
			this.error.password = null;
		}
	}
}
</script>
