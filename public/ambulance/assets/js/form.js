const Vue = window.Vue
const Vuex = window.Vuex
const VueRouter = window.VueRouter
const axios = window.axios

Vue.use(Vuex);

const getComponent = function (name) {
  return axios.get("/components/" + name + '.php').then(function (res) {
    return Promise.resolve(res.data)
  })
}

let loaded = 0;
let components = ['form'];

let numeral = window.numeral;

const global = {
  state: {
  
  },

  mutations: {
    
  },

  actions: {
    
  }
}

const store = new Vuex.Store(global)

const mixins = {
  'form': {

  },
}

for (let element of components) {
  getComponent(element).then(function (html) {
    window[element] = { template: html, ...mixins[element] }
    loaded ++

    if (loaded == components.length) {
      init();
    }
  })
}


function init() {
  $('#recha').remove();

  const routes = [
    { path: '', component: window['form'] },
  ]

  const router = new VueRouter({
    routes
  })

  new Vue({
    store,
    router,
  }).$mount('#body')
}
