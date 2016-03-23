import Vue from 'vue'
import NavBar from './partials/navbar.vue'
import Modal from './partials/modal.vue'
import DateTime from './partials/DateTime.vue'
import ComposerPanel from './partials/composepanel.vue'
import PendingPost from './partials/pendingpost.vue'
import vSelect from 'vue-select'

export default {
  registerAllGlobalComponents(){
    Vue.component('navbar',NavBar);
    Vue.component('v-modal',Modal);
    Vue.component('v-timepicker',DateTime);
    Vue.component('v-select',vSelect);
    Vue.component('composepanel',ComposerPanel);
    Vue.component('pending',PendingPost);
  }
}
