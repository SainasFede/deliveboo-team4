<script>
import axios from "axios";
import { baseUrl } from "../data/data";
import { store } from "../data/store";
import SliderCategory from "./SliderCategory.vue";

export default {
    components: {
        SliderCategory,
    },
    name: "Category",
    data() {
        return {
            baseUrl,
            store,
        };
    },
    methods: {
        getApi() {
            store.isLoading = true;
            axios.get(this.baseUrl + "restaurants").then((result) => {
                store.categories = result.data.categories;
                store.allRestaurants = result.data.restaurants;
                this.getRestaurantsInEvidence();
                store.isLoading = false;
            });
        },

        getCategories(categories) {
            if (categories.length) {
                const stringCategories = categories.join();
                store.isLoading = true;
                axios
                    .get(
                        this.baseUrl +
                            "restaurants/restaurantsbycategory/" +
                            stringCategories
                    )
                    .then((result) => {
                        store.restaurants = result.data.restaurants;
                        store.isLoading = false;
                    });
            } else {
                store.restaurants = [];
            }
        },
        getRestaurantsInEvidence() {
            while (store.restaurantsInEvidence.length < 8) {
                let item =
                    store.allRestaurants[
                        Math.floor(Math.random() * store.allRestaurants.length)
                    ];
                if (!store.restaurantsInEvidence.includes(item)) {
                    store.restaurantsInEvidence.push(item);
                }
            }
        },
    },
    mounted() {
        this.getApi();
    },
};
</script>

<template>
    <div class="container m-0 p-0">
        <SliderCategory
            :categories="store.categories"
            @categoryClicked="getCategories(store.filterCategory)"
        />
    </div>
</template>

<style lang="scss"></style>
