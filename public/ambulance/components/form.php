<div class="form">
    <ValidationObserver tag="form" v-slot="{ invalid }">
        <form @submit.prevent="onSubmit">
            <div class="travler" v-for="(t, index) in travlers">
                <div class="header">
                    <h1>Travler {{ index + 1 }} (Adult)</h1>
                </div>
                <div class="body">
                    <div class="gender">
                        <label for="">
                            Mr
                            <input type="radio" :name="`gender-${index}`" value="Mr" v-model="t.gender" />
                        </label>

                        <label for="">
                            Ms
                            <input type="radio" :name="`gender-${index}`" value="Ms" v-model="t.gender" />
                        </label>

                        <label for="">
                            Mrs
                            <input type="radio" :name="`gender-${index}`" value="Mrs" v-model="t.gender" />
                        </label>
                    </div>
                    <div class="blank">
                        <div>
                            <ValidationProvider rules="required" name="First/Given" v-slot="{ errors }">
                                <label for="">First/Given name</label>
                                <input :class="{'has-error': errors.length}" type="text" placeholder="First/Given" v-model="t.firstname"  />
                                <span class="error-label">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </div>
                        <div>
                            <ValidationProvider rules="required" name="Surname" v-slot="{ errors }">
                                <label for="">Surname</label>
                                <input :class="{'has-error': errors.length}" type="text" placeholder="Enter surname (as per ID or passport)" v-model="t.surname" />
                                <span class="error-label">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </div>
                        <div class="birth">
                            <label for="">Date of birth</label>
                            <div class="date">
                                <select name="day" v-model="t.day">
                                    <option :value="d" :key="index" v-for="(d, index) in [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31]">{{ d }}</option>
                                </select>
                                <select name="month" v-model="t.month">
                                    <option :value="m.value" :key="index" v-for="(m, index) in months">{{ m.text}}</option>
                                </select>
                                <select name="year" v-model="t.year">
                                    <option :value="y" :key="index" v-for="(y, index) in years">{{ y }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <a href="#"  v-if="travlers.length - 1 != index" @click.prevent="onRemoveTravler(index)" class="add-travler">
                        <img src="/assets/svg/remove-icon.svg" alt="add" width="32" height="32" />
                        remove travler
                    </a>
                    <a href="#"  v-else @click.prevent="onAddTravler" class="add-travler">
                        <img src="/assets/svg/add-icon.svg" alt="add" width="32" height="32" />
                        add travler
                    </a>
                </div>
            </div>

            <div class="contact-details">
                <div class="header">
                    <h1>Contact details</h1>
                </div>
                <div class="body">
                    <div class="gender">
                        <label for="">
                            Mr
                            <input type="radio" name="contact-gender" value="Mr" v-model="contact.gender" />
                        </label>

                        <label for="">
                            Ms
                            <input type="radio" name="contact-gender" value="Ms" v-model="contact.gender" />
                        </label>

                        <label for="">
                            Mrs
                            <input type="radio" name="contact-gender" value="Mrs" v-model="contact.gender" />
                        </label>
                    </div>
                    <div class="blank">
                        <div>
                            <ValidationProvider rules="required" name="Contact first/given" v-slot="{ errors }">
                                <label for="">First/Given name</label>
                                <input :class="{'has-error': errors.length}" type="text" placeholder="Contact First/Given" v-model="contact.firstname" />
                                <span class="error-label">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </div>
                        <div>
                            <ValidationProvider rules="required" name="Contact surname" v-slot="{ errors }">
                                <label for="">Surname</label>
                                <input :class="{'has-error': errors.length}" type="text" placeholder="Contact Surname" v-model="contact.surname" />
                                <span class="error-label">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </div>
                        <div>
                            <ValidationProvider rules="required|email" name="Email" v-slot="{ errors }">
                                <label for="">Email</label>
                                <input :class="{'has-error': errors.length}" type="text" placeholder="Email" v-model="contact.email" />
                                <span class="error-label">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </div>
                        <div>
                            <ValidationProvider rules="required" name="Contact country code" v-slot="{ errors }">
                                <label for="">Country code</label>
                                <select :class="{'has-error': errors.length}" name="" id="" v-model="contact.country_code">
                                    <option :value="c.code" :key="index" v-for="(c, index) in countryCodes">{{ c.name }} ({{ c.dial_code }})</option>
                                </select>
                                <span class="error-label">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </div>
                        <div>
                            <ValidationProvider rules="required" name="Contact mobile number" v-slot="{ errors }">
                                <label for="">Mobile number</label>
                                <input :class="{'has-error': errors.length}" type="text" placeholder="Mobiler number" v-model="contact.mobile" />
                                <span class="error-label">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </div>
                    </div>
                </div>
            </div>
            
            <div>
                <button :disabled="invalid" :class="{'disabled': invalid}">Continue</button>
            </div>
        </form>
    </ValidationObserver>
</div>