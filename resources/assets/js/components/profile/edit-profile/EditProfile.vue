<template lang='pug'>
div
	h3.mb-4 Edit Profile
	.card
		.card-body
			edit-profile-form(@updateSuccess='updateSuccess')

</template>

<script>
import EditProfileForm from './EditProfileForm.vue'
import {mapActions} from 'vuex'

export default {
	components: {
		'edit-profile-form': EditProfileForm
	},
	methods: {
		...mapActions([
			'setAuthUser'
		]),
		updateSuccess(data) {
			this.setAuthUser(data.user)
			this.$router.push({name: 'profile'})
		}
	}
}
</script>
