<template lang='pug'>
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
		:to='{name: "users"}' 
		tag='li' 
		class='nav-item' 
		activeClass='active'
	)
		a.nav-link Users

	router-link(
		v-show='isLoggedIn' 
		:to='{name: "profile"}' 
		tag='li' 
		class='nav-item' 
		activeClass='active'
	)
		a.nav-link Profile

</template>

<script>
import {mapGetters} from 'vuex'

export default {
	data () {
		return {
			nav: [], // NEED make auto print menu
		}
	},
	computed: mapGetters([
		'isLoggedIn'
	]),
	methods: {
		
	},
	created ()
	{
		// NEED make auto print menu
		/*this.$router.options.routes.forEach(route => {
			this.nav.push({
				name: route.name, 
				path: route.path,
				meta: route.meta
			})
		})*/
	}
}
</script>
