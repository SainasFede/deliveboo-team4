<script>
import { Navigation, Autoplay, EffectCreative } from "swiper";
import { Swiper, SwiperSlide } from "swiper/vue";
import { store } from "../data/store";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/effect-creative";

export default {
    name: "SliderRestaurantsEvidence",
    components: {
        Swiper,
        SwiperSlide,
    },
    setup() {
        return {
            modules: [Navigation, Autoplay, EffectCreative],
        };
    },
    data() {
        return {
            store,
        };
    },
};
</script>

<template>
    <swiper
        :modules="modules"
        :slides-per-view="1"
        :speed="1500"
        :effect="'creative'"
        :creativeEffect="{
            prev: {
                shadow: true,
                translate: ['0%', 0, -1],
            },
            next: {
                translate: ['120%', 0, 0],
            },
        }"
        :autoplay="{
            delay: 6000,
            pauseOnMouseEnter: true,
        }"
        :loop="true"
        navigation
        class="mySwiper px-5"
    >
        <swiper-slide
            v-for="restaurant in store.restaurantsInEvidence"
            :key="restaurant.slug"
        >
            <router-link
                :to="{ name: 'restaurant', params: { slug: restaurant.slug } }"
            >
                <div class="restaurant-image">
                    <h2>{{ restaurant.name }}</h2>

                    <!-- <i class="fa-solid fa-circle-info"></i> -->
                    <h3 class="">Scopri {{ restaurant.name }}</h3>
                    <img
                        :src="`/storage/${restaurant.img}`"
                        :alt="restaurant.name"
                    />
                </div>
            </router-link>
        </swiper-slide>
    </swiper>
</template>

<style scoped lang="scss">
@use "../../scss/_variables.scss" as *;

.restaurant-image {
    position: relative;
    width: 100%;
    height: 500px;
    border-radius: 10px;
    overflow: hidden;

    &:hover h3 {
        display: block;
    }
    &:hover img {
        filter: brightness(30%);
    }
    &:hover h2 {
        display: none;
    }

    h2 {
        color: $white;
        font-size: 3.2rem;
        position: absolute;
        top: 50px;
        left: 50px;
        z-index: 20;
    }

    h3 {
        width: 100%;
        text-align: center;
        display: none;
        color: $light-gray;
        font-size: 3.5rem;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 20;
    }
    img {
        border-radius: 10px;
        height: 100%;
        width: 100%;
        object-fit: cover;
        filter: brightness(75%);
    }
    cursor: pointer;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
