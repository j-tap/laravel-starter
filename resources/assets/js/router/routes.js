import Home from '../views/Home.vue'
import Signup from '../views/Register.vue'
import Signin from '../views/Login.vue'
import Profile from '../views/profile/Profile.vue'
import ProfileInfo from '../views/profile/ProfileInfo.vue'
import EditProfile from '../views/profile/EditProfile.vue'
import EditPassword from '../views/profile/EditPassword.vue'

export default [{
	path: '/',
	name: 'index',
	component: Home,
	meta: {}
}, {
	path: '/signup',
	name: 'signup',
	component: Signup,
	meta: {requiresGuest: true}
}, {
	path: '/signin',
	name: 'signin',
	component: Signin,
	meta: {requiresGuest: true}
}, {
	path: '/profile',
	component: Profile,
	children: [
		{
			path: '',
			name: 'profile',
			component: ProfileInfo,
			meta: {requiresAuth: true}
		}, {
			path: 'edit-profile',
			name: 'profile.editProfile',
			component: EditProfile,
			meta: {requiresAuth: true}
		}, {
			path: 'edit-password',
			name: 'profile.editPassword',
			component: EditPassword,
			meta: {requiresAuth: true}
		}, {
			path: '*',
			redirect: {
				name: 'profile'
			}
		}
	]
}]