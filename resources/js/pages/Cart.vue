<script>
import axios from "axios";
import CartProductList from "../components/CartProductList.vue";
import Loader from "../components/Loader.vue"
import { baseUrl } from "../data/data";
import { store } from "../data/store";
export default {
    name: "Cart",
    computed: {
        cart() {
            return this.$store.getters.getCart;
        },
    },
    components: {
        CartProductList,
        Loader
    },
    data() {
        return {
            baseUrl,
            store,
            apiToken: null,
            makePaymentUrl: baseUrl + "orders/make/payment",
            name: "",
            surname: "",
            email: "",
            address: "",
            telephone: "",
            note: "",
            nonce: "",
            errorsValidation: {
                name: "",
                surname: "",
                email: "",
                address: "",
                telephone: "",
                note: "",
            },
            errorMessage: "",
            // store.showCreditCardInput: false,
            btnPayment: false,
            showTransactionInEx: false,
            showErrorMsg: false,
        };
    },
    methods: {
        clearCart() {
            this.cart.clear();
            this.$store.commit("updateCart");
        },
        createDropIn(token) {
            const form = document.getElementById("payment-form");
            braintree.dropin
                .create({
                    authorization: token,
                    locale: "it_IT",
                    container: document.getElementById("dropin-container"),
                })
                .then((dropinInstance) => {
                    this.btnPayment = true;
                    form.addEventListener("submit", (event) => {
                        event.preventDefault();
                        dropinInstance
                            .requestPaymentMethod()
                            .then((payload) => {
                                // document.getElementById("nonce").value =
                                this.nonce = payload.nonce;
                                this.makePayment();
                            })
                            .catch((error) => {
                                console.log(error);
                                throw error;
                            });
                    });
                })
                .catch((error) => { });
        },
        getToken() {
            axios.get(baseUrl + "orders/generate").then((result) => {
                this.token = result.data.token;
                this.createDropIn(this.token);
            });
        },
        makePayment() {
            const formData = {
                cart: this.cart.toFormData(),
                name: this.name,
                surname: this.surname,
                address: this.address,
                telephone: this.telephone,
                email: this.email,
                note: this.note,
                payment_method_nonce: this.nonce,
            };

            this.errorsValidation = {};
            this.name = "";
            this.surname = "";
            this.email = "";
            this.address = "";
            this.telephone = "";
            this.note = "";

            this.btnPayment = false;
            this.showTransactionInEx = true,
            axios
                .post(this.makePaymentUrl, formData)
                .then((result) => {
                    if (result.data.status === "success") {
                        this.clearCart();
                        this.$router.push({ name: "successPayment" });
                    }
                })
                .catch((error) => {
                    if (error.response.data.status === "errorValidation") {
                        this.errorsValidation = error.response.data.errors;
                    } else if (error.response.data.status === "errorTransaction") {
                        this.errorMessage = "Transazione fallita, ";
                        this.showErrorMsg = true;
                        this.showTransactionInEx = false;
                    } else {
                        this.errorMessage =
                        "Si è verificato un problema, ";
                        this.errorMessage = "Transazione fallita, ";
                    }
                });
        },
        checkInputValidation() {
            let validation = true;

            this.errorsValidation = {
                name: "",
                surname: "",
                email: "",
                address: "",
                telephone: "",
                note: "",
            }

            if (this.name.length < 2 || this.name.length > 50) {
                store.showCreditCardInput = false;
                this.errorsValidation.name = "Il nome deve essere minimo di 2 caratteri e massimo di 50 caratteri";
                validation = false;
            }

            if (this.surname.length < 2 || this.surname.length > 100) {
                store.showCreditCardInput = false;
                this.errorsValidation.surname = "Il cognome deve essere minimo di 2 caratteri e massimo di 100 caratteri";
                validation = false;
            }

            if (!this.email.match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/)) {
                store.showCreditCardInput = false;
                this.errorsValidation.email = "L\'email deve essere valida";
                if (this.email.length < 2 || this.email.length > 50) {
                    store.showCreditCardInput = false;
                    this.errorsValidation.email = "L\'email deve essere valida";
                    validation = false;
                }
                validation = false;
            }

            if (this.address.length < 8 || this.address.length > 100) {
                store.showCreditCardInput = false;
                this.errorsValidation.address = "L\'indirizzo deve essere minimo di 8 caratteri e massimo di 100 caratteri";
                validation = false;
            }

            if (!this.telephone.match(/^[()\s-+\d]{10,17}$/)) {
                store.showCreditCardInput = false;
                this.errorsValidation.telephone = "Il numero di telefono deve essere valido";
                if (this.telephone.length < 5 || this.telephone.length > 20) {
                    store.showCreditCardInput = false;
                    this.errorsValidation.telephone = "Il numero di telefono deve essere valido";
                    validation = false;
                }
                validation = false;
            }

            if (this.note.length > 500) {
                store.showCreditCardInput = false;
                validation = false;
            }

            if (validation) {
                store.showCreditCardInput = true;
                this.getToken();
            }
        },

        removeErrorMsg(){
            this.errorMessage = "";
            this.btnPayment = true;
            this.showErrorMsg = false;
        }
    },
    mounted(){
        store.showCreditCardInput = false;
        this.showTransactionInEx = false;
        this.btnPayment = false;
    }
};
</script>
<template>
    <div class="container my-5 p-3 rounded" :class="cart.isEmpty() && 'container-empty-cart'">
        <div class="row no-gutters">
            <CartProductList />
            <div class="col payment ms-3" v-if="!cart.isEmpty()">

                <div class="d-flex justify-content-between align-items-center fs-6 payment-top-nav">
                    <div
                        class="btn w-50"
                        :class="!store.showCreditCardInput && 'active'"
                        @click="store.showCreditCardInput = false"
                >
                    <i class="fa-solid fa-user me-3"></i>Dati personali
                </div>
                    <div
                        class="btn w-50"
                        :class="store.showCreditCardInput && 'active'"
                        @click="checkInputValidation()">
                        <i class="fa-solid fa-credit-card me-3"></i>Pagamento
                    </div>
                </div>
                <form cla id="payment-form" method="POST">
                    <div v-if="!store.showCreditCardInput" class="client-data d-flex flex-column">
                        <div>
                            <input @keyup.enter="checkInputValidation()" type="text" class="form-control" required autofocus minlength="2" maxlength="50"
                            placeholder="Nome" title="Campo obbligatorio, inserire almeno 2 caratteri"
                            oninvalid="this.setCustomValidity('Campo obbligatorio, inserire almeno 2 caratteri ed un massimo di 50.')"
                            onchange="this.setCustomValidity('')" name="name" v-model.trim="name" />
                            <p v-if="errorsValidation.name" class="error">
                                {{ errorsValidation.name }}
                            </p>
                        </div>

                        <div>
                            <input @keyup.enter="checkInputValidation()" type="text" class="form-control" required autofocus minlength="2" maxlength="100"
                            placeholder="Cognome" title="Campo obbligatorio, inserire almeno 2 caratteri"
                            oninvalid="this.setCustomValidity('Campo obbligatorio, inserire almeno 2 caratteri ed un massimo di 100.')"
                            onchange="this.setCustomValidity('')" name="surname" v-model.trim="surname" />
                            <p v-if="errorsValidation.surname" class="error">
                                {{ errorsValidation.surname }}
                            </p>
                        </div>

                        <div>
                            <input @keyup.enter="checkInputValidation()" type="email" class="form-control" required
                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Indirizzo e-mail"
                            title="Campo obbligatorio, inserire una e-mail valida" minlength="6"
                            oninvalid="this.setCustomValidity('Campo obbligatorio, inserire una e-mail valida')"
                            onchange="this.setCustomValidity('')" name="email" v-model.trim="email" />
                            <p v-if="errorsValidation.email" class="error">
                                {{ errorsValidation.email }}
                            </p>
                        </div>

                        <div>
                            <input @keyup.enter="checkInputValidation()" type="text" class="form-control" required id="address"
                            title="Campo obbligatorio, inserire un indirizzo valido" minlength="8" maxlength="100"
                            autocomplete="address" autofocus placeholder="Indirizzo"
                            oninvalid="this.setCustomValidity('Campo obbligatorio, inserire un indirizzo valido.')"
                            onchange="this.setCustomValidity('')" name="address" v-model.trim="address" />
                            <p v-if="errorsValidation.address" class="error">
                                {{ errorsValidation.address }}
                            </p>
                        </div>

                        <div>
                            <input @keyup.enter="checkInputValidation()" type="phone" class="form-control" required placeholder="Telefono"
                            autocomplete="telephone" autofocus
                            title="Campo obbligatorio, inserire un numero di telefono valido" pattern="[0-9-+\s()]{5,20}"
                            oninvalid="this.setCustomValidity('Campo obbligatorio, inserire un numero di telefono valido.')"
                            onchange="this.setCustomValidity('')" name="telephone" v-model.trim="telephone" />
                            <p v-if="errorsValidation.telephone" class="error">
                                {{ errorsValidation.telephone }}
                            </p>
                        </div>

                        <div>
                            <textarea class="form-control" name="note" cols="30" rows="4"
                            placeholder="Note per il ristorante" v-model.trim="note">
                        </textarea>
                    </div>

                    </div>
                    <div class="d-flex justify-content-end">
                        <div v-if="!store.showCreditCardInput" @click="checkInputValidation()" class="btn go-to-payment"
                            title="Procedi con l'inserimento della carta">
                            Vai al pagamento
                        </div>
                    </div>
                    <div class="" v-show="store.showCreditCardInput">
                        <div id="dropin-container"></div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-payment" v-if="btnPayment" type="submit">
                                Effettua Pagamento
                            </button>
                        </div>
                        <span class="w-100 text-center">
                            <h4 v-if="showTransactionInEx"><Loader /></h4>
                        </span>
                        <input type="hidden" id="nonce" name="payment_method_nonce" />
                    </div>
                </form>
                <span class="w-100 text-center" v-if="showErrorMsg">
                    <h4 v-if="errorMessage">{{ errorMessage }}
                        <span @click="removeErrorMsg()" class="retry">riprovare</span>
                    </h4>
                </span>
            </div>
            <div class="empty-cart" v-if="cart.isEmpty()" >
                <i class="fa-solid fa-cart-shopping"></i>
                Il carrello è vuoto
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
@use "../../scss/_variables.scss" as *;

