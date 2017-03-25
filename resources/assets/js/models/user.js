export default {
	user: {},

	fetchUser() {
		const p = axios.get('/api/user')

		p.then(rsp => this.user = rsp.data)

		return p
	},

	get(key) {
		if (key) {
			return this.user[key]
		}

		return this.user
	},

	setBalance(u) {
		this.user.current_balance = u
	},

	setDecorator(d) {
		this.user.current_decorator = d
	}
}