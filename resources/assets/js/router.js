export default [
	{ path: '/dashboard', name: 'dashboard', component: require('./components/Dashboard.vue') },
	{ path: '/registrations', name: 'registrations', component: require('./components/Registrations.vue'), children: [
		{ path: '/registrations/:id/edit', name: 'registrations.name', component: require('./components/RegistrationEdit.vue') }
	]},
	{ path: '/', redirect: { name: 'dashboard'} }
];