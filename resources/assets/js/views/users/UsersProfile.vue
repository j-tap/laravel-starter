<template lang='pug'>
.container
	h1.display-4(v-once) User profile

	.text-center.p-5(v-if='loading') Wait...
	
	div(v-else)
		p
			router-link(:to='{name: "users"}') <- All users

		p.float-right.text-warning(v-if='user.is_verified==0') Not confirmed
		h2 {{ user.name }}
		
		.mb-2
			a(:href=`'mailto:' + user.email`) {{ user.email }}
		.mb-2
			small 
				span.text-muted Register: 
				| {{ user.created_at }}
		.mb-2
			small 
				span.text-muted Last visit: 
				| {{ user.updated_at }}

		button.btn.btn-info(v-on:click='listenForBroadcast') Message

</template>

<script>
import {api} from '../../config'

export default {
	data () {
		return {
			loading: true,
			id: null,
			user: {},
		}
	},
	methods: {
		get ()
		{
			this.loading = true
			axios.post(api.usersProfile, {id: this.id})
				.then(res => {
					this.loading = false
					this.user = res.data.user
				})
				.catch(err => {
					this.loading = false
				});
		},
	},
	mounted () {
		this.id = this.$route.params.id
		this.get()
	}
}
</script>
