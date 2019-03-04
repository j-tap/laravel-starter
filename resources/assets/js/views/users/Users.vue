<template lang='pug'>
.container
	h1.display-4(v-once) Users

	transition(name='fade')
		div(v-if='loading')
			.text-center.p-5 Wait...
	
	transition(name='fade')
		div(v-if='!loading')
			ul.list-group(v-if='users.length > 0')
				li.list-group-item.list-group-item-action(v-for='user in users')
					a(:href=`'users/' + user.id`)
						.d-flex.w-100.justify-content-between
							h5.mb-1 {{ user.name }}
							small {{ user.created_at }}

			p.text-center.text-warning(v-else) Users not found

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
