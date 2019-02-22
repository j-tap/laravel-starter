<template lang='pug'>
.container
	.row
		.col-12.col-md-6.col-lg-8
			.page-header
				h1.display-4 Registration

</template>

<script>
export default {
    components: {
        
    },
    methods: {
        registrationSuccess(data) {
            console.log('registration success')
        }
    }
}
</script>
