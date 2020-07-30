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
let components = ['search-flights', 'search-results'];

const global = {
  state: {
    type: 'return',
    return: {
      from: 'EDI, United Kingdom',
      to: 'LHR, United Kingdom',
      departure_date: '07/31/2020',
      return_date: '08/13/2020',
      class: 'Economy',
      passengers: 1,
    },
    oneway: {
      from: '',
      to: '',
      departure_date: '',
      class: '',
      passengers: 0,
    },
    flights: [],
  },

  mutations: {
    setType: function (state, type) {
      state.type = type
    },
    setState: function (state, data) {
      state[state.type][data.name] = data.value
    },
    setFlights: function (state, data) {
      state.flights = data
    }
  },

  actions: {
    getFlights: function ({ commit }, params) {
      return axios.get(`/get-flights.php`, {
        params
      }).then(function (res) {
        commit('setFlights', res.data)
        $('#recha').remove();
      }).catch(function (error) {
        let { data } = error.response
        toastr.error(data.message)
        $('#recha').remove();
      })
    }
  }
}

const store = new Vuex.Store(global)

const mixins = {
  'search-flights': {

    mounted() {
      for (let field of this.fields[store.state.type]) {
        if (this.$refs[`${store.state.type}.${field}`] && store.state[store.state.type][field]) [
          this.$refs[`${store.state.type}.${field}`].value = store.state[store.state.type][field]
        ]
      }
    },

    data: function () {
      return {
        fields: {
          return: [
            'from',
            'to',
            'departure_date',
            'return_date',
            'class',
            'passengers',
          ],
          oneway: [
            'from',
            'to',
            'departure_date',
            'class',
            'passengers',
          ]
        }
      }
    },

    methods: {
      onClickTab: function (type) {
        store.commit('setType', type)
      },
      onSearch: function () {
        let element;
        let valid = 0;
        for (let field of this.fields[store.state.type]) {
          element = this.$refs[`${store.state.type}.${field}`]
          if (this.validate(element)) {
            valid++
          }
        }

        if (valid == this.fields[store.state.type].length) {
          this.$router.push({ path: '/results', query: { ...store.state[store.state.type], type: store.state.type } })
        }
      },
      validate(field) {
        field.classList.remove('incorrect')
        if (!field.value) {
          field.classList.add('incorrect')
          return false
        }
        return true
      },
      onChange: function (name, event) {
        let element = this.$refs[`${store.state.type}.${name}`]
        this.validate(element)

        store.commit('setState', {
          name: name,
          value: event.target.value
        })
      }
    }
  },
  'search-results': {
    data: function () {
      return {
        filters: {
          additional_service: [],
          journey_type: '',
        }
      }
    },

    created: function () {
      let { query } = this.$route
      store.commit('setType', query.type)
      for (let param in query) {
        store.commit('setState', {
          name: param,
          value: query[param]
        })
      }
    },

    mounted: function () {
      this.getFlights();
    },

    computed: {
      currency() {
        return this.flights.Currencies[0]
      },
      fromAirPort() {
        let [airport, country] = store.state[store.state.type].from.split(',')
        return airport
      },
      toAirPort() {
        let [airport, country] = store.state[store.state.type].to.split(',')
        return airport
      },
      classFly() {
        return store.state[store.state.type].class
      },
      flights: function () {
        return store.state.flights
      }
    },

    methods: {
      parseMinutes(x) {
        hours = Math.floor(x / 60);
        minutes = x % 60;

        if (x > 60) {
          return `${hours}h ` + (minutes ? `${minutes}m` : '')
        }
        return `${x}m`
      },
      getTimeFromFormat(date) {
        let [dataTmp, time] = date.split('T')
        return `${dataTmp} ${time}`
      },
      getStops(stops) {
        return stops.map((place_id) => {
          return this.getPlaceById(place_id)
        }).map(function (item) {
          return `${item.Type}/${item.Name}`
        })
      },
      getPlaceById(Id) {
        return this.flights.Places.find(function (item) {
          return item.Id == Id
        })
      },
      onView(flight) {
        console.log(flight)
      },
      getLedById(LegId) {
        return this.flights.Legs.find(function (item) {
          return item.Id == LegId
        })
      },
      getCarrierById(id) {
        return this.flights.Carriers.find(function (item) {
          return item.Id == id
        })
      },
      onChangeFilter() {
        this.getFlights();
      },
      getFlights: function () {
        $('.divWrap').prepend('<span id="recha">Preparing your results, please wait...</span>');
        store.dispatch('getFlights', { ...store.state[store.state.type], type: store.state.type, ...this.filters })
      }
    }
  }
}

for (let element of components) {
  getComponent(element).then(function (html) {
    window[element] = { template: html, ...mixins[element] }
    loaded++

    if (loaded == components.length) {
      init();
    }
  })
}


function init() {
  const routes = [
    { path: '/', component: window['search-flights'] },
    { path: '/results', component: window['search-results'] }
  ]

  const router = new VueRouter({
    routes
  })

  new Vue({
    store,
    router,
  }).$mount('#body')
}
