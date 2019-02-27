<template lang='pug'>
.container
	.row
		.col-12.col-md-3
			nav.nav.flex-column.nav-pills.mb-4
				router-link(
					:to='{name: "profile"}'
					class='nav-link'
					activeClass='active'
					exact
				) View Profile

				router-link(
					:to='{name: "profile.editProfile"}'
					class='nav-link'
					activeClass='active' 
					exact
				) Edit Profile
				
				router-link(
					:to='{name: "profile.editPassword"}' 
					class='nav-link' 
					activeClass='active'
					exact
				) Edit Password

				.nav-link &nbsp;

				a.nav-link(href='#' @click.prevent='logout') Logout

		.col-12.col-md-9
			transition(name='fade' mode='out-in')
				router-view
</template>

<script>
import jwtToken from '../../helpers/jwt-token'
export default {
	methods: {
		logout () 
		{
			jwtToken.removeToken();
			this.$store.dispatch('unsetAuthUser')
				.then(() => {
					this.$noty.success('You are logged out');
					this.$router.push({name: 'signin'});
				});
		}
	},
}
</script>
