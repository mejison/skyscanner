<section id="s" class="search-results">
    <section class="section left">
        <div id="title">
            <h1>Additional Services</h1>
        </div>
        <ul class="filter-additional-services">
            <li v-for="(ser, index) in add_services" :key="index">
                <label>
                    <input name="services" :value="ser" type="checkbox" v-model="options.additional_service" v-on:change="onChangeFilter"  />
                    {{ ser.name }}
                    <span class="price">NGN{{ numeral(ser.price).format('0[,]00') }}</span>
                </label>
            </li>
        </ul>
    </section>
    <section class="section center">
        <?php include('filter.php'); ?>
        <!-- <?php include('sort.php'); ?> -->
        <div class="flights" v-if="flights && flights.length">
            <div class="item-flight" v-for="(flight, index) in flightsItinerariesSorted" :key="index" v-if="flight.AirSegmentRef && flight.AirSegmentRef.length">
                <div class="airline-name">
                    <div class="logo">
                        <img :src="`https://www.travelstart.com.ng/assets/img/carriers/retina48px/carrier-${flight.AirSegmentRef[0].Airline}.png`" alt="logo" />
                    </div>
                    <div class="name">{{ getCarrierNameByCode(flight.AirSegmentRef[0].Airline).CodeshareInfo }}</div>
                </div>
                <div class="flight-time">
                    <span class="start">       
                        <div v-html="flight.AirSegmentRef[0].Depart">
                        </div>                                         
                        <span class="airport">{{ flight.AirSegmentRef[0].From }} </span>
                    </span>
                    <span class="arrow">
                        <span class="duration">
                            Duration
                        </span>
                    </span>
                    <span class="end">
                        <div v-html="flight.AirSegmentRef[0].Arrive">
                        </div>                        
                        <span class="airport">{{ flight.AirSegmentRef[0].To }} </span>
                    </span>                                
                </div>
                <div class="flight-layover">
                    Nonstops
                </div>
                <div class="flight-class">
                    {{ classFly }}
                </div>
                <div class="flight-price">
                    {{ numeral(flight.TotalPrice).format('0[,]00') }}
                </div>
                <div class="flight-view">
                    <a href="#" class="view-btn" v-on:click.prevent="onView(flight)">View</a>
                </div>
            </div>
        </div>
        <h3 v-else id="info">No Flight results to display...<br>Click <a href="#" v-on:click="$router.go(-1)">here</a> to go back</h3>
    </section>
    <section class="section right" :class="{'hide': ! isShowRight}">
        <div id="bod" v-if="currentFlight">
            <div id="title" class="current-flight">
                <h1>Flight Details</h1>
                <div  class="details">
                    <h2>Ticket price</h2>
                    <div class="total-price">{{ numeral(ticketPrice).format('0[,]00') }}</div>
                    <div>
                        for {{ passengers }} Traveller
                    </div>
                </div>
            </div>            
        </div>
        <div id="bod" class="final-amount" v-if="finalPrice && currentFlight">            
            <div class="selected-add-services">
                <div class="selected-add" v-for="(add, index) in options.additional_service" :key="index">
                    {{ add.name }}
                    <span class="price">{{ numeral(add.price).format('0[,]00') }}</span>
                </div>
            </div>
            <div class="final-price">
                <span>{{ numeral(finalPrice).format('0[,]00') }}</span><br>
            </div>
            <div class="final">
                <button class="btn-pay-now" v-on:click.prevent="onClickPayNow">Pay Now</button>
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
                     Duration
                    </span>
                </div>
                <div class="carrier">
                    <div class="image">
                        <img :src="`https://www.travelstart.com.ng/assets/img/carriers/retina48px/carrier-${currentFlight.AirSegmentRef[0].Airline}.png`" />
                    </div>
                    <div class="name">
                        {{ getCarrierNameByCode(currentFlight.AirSegmentRef[0].Airline).CodeshareInfo }}, {{ classFly }}
                    </div>
                </div>
                <div class="times-period">
                    <span class="start">                        
                        <div v-html="currentFlight.AirSegmentRef[0].Depart"></div>                        
                        <span class="airport">{{ fromAirPort }} </span>
                    </span>
                    <span class="arrow">
                        <span class="duration">
                         Duration
                        </span>
                    </span>
                    <span class="end" >
                        <div v-html="currentFlight.AirSegmentRef[0].Arrive"></div>
                        <span class="airport">{{ toAirPort }} </span>
                    </span>    
                </div>
            </div>
        </div>
    </section>
</section>
