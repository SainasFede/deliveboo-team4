<script>
export default {
    name: "Header",
    data() {
        return {
            hamburgerMenuOpened: false,
            view: {
                topOfPage: true,
            },
        };
    },
    beforeMount() {
        window.addEventListener("scroll", this.handleScroll);
    },
    computed: {
        cart() {
            return this.$store.getters.getCart;
        },
    },
    methods: {
        handleScroll() {
            if (window.pageYOffset > 100) {
                if (this.view.topOfPage) this.view.topOfPage = false;
            } else {
                if (!this.view.topOfPage) this.view.topOfPage = true;
            }
        },

        openHamburger() {
            this.hamburgerMenuOpened = !this.hamburgerMenuOpened;
            console.log(this.hamburgerMenuOpened);
        },
    },
    mounted() {
        console.log(this.hamburgerMenuOpened);
    },
};
</script>

<template>
    <header
        :class="{
            onScroll: !view.topOfPage || hamburgerMenuOpened,
            headerDark:
                $route.name == 'cart' ||
                $route.name == 'team' ||
                $route.name == 'successPayment' ||
                $route.name == '404',
        }"
    >
        <router-link :to="{ name: 'home' }">
            <div class="logo">
                <img class="me-2" src="../../img/logo.png" alt="logo" />
                <span class="fs-3 fw-bold"> DeliveBoo </span>
            </div>
        </router-link>

        <div class="center-nav">
            <router-link class="me-3" :to="{ name: 'home' }">Home</router-link>
            <router-link :to="{ name: 'team' }">Team</router-link>
        </div>

        <div class="right-nav">
            <a href="/admin" class="me-3">Accedi al tuo ristorante </a>
            <router-link :to="{ name: 'cart' }" class="cart-relative">
                <i class="fa-solid fa-cart-shopping"></i>
                <div class="badge rounded-pill" v-if="cart.totalQuantity">
                    {{ cart.totalQuantity }}
                </div>
            </router-link>
        </div>

        <div class="hamburger-menu">
            <i
                v-if="!hamburgerMenuOpened"
                class="fa-solid fa-bars fs-1"
                @click="openHamburger()"
            ></i>
            <i
                v-else
                class="fa-solid fa-xmark fs-1"
                @click="openHamburger()"
            ></i>
            <div
                class="overlay"
                :class="hamburgerMenuOpened && 'overlay-visible'"
            >
                <router-link :to="{ name: 'home' }" @click="openHamburger()"
                    >Home</router-link
                >
                <router-link :to="{ name: 'team' }" @click="openHamburger()"
                    >Team</router-link
                >
                <router-link :to="{ name: 'cart' }" @click="openHamburger()"
                    >Carrello
                    <div class="badge rounded-pill" v-if="cart.totalQuantity">
                        {{ cart.totalQuantity }}
                    </div>
                </router-link>
                <a href="/admin" @click="openHamburger()"
                    >Accedi al tuo ristorante
                </a>
            </div>
            <div class="nav">
                <div id="hamburger">
                    <div></div>
                </div>
            </div>
        </div>
    </header>
</template>

<style lang="scss" scoped>
@use "../../scss/_variables.scss" as *;

header {
    z-index: 999;
    position: fixed;
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 60px;
    width: 100%;
    padding: 0 30px;
    // transition: all 0.2s ease-in-out;
    color: $white;

    .logo {
        display: flex;
        align-items: center;
        justify-content: center;
        img {
            width: 30px;
        }
    }
    a {
        text-decoration: none;
        color: $white;
        &:hover {
            text-decoration: underline;
        }
    }

    .right-nav {
        display: flex;
        .fa-cart-shopping {
            font-size: 1.6rem;
            & :hover {
                color: $orange;
            }
        }

        .cart-relative {
            position: relative;
            .badge {
                position: absolute;
                top: -10px;
                right: -10px;
                background-color: $orange;
            }
        }
    }
}

.onScroll,
.headerDark {
    background-color: $dark-gray;
}

.overlay,
.hamburger-menu {
    display: none;
}

@media all and (max-width: 480px) {
    .center-nav,
    header .right-nav {
        display: none;
    }

    header .hamburger-menu {
        display: block;
    }

    //

    .overlay-visible {
        background-color: $dark-gray;
        padding: 20px 0;
        position: absolute;
        top: 60px;
        left: 0;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding-left: 30px;
        // align-items: center;

        a {
            display: flex;
            align-items: center;
            padding-bottom: 10px;

            .badge {
                margin-left: 10px;
                background-color: $orange;
            }

            &:last-child {
                padding-bottom: 0;
            }
        }
    }
}
</style>
