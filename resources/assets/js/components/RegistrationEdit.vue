<script>
	import Modal from '../core/Modal.vue'
	import Widget from '../core/Widget.vue'
	import {registration} from '../models'

    export default {
		name: 'registrations-edit',

		computed: {
			registration() {
				return this.$root.registrations
					.filter(registration => registration.id == this.$route.params.id)[0]
			},

			isNegative() {
				return this.registration && this.registration.register_value < 0
			}
		},

		components: {
			Modal,
			Widget
		},

		methods: {
			saveTime() {
				registration.update(
					this.registration.id,
					this.registration.decorator,
					this.registration.title,
					this.registration.registered_on,
					this.isNegative
				)
				.then(rsp => {
					this.$toast('Registration successfully updated', {
						className: 'notification is-success'
					})

					this.$router.go(-1)
				})
				.catch(err => {
					this.$toast('Woops someting went wrong: '+ err, {
						className: 'notification is-danger'
					})
				})
			},
		}
    }
</script>

<template>
	<modal title="Registration edit">
		<widget label="Time edit" :registration="registration" :hide-footer="true">
		</widget>

		<div slot="footer" class="modal-card-foot">
			<button class="button is-primary" @click="saveTime">
				Save
			</button>

			<router-link :to="{ name: 'registrations' }" exact class="button">
				Cancel
			</router-link>
		</div>
	</modal>
</template>

<style scoped lang="sass">

</style>