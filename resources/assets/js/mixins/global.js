import {api} from '../config'

const mixin = {
    methods: {
		/*
		* Request
		*/
		formSend (type)
		{
			this.loading = true
			this.setErrors()

			axios.post(api[type], this.form)
			.then(res => {
				//this.$noty.success('Welcome back!')
				this.$emit('loginSuccess', res.data)
				this.$router.push({name: 'profile'})
			})
			.catch(err => {
				this.requestError(err.response)					
			})
			.finally(() => {
				this.loading = false
			})
		},

		/*
		* Errors
		*/
		getStateField (field)
		{
			if (this.veeFields[field] && (this.veeFields[field].dirty || this.veeFields[field].validated)) 
			{
				return !this.errors.has(field)
			}
			return null
		},
		requestError (res)
		{
			if (res.data) 
			{
				if (typeof res.data.error === 'string') 
				{
					// this.$noty.error(res.data.error)
					this.err = res.data.error
				} 
				else if (typeof res.data.error === 'object') 
				{
					this.err = null
					this.setErrors(res.data.error)
				}
			}
			else {
				// this.$noty.error(res.error)
				this.err = res.error
			}
		},
		setErrors (errors)
		{
			for (let item in errors) 
			{
				const field = 'form.'+ item
				const fieldError = this.$validator.fields.find({ name: field, scope: this.$options.scope })

				if (!fieldError) return

				for (let i in errors[item]) 
				{
					this.$validator.errors.add({
						id: fieldError.id,
						field: field,
						msg: errors[item][i],
						scope: this.$options.scope,
					})

					fieldError.setFlags({
						invalid: true,
						valid: false,
						validated: true,
					})
				}
			}
		},

		/*
		* Cookie
		*/
		getCookie (name) 
		{
			var matches = document.cookie.match(new RegExp(
				"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
			));
			return matches ? decodeURIComponent(matches[1]) : undefined
		},
		setCookie (name, value, options) 
		{
			options = options || {}

			var expires = options.expires

			if (typeof expires == "number" && expires) {
				var d = new Date();
				d.setTime(d.getTime() + expires * 1000)
				expires = options.expires = d
			}
			if (expires && expires.toUTCString) {
				options.expires = expires.toUTCString()
			}

			value = encodeURIComponent(value)

			var updatedCookie = name + "=" + value

			for (var propName in options) {
				updatedCookie += "; " + propName
				var propValue = options[propName]
				if (propValue !== true) {
					updatedCookie += "=" + propValue
				}
			}
			document.cookie = updatedCookie
		},
		deleteCookie (name) 
		{
			setCookie(name, "", {
				expires: -1
			})
		}
    },
}

export default mixin