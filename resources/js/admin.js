import Vue from 'vue'
import App from './admin/App.vue'
import router from './admin/router'
import store from './admin/store'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/zh-TW'

Vue.config.productionTip = false

Vue.use(ElementUI , { locale })

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
