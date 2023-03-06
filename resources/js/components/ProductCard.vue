<script>
import { store } from "../data/store";
export default {
    name: "Team",
    props: {
        product: Object,
        restaurant: Object,
    },
    data() {
        return {
            store,
        };
    },
    computed: {
        cart() {
            return this.$store.getters.getCart;
        },
        productQuantityInCart() {
            const item = this.cart.findItem(this.product);
            if (item) {
                return item.quantity;
            }
        },
    },
    methods: {
        formatPrice(price) {
            return new Intl.NumberFormat("it-IT", {
                style: "currency",
                currency: "EUR",
            }).format(price);
        },
        addToCart() {
            if (this.cart.addItem(this.product, this.restaurant)) {
                this.$store.commit("updateCart");
            } else {
                this.$emit("CartFull", this.product);
            }
        },

        removeFromCart() {
            this.cart.decreaseItem(this.product);
            this.$store.commit("updateCart");
        },
    },
    mounted() {
        this.formatPrice();
    },
};
</script>

<template>
    <div v-if="product.is_visible" class="card d-flex flex-row mb-5 mx-2">
        <div class="card-image">
            <img
                v-if="product.img"
                :src="`/storage/${product.img}`"
                :alt="product.name"
            />
            <img v-else src="../../img/placeholder.png" :alt="product.name" />
        </div>
        <div class="card-body">
            <h5 class="card-title fw-bold">
                {{ product.name }}
            </h5>
            <p>{{ product.description }}</p>
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="m-0">{{ formatPrice(product.price) }}</h4>

                <div>
                    <button
                        class="btn"
                        @click="removeFromCart()"
                        :class="!productQuantityInCart && 'disabled'"
                    >
                        <i class="fa-solid fa-minus"></i>
                    </button>
                    <span class="mx-2">{{ productQuantityInCart }}</span>
                    <button class="btn me-2" @click="addToCart()">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
@use "../../scss/_variables.scss" as *;
.card {
    border-radius: 10px;
    box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.25);
    position: relative;

    .card-image {
        position: absolute;
        width: 90px;
        height: 90px;
        top: 50%;
        transform: translate(-15px, -50%);
        img {
            height: 100%;
            width: 100%;
            border-radius: 10px;
            box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.25);
            object-fit: cover;
        }
    }

    .card-body {
        width: 100%;
        padding-left: 100px;
        white-space: nowrap;

        h5,
        p {
            color: $dark-gray;
            white-space: pre-wrap;
        }

        .address {
            width: 100%;
            font-size: 1rem;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        .category-box {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            .badge {
                background-color: $light-gray;
                color: $dark-gray;
            }
        }

        .btn {
            background-color: $light-gray;
            color: $dark-gray;
            &:hover {
                background-color: $orange;
                color: $light-gray;
            }
        }
    }
    &:last-child {
        margin-bottom: 0px !important;
    }
}

.disabled {
    opacity: 0.4;
    border: none;
}
</style>
