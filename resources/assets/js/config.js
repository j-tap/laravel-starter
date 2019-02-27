const apiDomain = Laravel.apiDomain;
export const siteName = Laravel.siteName;

export const api = {
	register: apiDomain + '/register',
	login: apiDomain + '/login',
	verify: apiDomain + '/verify',
	currentUser: apiDomain + '/user',
	updateUserProfile: apiDomain + '/user/profile/update',
	updateUserPassword: apiDomain + '/user/password/update'
};