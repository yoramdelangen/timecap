<script>
    export default {
		props: ['title'],

		mounted() {

		}
    }
</script>

<template>
	<div class="modal is-active">
		<div class="modal-background"></div>
		<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">{{ title }}</p>
			</header>

			<section class="modal-card-body">
				<slot></slot>
			</section>

			<slot v-if="$slots.footer && $slots.footer.length > 0" class="modal-card-foot" name="footer"></slot>
			<div v-if="!$slots.footer || $slots.footer.length == 0" class="modal-card-foot"></div>
		</div>
	</div>
</template>

<style scoped lang="sass">

</style>