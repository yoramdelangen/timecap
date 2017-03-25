<script>
    import {registration, user} from '../models'
    import helpers from '../libs/helpers'
    import AddTimeWidget from '../core/Widget.vue'

    export default {
        name: 'dashboard',

        components: {
            AddTimeWidget
        },

        computed: {
            registrations() {
                return this.$root.registrations
                    ? this.$root.registrations
                    : [{register_value: 0}];
            },
            showFiveRegistrations() {
                return _.orderBy(this.registrations, 'created_at', 'desc').splice(0, 5);
            },
            averageOvertime() {
                return helpers.formatMinutes(
                    _.round(_.sumBy(this.registrations, 'register_value') / this.registrations.length)
                );
            },
            timeOff() {
                return helpers.formatMinutes(
                    _.sum(
                        _.map(this.registrations, 'register_value')
                        .filter(reg => _.startsWith(reg, '-'))
                    ) * -1
                );
            },
            user() {
                return this.$root.user;
            }
        }
    }
</script>

<template>
    <div class="section">
        <div class="container">
            <div class="columns" style="margin-bottom: 40px;">
                <div class="column">
                    <nav class="level">
                        <div class="level-item has-text-centered">
                            <p class="heading">Worked hours</p>
                            <p class="title">{{ user.current_decorator }}</p>
                        </div>
                        <div class="level-item has-text-centered">
                            <p class="heading">Took time off</p>
                            <p class="title">{{ timeOff }}</p>
                        </div>
                        <div class="level-item has-text-centered">
                            <p class="heading">Registers made</p>
                            <p class="title">{{ registrations.length || 0 }}</p>
                        </div>
                        <div class="level-item has-text-centered">
                            <p class="heading">Average overtime</p>
                            <p class="title">{{ averageOvertime }}</p>
                        </div>
                    </nav>
                </div>
            </div>

            <div class="columns">
                <div class="column is-half">
                    <div class="panel">
                        <h3 class="panel-heading">5 latest registers</h3>
                        <div class="panel-block" v-for="registration in showFiveRegistrations">
                            <div class="level">
                                <div class="level-left">
                                    <div class="level-item">
                                        {{ registration.title }}
                                    </div>
                                </div>
                                <div class="level-right">
                                    <div class="level-item">
                                        {{ registration.decorator.replace(/^\+/, '') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="column is-half">
                    <div class="panel">
                        <h4 class="panel-heading">
                            Add overtime
                        </h4>

                        <div class="panel-block">
                            <add-time-widget label="How much overtime?"></add-time-widget>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="sass">

</style>