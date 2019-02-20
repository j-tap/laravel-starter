<template lang='pug'>
.container
	.jumbotron
		h1.display-4(v-once) {{siteName}}
		p Starter Boilerplate SPA made with Laravel 5.6, Bootstrap 4, JWT Auth, Vue 2, Vue-router 3, Vuex 3, Axios and love

</template>

<script>
	import {siteName} from './../../config';

	export default {
		data () {
			return {
				siteName: siteName
			}
		}
	}
</script>
