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
				Nav

</template>

<script>
import Nav from '../Nav.vue';
import {siteName} from './../../config';

export default {
	components: {
		Nav,
	},
	data() {
		return {
			siteName: siteName
		}
	},
}
</script>
