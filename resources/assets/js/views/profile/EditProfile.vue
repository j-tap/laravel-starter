<template lang='pug'>
div
	h3.mb-4 Edit Profile
	.card
		.card-body
			EditProfileForm(@updateSuccess='updateSuccess')

</template>

<script>
import {mapActions} from 'vuex'
import EditProfileForm from '../../components/profile/EditProfileForm.vue'

export default {
	components: {
		EditProfileForm,
	},
	methods: {
		...mapActions([
			'setAuthUser'
		]),
		updateSuccess (data) 
		{
			console.log(data)
			this.setAuthUser(data.user)
			this.$router.push({name: 'profile'})
		},
	}
}
</script>
