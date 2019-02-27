<template lang='pug'>
.container
	h1.display-4(v-once) Users

	.text-center.p-5(v-if='loading') Wait...
	
	ul.list-group(v-else)
		li.list-group-item.list-group-item-action(v-for='user in users')
			a(:href=`'users/' + user.id`)
				.d-flex.w-100.justify-content-between
					h5.mb-1 {{ user.name }}
					small {{ user.created_at }}

</template>

<script>
import {api} from '../../config'

export default {
	data () {
		return {
			loading: true,
			users: [],
		}
	},
	methods: {
		get ()
		{
			axios.get(api.users)
				.then(res => {
					this.loading = false
					this.users = res.data.users
				})
				.catch(err => {
					this.loading = false
				});
		}
	},
	mounted () {
		this.loading = true
		this.get()
	}
}
</script>
