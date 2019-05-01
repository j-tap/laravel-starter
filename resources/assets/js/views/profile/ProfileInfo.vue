<template lang='pug'>
div
	h3.mb-4 {{user.name}}'s Profile
	.card
		.row.no-gutters
			.col-md-4
				img.card-img(:src='user.ava' :alt='user.name')

			.col-md-8
				ul.list-group.list-group-flush
					li.list-group-item Name
						p.lead {{user.name}}

					li.list-group-item Email
						p.lead {{user.email}}
</template>

<script>
import {mapState} from 'vuex'

export default {
	computed: mapState({
		user: state => state.auth
	})
}
</script>
