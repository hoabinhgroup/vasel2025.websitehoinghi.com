require("./bootstrap");

import Vue from "vue";

Vue.component("notification", require("./components/Notification.vue").default);
Vue.component("visit", require("./components/Visit.vue").default);
Vue.component(
  "customers-assign-services",
  require("./components/customers/CustomerAssignServices.vue").default
);

Vue.component("vue-suggestion", VueSuggestion.VueSuggestion);

import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import * as VeeValidate from "vee-validate";
import { Tabs, Tab } from "vue-tabs-component";
import VModal from "vue-js-modal";
import Popover from "vue-js-popover";
import Nl2br from "vue-nl2br";

const options = {
  position: "top-right",
  timeout: 5000,
  closeOnClick: true,
  pauseOnFocusLoss: true,
  pauseOnHover: true,
  draggable: true,
  draggablePercent: 0.46,
  showCloseButtonOnHover: false,
  hideProgressBar: true,
  closeButton: "button",
  icon: true,
  rtl: false,
};

Vue.use(Toast, options);
Vue.use(VeeValidate);
Vue.use(VModal, { dialog: true });
Vue.use(Popover);
Vue.component("tabs", Tabs);
Vue.component("tab", Tab);
Vue.component("nl2br", Nl2br);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
  el: "#app",
});

const appWrapper = new Vue({
  el: "#ajaxModalContent",
});
