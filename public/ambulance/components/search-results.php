<section id="s">
    <section class="s_left">
        <div id="title">
            <h1>Additional Services</h1>
        </div>
        <ul class="filter-additional-services">
            <li v-for="(ser, index) in add_services" :key="index">
                <label>
                    <input name="services" :value="ser" type="checkbox" v-model="options.additional_service" v-on:change="onChangeFilter"  />
                    {{ ser.name }}
                    <span class="price">NGN{{ ser.price }}</span>
                </label>
            </li>
        </ul>
    </section>
    <section class="s_center">
        <?php include('filter.php'); ?>
        <div class="flights" v-if="flights.Itineraries && flights.Itineraries.length">
            <div class="item-flight" v-for="(flight, index) in flights.Itineraries" :key="index">
                <div class="airline-name">
                    <div class="logo">
                        <img :src="getCarrierById(getLedById(flight.OutboundLegId).Carriers[0]).ImageUrl" alt="logo" />
                    </div>                 
                </div>
                <div class="flight-time">
                    <span class="start">       
                        <div v-html="getTimeFromFormat(getLedById(flight.OutboundLegId).Departure)">
                        </div>                                         
                        <span class="airport">{{ fromAirPort }} </span>
                    </span>
                    <span class="arrow">
                        <span class="duration">
                            {{ parseMinutes(getLedById(flight.OutboundLegId).Duration) }}
                        </span>
                    </span>
                    <span class="end">
                        <div v-html="getTimeFromFormat(getLedById(flight.OutboundLegId).Arrival)">
                        </div>                        
                        <span class="airport">{{ toAirPort }} </span>
                    </span>                                
                </div>
                <div class="flight-layover">
                    {{ getLedById(flight.OutboundLegId).Stops.length ? getStops(getLedById(flight.OutboundLegId).Stops).join(', ') : 'Nonstops' }}
                </div>
                <div class="flight-class">
                    {{ classFly }}
                </div>
                <div class="flight-price">
                    {{ currency.Code }} {{ flight.PricingOptions[0].Price }}
                </div>
                <div class="flight-view">
                    <a href="#" class="view-btn" v-on:click.prevent="onView(flight)">View</a>
                </div>
            </div>
        </div>
        <h3 v-else id="info">No Flight results to display...<br>Click <a href="#" v-on:click="$router.go(-1)">here</a> to go back</h3>
    </section>
    <section class="s_right">
        <div id="bod" v-if="currentFlight">
            <div id="title" class="current-flight">
                <h1>Flight Details</h1>
                <div  class="details">
                    <h2>Ticket price</h2>
                    <div class="total-price">{{ currency.Code }} {{ ticketPrice }}</div>
                    <div>
                        for {{ passengers }} Traveller
                    </div>
                    <a :href="bookingLink" target="blunk" class="booking-btn">Book this flight</a>
                </div>
            </div>
        </div>
        <div id="bod">
            <div class="ger">
                <label for="type">Journey Type *</label><br>
                <select  v-model="options.journey_type" v-on:change="onChangeFilter">
                    <option disabled value="">--- Please select an option ---</option>
                    <option value="home_to_hospital">Home to Hospital</option>
                    <option value="hospital_to_hospital">Hospital to Hospital</option>
                    <option value="hospital_to_home">Hospital to Home</option>
                    <option value="home_to_home">Home to Home</option>
                </select>
            </div>
        </div>
        <div v-if="currentFlight">
            <div class="flight-info">
                <div class="location-line">
                    <span>
                        {{ locationFrom }}
                    </span>
                    <span class="to">
                        to
                    </span>
                    <span>
                        {{ locationTo }}
                    </span>
                    <span class="duration">
                        {{ parseMinutes(getLedById(currentFlight.OutboundLegId).Duration) }}
                    </span>
                </div>
                <div class="carrier">
                    <div class="image">
                        <img :src="getCarrierById(getLedById(currentFlight.OutboundLegId).Carriers[0]).ImageUrl" />
                    </div>
                    <div class="name">
                        {{ getCarrierById(getLedById(currentFlight.OutboundLegId).Carriers[0]).Name }}, {{ classFly }}
                    </div>
                </div>
                <div class="times-period">
                    <span class="start">                        
                        <div v-html="getTimeFromFormat(getLedById(currentFlight.OutboundLegId).Departure)"></div>                        
                        <span class="airport">{{ fromAirPort }} </span>
                    </span>
                    <span class="arrow">
                        <span class="duration">
                            {{ parseMinutes(getLedById(currentFlight.OutboundLegId).Duration) }}
                        </span>
                    </span>
                    <span class="end" >
                        <div v-html="getTimeFromFormat(getLedById(currentFlight.OutboundLegId).Arrival)"></div>
                        <span class="airport">{{ toAirPort }} </span>
                    </span>    
                </div>
            </div>
        </div>
        <div id="bod" v-if="finalPrice && currentFlight">
            <div id="title">
                <h1>Final Amount</h1>
            </div>
            <div class="selected-add-services">
                <div class="selected-add" v-for="(add, index) in options.additional_service" :key="index">
                    {{ add.name }}
                    <span class="price">NGN{{ add.price }}</span>
                </div>
            </div>
            <div class="final-price">
                <span>NGN {{ finalPrice }}</span><br>
            </div>
            <div class="final">
                <button class="btn-pay-now" v-on:click.prevent="onClickPayNow">Pay Now</button>
                <!-- <button class="btn-generate-invoice" v-on:click.prevent="onClickGenerateInvoice">Generate Invoice</button> -->
            </div>
        </div>
    </section>
</section>
