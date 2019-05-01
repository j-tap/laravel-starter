/* Mutation Types */
export const SET_USER = 'SET_USER'
export const UNSET_USER = 'UNSET_USER'

/* Initial State */
const initialState = {
	id: null,
	name: null,
	email: null,
	ava: null
};

/* Mutations */
const mutations = {
	[SET_USER](state, payload) {
		state.id = payload.user.id
		state.name = payload.user.name
		state.email = payload.user.email
		state.ava = payload.user.ava
	},
	[UNSET_USER](state, payload) {
		state.id = null
		state.name = null
		state.email = null
		state.ava = null
	}
};

/* Actions */
const actions = {
	setAuthUser: (context, user) => {
		context.commit(SET_USER, {user})
	},
	unsetAuthUser: (context) => {
		context.commit(UNSET_USER);
	}
};

/* Getters */
const getters = {
	isLoggedIn: (state) => {
		return !!(state.id && state.name && state.email && state.ava)
	}
};

/* Export the module */
export default {
	state: initialState,
	mutations,
	actions,
	getters
}