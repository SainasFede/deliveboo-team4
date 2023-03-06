<script>
import { store } from "../data/store";
export default {
    name: "CartProductList",
    data() {
        return {
            store,
            visible: false,
        };
    },
    computed: {
        cart() {
            return this.$store.getters.getCart;
        },
    },
    methods: {
        clearCart() {
            this.cart.clear();
            this.$store.commit("updateCart");
        },
        formatPrice(price) {
            return new Intl.NumberFormat("it-IT", {
                style: "currency",
                currency: "EUR",
            }).format(price);
        },
        addToCart(product) {
            this.cart.addItem(product, store.restaurant);
            this.$store.commit("updateCart");
        },

        removeFromCart(product) {
            console.log(product);
            this.cart.decreaseItem(product);
            this.$store.commit("updateCart");
        },
        productQuantityInCart(product) {
            const item = this.cart.findItem(product);
            if (item) {
                return item.quantity;
            }
        },
        deleteItem(product) {
            this.cart.deleteItem(product);
            this.$store.commit("updateCart");
        },
        OpenCloseFun() {
            this.visible = !this.visible;
            if (this.visible) {
                window.scrollTo(0, 0);
            }
        },
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
                    <h5 class="modal-title">Vuoi svuotare il carrello?</h5>
                    <button
                        @click="OpenCloseFun()"
                        type="button"
                        class="btn-close"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    In questo modo cancelli il carrello esistente da
                    <strong>{{ cart.restaurant.name }}</strong
                    >.
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button
                        @click="OpenCloseFun()"
                        type="button"
                        class="btn annulla fs-6"
                    >
                        Annulla
                    </button>
                    <button
                        @click="
                            OpenCloseFun();
                            clearCart();
                        "
                        type="button"
                        class="btn new-cart fs-6"
                    >
                        Svuota carrello
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div :class="visible && 'darken'"></div>

    <div class="col-md-8" v-if="!cart.isEmpty()">
        <div class="product-details">
            <div class="top">
                <span class="">
                    <router-link
                        :to="{
                            name: 'restaurant',
                            params: { slug: cart.restaurant.slug },
                        }"
                    >
                        <button
                            class="btn back-to-restaurant"
                            title="Torna al ristorante"
                        >
                            <i class="fa-solid fa-utensils"></i>
                            Torna a
                            <span class="fw-bolder">{{
                                cart.restaurant.name
                            }}</span>
                        </button>
                    </router-link>
                </span>
                <button
                    v-if="store.showCreditCardInput == false"
                    @click="OpenCloseFun()"
                    class="btn ml-2 mx-2 fw-bolder"
                    title="Rimuovi tutti i prodotti"
                >
                    Svuota carrello
                </button>
            </div>

            <div
                v-for="(item, index) in cart.items"
                :key="index"
                class="d-flex align-items-center row-product"
            >
                <div class="left">
                    <div class="img-item">
                        <img
                            :src="`/storage/${item.product.img}`"
                        />
                    </div>
                    <div class="d-flex flex-column">
                        <span class="fw-bolder"> {{ item.product.name }}</span
                        ><span
                            >Prezzo Unitario
                            {{ formatPrice(item.product.price) }}</span
                        >
                    </div>
                </div>
                <div class="right">
                    <div class="btn-box">
                        <button
                            v-if="store.showCreditCardInput == false"
                            title="Rimuovi tutti i prodotti"
                            class="btn btn-trash me-2"
                            @click="deleteItem(item.product)"
                        >
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        <button
                            v-if="store.showCreditCardInput == false"
                            title="Rimuovi un prodotto"
                            class="btn"
                            @click="removeFromCart(item.product)"
                        >
                            <i class="fa-solid fa-minus"></i>
                        </button>
                        <span class="mx-2">{{
                            productQuantityInCart(item.product)
                        }}</span>
                        <button
                            v-if="store.showCreditCardInput == false"
                            title="Aggiungi un prodotto"
                            class="btn me-1"
                            @click="addToCart(item.product)"
                        >
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                    <div class="total-amount">
                        {{ formatPrice(item.totalPrice) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="total-amount d-flex justify-content-between fs-4">
            <div>Totale:</div>
            <div>{{ formatPrice(cart.amount) }}</div>
        </div>
    </div>
</template>

<style scoped lang="scss">
@use "../../scss/_variables.scss" as *;

.modal-footer .annulla {
    background-color: $orange;
    color: $white;

    &:hover {
        background-color: lighten($orange, 10%);
        color: $white;
    }
}

.modal-footer .new-cart {
    background-color: $white;
    &:hover {
        background-color: $light-gray;
        color: $dark-gray;
    }
}

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

.btn {
    font-size: 0.9rem;
    background-color: $light-gray;
    color: $dark-gray;
    &:hover {
        background-color: $orange;
        color: $light-gray;
    }
}

.top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0px 10px 10px 10px;
    // d-flex flex-row align-items-center mb-3
}

.row-product {
    padding: 10px;
    border-top: 3px solid $light-gray;
    &:last-child {
        border-bottom: 3px solid $light-gray;
    }
}

.left {
    display: flex;
    align-items: center;
    width: 70%;
    .img-item {
        display: flex;
        height: 80px;
        width: 80px;
        border-radius: 10px;
        overflow: hidden;
        margin-right: 15px;
        img {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
    }
}

.right {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 30%;
    height: 80px;
}

.total-amount {
    padding: 10px;
    font-weight: bolder;
}

.back-to-restaurant {
    background-color: $orange;
    color: $white;
    &:hover {
        background-color: lighten($orange, 10%);
        color: $white;
    }
}

@media all and (max-width: 480px) {

    .left{
        width: 60%;
        margin-left: 10px;
        .img-item {
            display: none;
        }
    }

    .right{
        width: 40%;

        .total-amount{
            padding: 0;
        }

        .btn-box{
            display: flex;
            align-items: center;

            .btn-trash{
                display: none;
            }
        }
    }


}
</style>
