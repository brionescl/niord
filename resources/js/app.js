require('./bootstrap')

window.Vue = require('vue')

import snotify from 'vue-snotify'

import BaseLoading from './components/BaseLoading'
import Expense from './components/Expense/Expense'
import { formatCurrency, formatDate } from './filters/format'

Vue.use(snotify)

Vue.filter('formatCurrency', formatCurrency)
Vue.filter('formatDate', formatDate)

Vue.component('BaseLoading', BaseLoading)

const app = new Vue({
    el: '#app',
    components: {
        Expense
    }
})
