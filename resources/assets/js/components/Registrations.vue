<script>
	import { registration } from '../models'
    export default {
    	name: 'registrations',

    	computed: {
    		registrations() {
    			return this.$root.registrations.sort('registered_on').reverse()
    		}
    	},

    	methods: {
    		addSubstractClass(r) {
    			if (r.register_value < 0) {
    				return 'fa-minus'
    			}

    			return 'fa-plus'
    		},

    		timeTypeClass(r) {
    			if (r.register_value < 0) {
    				return 'is-danger'
    			}

    			return 'is-success'
    		}
    	}
    }
</script>

<template>
	<div class="section">
		<div class="container">
			<div class="panel" style="overflow: hidden;">
				<table class="table" style="margin-bottom: 0;">
					<thead>
						<tr>
							<th>Title</th>
							<th>Time</th>
							<th></th>
							<th width="200">Registered</th>
							<th width="50"></th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="r in registrations">
							<td v-text="r.title"></td>
							<td v-text="r.decorator"></td>
							<td>
								<div class="button is-small" :class="timeTypeClass(r)">
									<span class="icon is-small" style="margin-left: 0;">
										<i class="fa" :class="addSubstractClass(r)"></i>
									</span>
								</div>
							</td>
							<td v-text="r.registered_on"></td>
							<td>
								<router-link class="button is-light is-small"
									:to="{ name: 'registrations.name', params: { id: r.id } }">
									edit
								</router-link>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<router-view></router-view>
	</div>
</template>

<style scoped lang="sass">

</style>