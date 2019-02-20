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

		.col-12.col-md-9
			transition(name='fade' mode='out-in')
				router-view
</template>

<script>
export default {}
</script>
