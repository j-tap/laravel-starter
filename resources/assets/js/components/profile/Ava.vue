<template lang='pug'>
.profile-ava
	img(:src='image' alt=' ')

</template>

<style scoped lang='scss'>
.profile-ava {
	margin-bottom: 15px;

		img {
			display: block;
			max-height: 160px;
			width: auto;
		}
}
</style>

<script>
export default {
	props: {
		image: { type: String }
	},
}
</script>