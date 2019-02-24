<template lang='pug'>
.container
	.row
		.col-12.col-md-6.col-lg-8
			.page-header
				h1.display-4 registration
				
		.col-12.col-md-6.col-lg-4
			.card
				.card-body
					RegisterForm(@RegisterSuccess='registerSuccess')

</template>

<script>
import RegisterForm from '../components/auth/RegisterForm.vue'
export default {
	components: {
		RegisterForm
	},
	methods: {
		registerSuccess (data)
		{
			console.log('registration success')
		}
	}
}
</script>
