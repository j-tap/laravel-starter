<template lang='pug'>
div
	h3.mb-4 Edit Password
	.card
		.card-body
			edit-password-form(@updateSuccess='updateSuccess')

</template>

<script>
import EditPasswordForm from './EditPasswordForm.vue'

export default {
	components: {
		'edit-password-form': EditPasswordForm
	},
	methods: {
		updateSuccess() {
			this.$router.push({name: 'profile'})
		}
	}
}
</script>
