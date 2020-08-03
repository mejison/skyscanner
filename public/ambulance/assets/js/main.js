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
      from: '',
      to: '',
      departure_date: '',
      return_date: '',
      class: '',
      passengers: 0,
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
      commit('setFlights', [])
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

    mounted: function () {
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
      validate: function (field) {
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
        options: {
          additional_service: [],
          journey_type: '',
        },
        currentFlight: false,
        price_for_additional_service: 10,
        filter: {
          from: '',
          to: '',
          passengers: '',
          arrival: '',
          departure: '',
          class: 'Economy'
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

      this.filter.passengers = store.state[store.state.type].passengers
      this.filter.class = store.state[store.state.type].class
      this.filter.from = store.state[store.state.type].from
      this.filter.to = store.state[store.state.type].to
      this.filter.departure = store.state[store.state.type].departure_date
      this.filter.arrival = store.state[store.state.type].return_date
    },

    mounted: function () {
      this.getFlights();
    },

    computed: {
      finalPrice: function () {
        return this.totalPrice + (this.options.additional_service.length * this.price_for_additional_service);
      },
      bookingLink: function () {
        return this.currentFlight ? this.currentFlight.PricingOptions[0].DeeplinkUrl : '/'
      },
      totalPrice: function () {
        return this.currentFlight ? this.currentFlight.PricingOptions[0].Price : 0
      },
      locationFrom: function () {
        return store.state[store.state.type].from
      },
      locationTo: function () {
        return store.state[store.state.type].to
      },
      bookingType: function () {
        return store.state.type
      },
      passengers: function () {
        return store.state[store.state.type].passengers
      },
      currency: function () {
        return this.flights.Currencies[0]
      },
      fromAirPort: function () {
        let [airport, country] = store.state[store.state.type].from.split(',')
        return airport
      },
      toAirPort: function () {
        let [airport, country] = store.state[store.state.type].to.split(',')
        return airport
      },
      classFly: function () {
        return store.state[store.state.type].class
      },
      flights: function () {
        return store.state.flights
      }
    },

    methods: {
      parseMinutes: function (x) {
        hours = Math.floor(x / 60);
        minutes = x % 60;

        if (x > 60) {
          return `${hours}h ` + (minutes ? `${minutes}m` : '')
        }
        return `${x}m`
      },
      onSearchResults() {
        store.commit('setState', {
          name: 'passengers',
          value: this.filter.passengers
        })

        store.commit('setState', {
          name: 'class',
          value: this.filter.class
        })

        store.commit('setState', {
          name: 'return_date',
          value: this.filter.arrival
        })


        store.commit('setState', {
          name: 'departure_date',
          value: this.filter.departure
        })

        store.commit('setState', {
          name: 'from',
          value: this.filter.from
        })

        store.commit('setState', {
          name: 'to',
          value: this.filter.to
        })

        store.commit('setState', {
          name: 'to',
          value: this.filter.to
        })

        this.$router.push({ path: '/results', query: { ...store.state[store.state.type], type: store.state.type } })
        this.getFlights();
      },
      getTimeFromFormat: function (date) {
        let [dataTmp, time] = date.split('T')
        return `${dataTmp} ${time}`
      },
      getStops: function (stops) {
        return stops.map((place_id) => {
          return this.getPlaceById(place_id)
        }).map(function (item) {
          return `${item.Type}/${item.Name}`
        })
      },
      getPlaceById: function (Id) {
        return this.flights.Places.find(function (item) {
          return item.Id == Id
        })
      },
      onView: function (flight) {
        this.currentFlight = flight
      },
      getLedById: function (LegId) {
        return this.flights.Legs.find(function (item) {
          return item.Id == LegId
        })
      },
      getCarrierById: function (id) {
        return this.flights.Carriers.find(function (item) {
          return item.Id == id
        })
      },
      onChangeFilter: function () {

      },
      getFlights: function () {
        $('.divWrap').prepend('<span id="recha">Preparing your results, please wait...</span>');
        store.dispatch('getFlights', { ...store.state[store.state.type], type: store.state.type, ...this.filters })
      },
      onClickPayNow: function () {
        this.payWithPaystack();
      },
      payWithPaystack: function () {
        let handler = PaystackPop.setup({
          key: 'pk_test_c41b28101f0051385175eea54be0a1b34b5d15e5',
          email: 'customer@email.com',
          amount: this.finalPrice * 100,
          metadata: {
            custom_fields: {
              from: this.locationFrom,
              to: this.locationTo,
              class: this.classFly,
              flightCarrier: this.currentFlight
            }
          },
          callback: function (response) {
            const data = {
              from: store.state[store.state.type].from,
              to: store.state[store.state.type].to,
              passengers: store.state[store.state.type].passengers,
              departure_date: store.state[store.state.type].departure_date,
            }

            if (store.state[store.state.type].return_date) {
              data.return_date = store.state[store.state.type].return_date
            }

            axios.post("/payment.php", { reference: response.reference, ...data, ...this.options }).then(({ data }) => {

              if ([200].indexOf(data.code) + 1) {
                toastr.success(data.message);

              }
            })
          },
          onClose: function () {
            toastr.error('Transaction cancelled')
          }
        });
        handler.openIframe();
      },
      onClickGenerateInvoice: function () {
        const data = {
          from: store.state[store.state.type].from,
          to: store.state[store.state.type].to,
          passengers: store.state[store.state.type].passengers,
          departure_date: store.state[store.state.type].departure_date,
        }

        if (store.state[store.state.type].return_date) {
          data.return_date = store.state[store.state.type].return_date
        }

        axios.post("/invoice-generate.php", {
          ...data, ...this.options, flight: {
            departure: this.getLedById(this.currentFlight.InboundLegId).Departure,
            duration: this.parseMinutes(this.getLedById(this.currentFlight.InboundLegId).Duration),
            arrival: this.getLedById(this.currentFlight.InboundLegId).Arrival,
            carrier: this.getCarrierById(this.getLedById(this.currentFlight.InboundLegId).Carriers[0]),
            price: this.totalPrice
          }, final_price: this.finalPrice
        }).then(({ data }) => {
          let a = document.createElement('a')
          a.href = data.data.pdf_link
          a.target = 'black'
          a.click()
        })
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
