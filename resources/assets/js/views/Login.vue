<template lang='pug'>
.container
	.row
		.col-12.col-md-6.col-lg-8
			.page-header
				h1.display-4 Login

			.py-4
				p Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur corporis deserunt, dolorem eligendi esse eum illo illum inventore libero minus nam numquam officiis praesentium quas quasi repudiandae sed tempore voluptatibus?
		
		.col-12.col-md-6.col-lg-4
			.card
				.card-body
					LoginForm(@loginSuccess='loginSuccess')

</template>

<script>
import LoginForm from '../components/auth/LoginForm.vue'
import jwtToken from '../helpers/jwt-token'
import {mapActions} from 'vuex'

export default {
	components: {
		LoginForm
	},
	methods: {
		...mapActions([
			'setAuthUser'
		]),
		loginSuccess (data) 
		{
			jwtToken.setToken(data.token);
			this.setAuthUser(this, data.user);
			this.$router.push({name: 'profile'});
		}
	}
}
</script>
