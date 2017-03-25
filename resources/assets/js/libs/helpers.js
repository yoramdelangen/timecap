import user from '../models/user'

export default {
	formatMinutes(m) {
		let days = Math.trunc(m / (60 * user.time_notation_per_day));
		let hours = Math.trunc(m / 60);
		let minutes = (m % 60);

		let parts = [];
		if (days > 0) {
			parts.push(days +'d');
		}

		if (hours > 0) {
			parts.push(hours +'h');
		}

		if (_.isNaN(minutes)) {
			minutes = 0;
		}

		parts.push(minutes + 'm');

		return parts.join(' ');
	}
}