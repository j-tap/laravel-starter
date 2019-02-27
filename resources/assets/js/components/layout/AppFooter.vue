<template lang='pug'>
footer.footer(v-once)
	hr
	.container
		| &copy;
		span {{siteName}} 2018-{{currentYear}}

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

<style lang='scss' scoped>

</style>
