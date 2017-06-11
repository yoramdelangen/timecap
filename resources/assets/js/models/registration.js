import user from './user'

export default {
	registrations: [],

	retrieve() {
		const p = axios.get('/api/registrations');

		p.then(rsp => this.registrations = rsp.data);

		return p;
	},

	update(id, decorator, title, registeredOn, isNegative) {
		let total = this._totalRegistered(decorator)

		if (isNegative) {
			total = total * -1
		}

		let p = axios.put('/api/registrations/' + id, {
			'decorator': decorator,
			'register_value': total,
			'title': title,
			'registered_on': registeredOn
		});

		p.then(rsp => {
			user.setBalance(rsp.data.user.balance);
			user.setDecorator(rsp.data.user.decorator);
		})

		p.catch(err => {
			console.log(err)
		});

		return p;
	},


	create(decorator, title, registeredOn, isNegative) {
		let total = this._totalRegistered(decorator)

		if (isNegative) {
			total = total * -1
		}

		let p = axios.post('/api/registrations', {
			'decorator': decorator,
			'register_value': total,
			'title': title,
			'registered_on': registeredOn
		});

		p.then(rsp => {
			this.registrations.push(rsp.data)

			user.setBalance(rsp.data.user.balance)
			user.setDecorator(rsp.data.user.decorator)
		})

		p.catch(err => {
			console.log(err)
		});

		return p;
	},

	all() {
		return this.registrations;
	},

	_totalRegistered(input) {
		// for every timeInput element
		let m = 0;
		let dt = user.get('time_notation_per_day') || 8;

		_.each(_.filter(input.split(' ')), t => {
			let b = t.match(/[0-9]+|[a-zA-Z]+/g);
			let v = parseInt(_.head(b), 0);

			switch(_.last(b)) {
				case 'd': m = m + ((v * dt) * 60); break;
				case 'h': m = m + (v * 60); break;
				default: m = m + v; break;
			}
		});

		return m;
	}
}