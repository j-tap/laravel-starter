<template lang='pug'>
form(@submit.prevent='register')
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
        register ()
        {
            this.loading = true;
            axios.post(api.register, this.form)
                .then(res => {
                    this.loading = false;
                    this.$noty.success('Your registration success!');
                    this.$emit('registrationSuccess', res.data);
                })
                .catch(err => {
                    (err.response.data.error) && this.$noty.error(err.response.data.error);

                    (err.response.data.errors)
                        ? this.setErrors(err.response.data.errors)
                        : this.clearErrors();

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
