import Vue from 'vue'
import store from '~/store'
import Form from '~/services/form'
import helper from '~/services/helper'
import loading from '~/services/loading'
import router from '~/router'
import App from '~/components/App'
import Vuetify from 'vuetify'
import axios from 'axios'
import VueTheMask from 'vue-the-mask'
import VueSweetalert2 from 'vue-sweetalert2'
import Toasted from 'vue-toasted';
import showError from '~/components/show-error'
import VueApexCharts from 'vue-apexcharts'
import VueFilterDateFormat from 'vue-filter-date-format'
import VueCurrencyFilter from 'vue-currency-filter'
import moment from 'moment'
import money from 'v-money'
import VuetifyNumberInput from '@jzolago/vuetify-number-input'
import currency from 'v-currency-field'
import Loading from 'vue-loading-overlay';


import '~/plugins'
import '~/components'

import 'vuetify/dist/vuetify.min.css' // Ensure you are using css-loader
import 'vue-loading-overlay/dist/vue-loading.css';


window.axios = axios
window.Form = Form
window.helper = helper
window.loading = loading
window._has = require('lodash/has')
window.Vue = Vue;


Vue.use(Toasted, {
  position: 'top-right',
  duration: 5000,
})
Vue.use(Loading, {color: 'blue'})
Vue.use(money, {precision: 4})
Vue.use(currency)
Vue.use(VueFilterDateFormat)
Vue.use(VueSweetalert2)
Vue.use(VueTheMask)
Vue.use(VuetifyNumberInput);
Vue.use(VueCurrencyFilter,
    {
      symbol : 'R$',
      thousandsSeparator: '.',
      fractionCount: 2,
      fractionSeparator: ',',
      symbolPosition: 'front',
      symbolSpacing: true
    })

Vue.use(Vuetify)

Vue.component('show-error',showError);
Vue.component('apexchart', VueApexCharts)

moment.locale('pt-br');

Vue.filter('formatDate', function(value) {
  if (value) {
    return moment(String(value)).format('DD/MM/YYYY')
  }
});

Vue.filter('formatDateWithTime', function(value) {
  if (value) {
    return moment(String(value)).format('DD/MM/YYYY') + ' às ' + moment(String(value)).format('HH:mm:ss')
  }
});

Vue.filter('formatDateToHuman', function(value) {
  if (value) {
      return moment(String(value), "").fromNow()
  }
});

Vue.config.productionTip = false

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('auth_token')

let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
}

/* eslint-disable no-new */
new Vue({
  store,
  router,
  ...App
})
