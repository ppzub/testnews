import Vue from "vue";
import App from "./App.vue";
import VueRouter from 'vue-router'

Vue.use(VueRouter)

// Create a root instance for each block
const vueElements = document.getElementsByClassName("vue-calendar-block");
const count = vueElements.length;
const router = new VueRouter({
  mode: 'history',
});
// Loop through each block
for (let i = 0; i < count; i++) {
  // Create a vue instance
  new Vue({
    el: vueElements[0],
    router,
    render: h => h(App)
  });
}
