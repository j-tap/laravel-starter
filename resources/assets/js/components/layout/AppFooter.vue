<template lang='pug'>
footer
	hr
	.container
		| &copy;
		span(v-once) {{ siteName }}
		span(v-once) {{ currentYear }},
		| developed by 
		a(href='#' target='_blank') dev

</template>

<script>
import {siteName} from '../../config'

export default {
	data () {
		return {
			siteName: siteName,
			currentYear: (new Date).getFullYear()
		}
	}
}
</script>
