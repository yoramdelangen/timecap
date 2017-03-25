<script>
    export default {
    	name: 'navigation'
    }
</script>

<template>
	<nav class="nav has-shadow">
		<div class="container">
			<div class="nav-left">
				<router-link class="nav-item is-tab" :to="{ name: 'dashboard' }">
					Dashboard
				</router-link>
				<router-link class="nav-item is-tab" :to="{ name: 'registrations' }">
					Registrations
				</router-link>
			</div>
			<div class="nav-right nav-menu">
				<a class="nav-item is-tab" href="/logout">
                    Logout
                </a>
			</div>
		</div>
	</nav>
</template>

<style scoped lang="sass">

</style>