<template lang='pug'>
.container
	h1.display-4(v-once) Verify user
	h3 {{title}}

</template>

<script>
import {api} from '../config'

export default {
	data () {
		return {
			title: null,
			code: null,
			error: null,
		}
	},
	methods: {
		verify ()
		{
			this.loading = true;
			axios.post(api.verify, {code: this.code})
				.then(res => {
					this.loading = false;
					this.$noty.success(res.data.message);
					this.$router.push({name: 'signin'});
				})
				.catch(err => {
					const res = err.response.data;
					this.$noty.error(res.error);
					this.loading = false;
				});
		},
	},
	mounted () {
		this.code = this.$route.params.code
		this.verify()
	}
}
</script>