.container {
    min-height: calc(100vh - 60px - 368px - 98px);
    background-color: $white;
}

.container-empty-cart{
    display: flex;
    justify-content: center;
    align-items: center;
}

.empty-cart {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    opacity: 0.5;
    font-size: 2rem;
}

.right-title-section {
    font-size: 1.5rem;
    font-weight: bolder;
}

.active {
    font-size: 0.9rem;
    background-color: $light-gray;
    color: $dark-gray;
    border: none;
    // &:hover {
    //     background-color: $orange;
    //     color: $light-gray;
    // }
}

.btn-back{
    background-color: $white;
    border-radius: 10px;
    font-weight: bolder;
    &:hover {
        background-color: $light-gray;
        color: $dark-gray;
    }
}

.payment-top-nav{
    padding-bottom: 10px;
}

.go-to-payment,
.btn-payment {
    background-color: $orange;
    color: $white;

    &:hover {
        background-color: lighten($orange, 10%);
        color: $white;
    }
}

.retry{
    cursor: pointer;
    text-decoration: underline;
    &:hover{
        color: $orange;
    }
}

.client-data{
    div{
        margin-bottom: 1rem;
        .error {
            color: $orange;
            margin: 0;
        }
    }
}

@media all and (max-width: 480px) {
    .payment{
        margin-top: 50px;
    }
}


</style>
