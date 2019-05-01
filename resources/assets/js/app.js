import Vue from 'vue'
import VueNoty from 'vuejs-noty'
import axios from 'axios'
import VueI18n from 'vue-i18n'
import BootstrapVue from 'bootstrap-vue'
import VeeValidate from 'vee-validate'
import validationMessages from 'vee-validate/dist/locale/ru'

window.axios = axios

Vue.use(BootstrapVue)
Vue.use(VueNoty, {
	progressBar: false,
	layout: 'topRight',
	theme: 'bootstrap-v4',
	timeout: 4000
})
Vue.use(VueI18n)

const i18n = new VueI18n()
i18n.locale = 'ru' // set a default locale (without it, it won't work)

Vue.use(VeeValidate, {
	i18nRootKey: 'validations',
	i18n,
	dictionary: {
		ru: validationMessages
	},
	events: 'input|blur',
	delay: 100,
	inject: true,
	// Important to name this something other than 'fields'
	fieldsBagName: 'veeFields'
})

import router from './router/router'
import store from './store/index'
import App from './App.vue'
import jwtToken from './helpers/jwt-token'


import global from './mixins/global'

Vue.mixin(global);

axios.interceptors.request.use(config => {
	config.headers['X-CSRF-TOKEN'] = window.Laravel.csrfToken
	config.headers['X-Requested-With'] = 'XMLHttpRequest'

	if (jwtToken.getToken()) {
		config.headers['Authorization'] = 'Bearer ' + jwtToken.getToken()
	}

	return config
}, error => {
	return Promise.reject(error)
});

axios.interceptors.response.use(response => {
	return response
}, error => {
	let errorResponseData = error.response.data

	const errors = ['token_invalid', 'token_expired', 'token_not_provided']

	if (errorResponseData.error && errors.includes(errorResponseData.error)) {
		store.dispatch('unsetAuthUser')
			.then(() => {
				jwtToken.removeToken()
				router.push({name: 'signin'})
			})
	}

	return Promise.reject(error)
});

Vue.component('app', App)

const app = new Vue({
	router,
	store
}).$mount('#app')
