<script>
import axios from "axios";
import ProductCards from "../components/ProductCard.vue";
import SummaryCartMobile from "../components/SummaryCartMobile.vue";
import { baseUrl } from "../data/data";
import { store } from "../data/store";

export default {
    name: "Restaurant",
    components: {
        ProductCards,
        SummaryCartMobile,
    },
    data() {
        return {
            baseUrl,
            products: [],
            store,
            visible: false,
            newProduct: null,
        };
    },
    computed: {
        cart() {
            return this.$store.getters.getCart;
        },
    },
    methods: {
        getApi() {
            axios
                .get(this.baseUrl + "restaurants/" + this.$route.params.slug)
                .then((result) => {
                    this.success = result.data.success;
                    store.restaurant = result.data.restaurant;
                    this.products = result.data.products;
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.$router.push({ name: "404" });
                    }
                });
        },
        clearCart() {
            this.cart.clear();
            this.$store.commit("updateCart");
        },
        productQuantityInCart(product) {
            const item = this.cart.findItem(product);
            if (item) {
                return item.quantity;
            }
        },
        addToCart(product) {
            this.cart.addItem(product, store.restaurant);
            this.$store.commit("updateCart");
        },

        removeFromCart(product) {
            this.cart.decreaseItem(product);
            this.$store.commit("updateCart");
        },
        formatPrice(price) {
            return new Intl.NumberFormat("it-IT", {
                style: "currency",
                currency: "EUR",
            }).format(price);
        },
        OpenCloseFun() {
            this.visible = !this.visible;
            if (this.visible) {
                window.scrollTo(0, 0);
            }
        },
        handleNewCart(product) {
            this.newProduct = product;
            this.OpenCloseFun();
        },
    },
    mounted() {
        this.getApi();
    },
};
</script>

<template>
    <div
        v-if="visible"
        class="modal fade show"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-modal="true"
        role="dialog"
        style="display: block"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vuoi creare un nuovo carrello?</h5>
                    <button
                        @click="OpenCloseFun()"
                        type="button"
                        class="btn-close"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    In questo modo cancelli il carrello esistente da
                    <strong>{{ cart.restaurant.name }}</strong> e crei un nuovo
                    carrello da <strong>{{ store.restaurant.name }}</strong>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button
                        @click="OpenCloseFun()"
                        type="button"
                        class="btn annulla"
                    >
                        Annulla
                    </button>
                    <button
                        @click="
                            OpenCloseFun();
                            clearCart();
                            addToCart(this.newProduct);
                        "
                        type="button"
                        class="btn new-cart"
                    >
                        Nuovo carrello
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div :class="visible && 'darken'"></div>
    <!--  -->
    <div class="container">
        <div class="mb-5 d-flex">
            <div class="left">
                <h2 class="mb-5">Scopri il menù</h2>
                <ProductCards
                    v-for="(product, index) in products"
                    :key="index"
                    :product="product"
                    :restaurant="store.restaurant"
                    @CartFull="handleNewCart"
                />
            </div>
            <div class="right ms-5">
                <div class="sticky">
                    <h2 class="mb-5">Riepilogo ordine</h2>
                    <div class="riepilogo">
                        <div v-if="!cart.isEmpty() && cart.restaurant">
                            <h5>{{ cart.restaurant.name }}</h5>
                            <span
                                class="cart-items"
                                v-for="item in cart.items"
                                :key="item.slug"
                            >
                                <p class="product-name">
                                    {{ item.product.name }}
                                </p>
                                <div
                                    class="bnt-box d-flex align-items-center justify-content-between ms-2"
                                >
                                    <button
                                        class="btn"
                                        @click="removeFromCart(item.product)"
                                    >
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                    <span class="mx-2">{{
                                        productQuantityInCart(item.product)
                                    }}</span>
                                    <button
                                        class="btn me-2"
                                        @click="addToCart(item.product)"
                                    >
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                    <div class="">
                                        {{ formatPrice(item.totalPrice) }}
                                    </div>
                                </div>
                            </span>
                            <div
                                class="sub-total d-flex w-100 justify-content-between mt-4"
                            >
                                <h5>Subtotale</h5>
                                <h5>{{ formatPrice(cart.amount) }}</h5>
                            </div>
                            <router-link
                                :to="{ name: 'cart' }"
                                class="btn go-cart w-100 fs-6 mt-3 fw-bolder"
                            >
                                <i class="fa-solid fa-cart-shopping me-2"></i>
                                Vai al carrello
                            </router-link>
                        </div>
                        <span
                            class="d-flex flex-column align-items-center fs-5 empty-cart"
                            v-else
                        >
                            <i class="fa-solid fa-cart-shopping mb-2"></i>
                            Il carrello è vuoto
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <SummaryCartMobile
        :amount="formatPrice(cart.amount)"
        :totalQuantity="cart.totalQuantity"
        v-show="!cart.isEmpty()"
        class="visible"
    />
</template>

<style scoped lang="scss">
@use "../../scss/_variables.scss" as *;

.darken {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    z-index: 999;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    overflow: hidden;
}

.visible {
    display: none;
}

.annulla {
    &:hover {
        background-color: $light-gray;
        color: $dark-gray;
    }
}

.new-cart,
.right .btn.go-cart {
    background-color: $orange;
    color: $white;

    &:hover {
        background-color: lighten($orange, 10%);
        color: $white;
    }
}

.left {
    width: 70%;
}

.right {
    width: 30%;

    .btn {
        font-size: 0.7rem;
        background-color: $light-gray;
        color: $dark-gray;
        &:hover {
            background-color: $orange;
            color: $light-gray;
        }
    }

    .sticky {
        position: sticky;
        top: 100px;
        .riepilogo {
            padding: 20px;
            border-radius: 10px;
            background-color: $white;
            box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.25);

            .product-name {
                width: 45%;
                white-space: pre-wrap;
            }

            .bnt-box {
                width: 55%;
            }

            .cart-items {
                padding: 10px 0;
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 1px dashed $dark-gray;

                p {
                    margin: 0;
                }
            }

            .empty-cart {
                opacity: 0.5;
            }
        }
    }
}

@media all and (max-width: 480px) {
    .visible {
        display: block;
    }
    .right {
        display: none;
    }
    .left {
        width: 100%;
        margin: 0;
        padding: 0;
    }
}
@media all and (max-width: 767px) {
}
@media all and (min-width: 1024px) {
    .visible {
        visibility: hidden;
    }
}
</style>
