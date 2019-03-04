<template lang='pug'>
.profile-avaload

	slot

	.custom-file
		input.custom-file-input#imageFile(
			type='file' 
			v-on:change='onFileChange'
		)
		label.custom-file-label(for='imageFile') 
			span(v-if='filename') {{ filename }}
			span(v-else) {{ title }}
			
		.invalid-feedback(v-if='false') Error

</template>

<style scoped lang='scss'>

</style>

<script>
import {api} from '../../config'

export default {
	data () 
	{
		return {
			title: 'Choose image',
			filename: null,
		}
	},
	methods: {
		onFileChange (e) 
		{
			let files = e.target.files || e.dataTransfer.files
			if (!files.length) return
			this.createImage(files[0])
		},
		createImage (file) 
		{
			let reader = new FileReader()
			let vm = this

			reader.onload = (e) => {
				vm.image = e.target.result

				this.filename = file.name

				this.upload()
			};

			reader.readAsDataURL(file)

		},
		upload () 
		{
			this.$emit('uploadSuccess', {image: this.image})
		}
	},
}
</script>