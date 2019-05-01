import Home from '../views/Home.vue'
import Signup from '../views/Register.vue'
import Signin from '../views/Login.vue'
import Verify from '../views/Verify.vue'
import Profile from '../views/profile/Profile.vue'
import Users from '../views/users/Users.vue'
import UsersProfile from '../views/users/UsersProfile.vue'
import ProfileInfo from '../views/profile/ProfileInfo.vue'
import EditProfile from '../views/profile/EditProfile.vue'
import EditPassword from '../views/profile/EditPassword.vue'
import PageNotFound from '../views/PageNotFound.vue'

export default [{
	path: '/',
	name: 'index',
	component: Home,
	meta: {}
}, 
{
	path: '/signup',
	name: 'signup',
	component: Signup,
	meta: {requiresGuest: true}
}, 
{
	path: '/signin',
	name: 'signin',
	component: Signin,
	meta: {requiresGuest: true}
}, 
{
	path: '/verify/:code',
	name: 'verify',
	component: Verify,
	meta: {requiresGuest: true}
}, 
{
	path: '/users',
	name: 'users',
	component: Users,
	meta: {requiresAuth: true}
}, 
{
	path: '/users/:id',
	name: 'users-profile',
	component: UsersProfile,
	meta: {requiresAuth: true}
}, 
{
	path: '/profile',
	component: Profile,
	children: [
		{
			path: '',
			name: 'profile',
			component: ProfileInfo,
			meta: {requiresAuth: true}
		}, 
		{
			path: 'edit-profile',
			name: 'profile.editProfile',
			component: EditProfile,
			meta: {requiresAuth: true}
		}, 
		{
			path: 'edit-password',
			name: 'profile.editPassword',
			component: EditPassword,
			meta: {requiresAuth: true}
		}, 
		{
			path: '*',
			redirect: {
				name: 'profile'
			}
		}
	]
}, 
{
	path: '*', 
	component: PageNotFound
}]