<template lang="pug">
b-form(
	novalidate
	@submit.prevent="submit"
)
	b-form-group(
		label="Email:"
	)
		b-form-input(
			v-model.trim="form.email"
			type="email"
			required
			placeholder="example@mail.com"
			:disabled="loading"
			:state="getStateField('form.email')"
			v-validate="'required|email'"
			data-vv-as="Email"
			data-vv-name="form.email"
		)
		b-form-invalid-feedback(:show="errors.first('form.email')") {{ errors.first('form.email') }}

	b-form-group(
		label="Password:"
	)
		b-form-input(
			v-model.trim="form.password"
			type="password"
			required
			placeholder="******"
			:disabled="loading"
			:state="getStateField('form.password')"
			v-validate="'required|min:6'"
			data-vv-as="Пароль"
			data-vv-name="form.password"
		)
		b-form-invalid-feedback(:show="errors.first('form.password')") {{ errors.first('form.password') }}

	b-alert(
		:show="err"
		variant="danger"
	) {{err}}

	b-button(
		variant="primary"
		size="lg"
		block
		type="submit"
		:disabled="loading"
	)
		span(v-show='loading') Wait...
		span(v-show='!loading') Login

</template>

<script>
import { Validator } from 'vee-validate'

export default {
	data () {
		return {
			loading: false,
			form: {
				email: 'j-tap@ya.ru',
				password: null
			},
			err: null,
		}
	},
	methods: {
		submit ()
		{
			this.$validator.validateAll()
			.then((result) => {
				if (result) 
				{
					this.formSend('login')
				} 
				else {
					
				}
			})
		},
	},
	mounted () {},
	watch: {},
}
</script>
