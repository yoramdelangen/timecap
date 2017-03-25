<script>
  import moment from 'moment'
  import {registration} from '../models'
  import Flatpickr from 'flatpickr'

  let defaults = {
    decorator: '',
    title: '',
    registered_on: moment().format('YYYY-MM-DD'),
  }

  export default {
    name: 'add-time-widget',

    props: {
      label: { required: true },
      placeholder: { default: 'e.g. 3h 40m' },
      buttonTitle: { default: 'Save' },
      isNegative: { type: Boolean, default: false },
      registration: { type: Object, default: () => defaults  },
      hideFooter: Boolean
    },

    computed: {
      getValidInput() {
        if (this.registration.decorator.length <= 1) {
          return null
        }

        // lowercase all input D->d H->h etc.
        let d = this.registration.decorator.toLowerCase()
          .match(/[0-9]{1,3}[d|h|m]{1}/g);

        if (!d || d.length == 0) {
          return false
        }

        return d
      },

      isValidInput() {
        if (this.getValidInput === null) {
          return null
        }

        return this.registration.decorator && this.registration.decorator.length > 0 && !! this.getValidInput
      }
    },

    data() {
      return {
        isDirty: false,
        negative: this.isNegative,
      }
    },

    methods: {
      setRegistration() {
        if (this.registration) {
          this.negative = (this.registration.register_value < 0)
        }
      },

      setOnlyProperValues(e) {
        // whenever the backspace, or enter is pressed or the focus is lost from the field
        // and the form is dirty it will reorganised the input
        if (((e.type == 'keyup' && [13,32].indexOf(e.keyCode) !== -1) || (e.type == 'blur')) && this.isDirty) {
          if (typeof this.getValidInput == 'object' && this.getValidInput) {
            this.registration.decorator = this.getValidInput.join(' ') + ' ';
            this.isDirty = false;
            return
          }
        }

        // do not anything if it was the first characater which was erased
        if (this.registration.decorator.length > 0) {
          this.isDirty = true;
          return
        }

        this.isDirty = false;
      },

      saveTime() {
        if (this.registration.id) {
          registration.update(
            this.registration.id,
            this.registration.decorator,
            this.registration.title,
            this.registration.registered_on,
            this.negative
          )
        } else {
          registration.create(
            this.registration.decorator,
            this.registration.title,
            this.registration.registered_on,
            this.negative
          )
          this.resetForm()
        }
      },

      resetForm() {
        this.registration = {
          decorator: '',
          title: '',
          registered_on: moment().format('YYYY-MM-DD'),
        }
      },

      getData() {
        return this
      }
    }
  }
</script>

<template>
  <div>
    <label class="label">
      Title
    </label>

    <div class="control">
      <input class="input" type="text" v-model="registration.title">
    </div>

    <div class="columns">
      <div class="column">
        <label class="label">
          {{ label }}
        </label>

        <div class="columns">
          <div class="column" style="padding-right: 8px">
            <span class="select">
              <select v-model="negative">
                <option :value="false">+</option>
                <option :value="true">-</option>
              </select>
            </span>
          </div>
          <div class="column is-three-quarters" style="padding-left: 0">
            <p class="control">
              <input class="input" type="text"
                v-model="registration.decorator"
                :class="{'is-danger': isDirty && !isValidInput}"
                :placeholder="placeholder"
                @keyup="setOnlyProperValues"
                @blur="setOnlyProperValues">
              <span v-if="isDirty && !isValidInput" class="help is-danger">Input is invalid</span>
            </p>
          </div>
        </div>
      </div>

      <div class="column is-one-third">
        <label class="label">
          Registered on
        </label>

        <div class="control">
          <Flatpickr class="input" :options="{}" v-model="registration.registered_on" />
        </div>
      </div>
    </div>

    <slot name="footer">
      <div class="control" v-if="!hideFooter">
        <button class="button is-primary" @click="saveTime" :disabled="!isValidInput">
          {{ buttonTitle }}
        </button>
      </div>
    </slot>
  </div>
</template>

<style scoped lang="sass">
</style>