<section id="s">
    <section class="s_left">
        <div id="title">
            <h1>Additional Services</h1>
        </div>
        <ul class="filter-additional-services">
            <li><label><input name="services" value="Wheelchair" type="checkbox" v-model="filters.additional_service" v-on:change="onChangeFilter">Wheelchair</label></li>
            <li><label><input name="services" value="Ground Ambulance" type="checkbox" v-model="filters.additional_service"  v-on:change="onChangeFilter">Ground Ambulance</label></li>
            <li><label><input name="services" value="Ventilator" type="checkbox" v-model="filters.additional_service" v-on:change="onChangeFilter">Ventilator</label></li>
            <li><label><input name="services" value="Incubator" type="checkbox" v-model="filters.additional_service" v-on:change="onChangeFilter">Incubator</label></li>
            <li><label><input name="services" value="Oxygen" type="checkbox" v-model="filters.additional_service" v-on:change="onChangeFilter">Oxygen</label></li>
            <li><label><input name="services" value="External Pacemaker" type="checkbox" v-model="filters.additional_service" v-on:change="onChangeFilter">External Pacemaker</label></li>
            <li><label><input name="services" value="Drainages" type="checkbox" v-model="filters.additional_service" v-on:change="onChangeFilter">Drainages</label></li>
            <li><label><input name="services" value="Cathether" type="checkbox" v-model="filters.additional_service" v-on:change="onChangeFilter">Catheter</label></li>
            <li><label><input name="services" value="Intubator" type="checkbox" v-model="filters.additional_service" v-on:change="onChangeFilter">Intubator</label></li>
            <li><label><input name="services" value="Traction Device" type="checkbox" v-model="filters.additional_service" v-on:change="onChangeFilter">Traction Device</label></li>
        </ul>
    </section>
    <section class="s_center">
        <div class="flights" v-if="flights.Itineraries && flights.Itineraries.length">
            <div class="item-flight" v-for="(flight, index) in flights.Itineraries" :key="index">
                <div class="airline-name">
                    <div class="logo">
                        <img :src="getCarrierById(getLedById(flight.InboundLegId).Carriers[0]).ImageUrl" alt="logo" />
                    </div>                 
                </div>
                <div class="flight-time">
                    <span class="start">                        
                        {{ getTimeFromFormat(getLedById(flight.InboundLegId).Departure) }}
                        <span class="airport">{{ fromAirPort }} </span>
                    </span>
                    <span class="arrow">
                        <span class="duration">
                            {{ parseMinutes(getLedById(flight.InboundLegId).Duration) }}
                        </span>
                    </span>
                    <span class="end">
                        {{ getTimeFromFormat(getLedById(flight.InboundLegId).Arrival) }}
                        <span class="airport">{{ toAirPort }} </span>
                    </span>                                
                </div>
                <div class="flight-layover">
                    {{ getLedById(flight.InboundLegId).Stops.length ? getStops(getLedById(flight.InboundLegId).Stops).join(', ') : 'Nonstops' }}
                </div>
                <div class="flight-class">
                    {{ classFly }}
                </div>
                <div class="flight-price">
                    {{ currency.Code }} {{ flight.PricingOptions[0].Price }}
                </div>
                <div class="flight-view">
                    <a href="#" class="view-btn" v-on:click="onView(flight)">View</a>
                </div>
            </div>
        </div>
        <h3 v-else id="info">No Flight results to display...<br>Click <a href="#" v-on:click="$router.go(-1)">here</a> to go back</h3>
    </section>
    <section class="s_right">
        <div id="bod">
            <div id="title">
                <h1>Flight Details</h1>
                <div id="f_services"></div>
            </div>
        </div>
        <div id="bod">
            <div class="ger">
                <label for="type">Journey Type *</label><br>
                <select  v-model="filters.journey_type" v-on:change="onChangeFilter">
                    <option disabled value="">--- Please select an option ---</option>
                    <option value="home_to_hospital">Home to Hospital</option>
                    <option value="hospital_to_hospital">Hospital to Hospital</option>
                    <option value="hospital_to_home">Hospital to Home</option>
                    <option value="home_to_home">Home to Home</option>
                </select>
            </div>
        </div>
        <div id="bod">
            <div id="title">
                <h1>Final Amount</h1>
            </div>
            <div class="final">
                <span>NGN 0.00</span><br>
                <button>Pay Now</button>
                <button>Generate Invoice</button>
            </div>
        </div>
    </section>
</section>
