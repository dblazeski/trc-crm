import Vue from 'vue'
import VueAxios from 'vue-axios'
import axios from 'axios'

window.Vue = Vue
window.EventBus = new Vue()
Vue.use(VueAxios, axios)

Vue.component('resource-upload', require('./vue/components/ResourceUpload.vue').default)
Vue.component('error-list', require('./vue/components/ErrorList.vue').default)
Vue.component('admin-dashboard-view', require('./vue/views/AdminDashboardView.vue').default)
Vue.component('home-view', require('./vue/views/HomeView.vue').default)

Vue.prototype.$ApiUrl = document.body.getAttribute('data-api-url');

const app = new Vue({
    el: '#app'
});

// Bind to window as webpack doesn't expose the functions defined here globally
window.dispatchVueEvent = (event, data = null) => EventBus.$emit(event, data)
