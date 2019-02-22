<template lang='pug'>
header.header.mb-4
	nav.navbar.navbar-expand-lg.navbar-dark.bg-dark
		.container
			router-link(class='navbar-brand' :to='{name: "index"}' v-once) {{ siteName }}
			button.navbar-toggler(
				type='button' 
				data-toggle='collapse' 
				data-target='#navbarSupportedContent' 
				aria-controls='navbarSupportedContent' 
				aria-expanded='false' 
				aria-label='Toggle navigation'
			)
				span.navbar-toggler-icon

			.collapse.navbar-collapse#navbarSupportedContent
				ul.navbar-nav.ml-auto
					router-link(
						:to='{name: "index"}' 
						tag='li' 
						class='nav-item' 
						activeClass='active' 
						exact
					)
						a.nav-link Home

					router-link(
						v-show='!isLoggedIn' 
						:to='{name: "signin"}' 
						tag='li' 
						class='nav-item' 
						activeClass='active' 
						exact
					)
						a.nav-link Login

					router-link(
						v-show='!isLoggedIn' 
						:to='{name: "signup"}' 
						tag='li' 
						class='nav-item' 
						activeClass='active' 
						exact
					)
						a.nav-link Registration

					router-link(
						v-show='isLoggedIn' 
						:to='{name: "profile"}' 
						tag='li' 
						class='nav-item' 
						activeClass='active'
					)
						a.nav-link Profile

					li.nav-item(v-show='isLoggedIn')
						a.nav-link(href='#' @click.prevent='logout') Logout

</template>

<script>
	import {siteName} from './../../config';
	import {mapGetters} from 'vuex';
	import jwtToken from '../../helpers/jwt-token';

	export default {
		data() {
			return {
				siteName: siteName
			}
		},
		computed: mapGetters([
			'isLoggedIn'
		]),
		methods: {
			logout() {
				jwtToken.removeToken();
				this.$store.dispatch('unsetAuthUser')
					.then(() => {
						this.$noty.success('You are logged out');
						this.$router.push({name: 'login'});
					});
			}
		}
	}
</script>
