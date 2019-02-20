<template lang='pug'>
section.page
	app-header

	transition(name='fade' mode='out-in')
		router-view

	app-footer

</template>

<script>
import AppHeader from './components/layout/AppHeader.vue';
import AppFooter from './components/layout/AppFooter.vue';

export default {
	components: {
		'app-header': AppHeader,
		'app-footer': AppFooter
	}
}
</script>
