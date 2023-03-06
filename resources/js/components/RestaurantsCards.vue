<script>
import RestaurantItem from "./RestaurantItem.vue";
import Loader from "./Loader.vue";
import { store } from "../data/store";
export default {
    name: "RestaurantsCards",
    components: {
        RestaurantItem,
        Loader,
    },
    data() {
        return {
            store,
        };
    },
};
</script>

<template>
    <Loader v-if="store.isLoading" />
    <div v-else>
        <div class="mb-3" v-if="store.filterCategory.length">
            <span v-if="store.filterCategory.length == 1" class="fw-bolder"
                >Categoria selezionata:
            </span>
            <span v-else-if="store.filterCategory.length > 1" class="fw-bolder"
                >Categorie selezionate:
            </span>

            <span v-for="category in store.categoryClicked">
                {{ category }}
                <span v-if="store.filterCategory.length > 1"> / </span>
            </span>
        </div>
        <div class="container" v-if="store.restaurants.length">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                <RestaurantItem
                    v-for="restaurant in store.restaurants"
                    :key="store.restaurants.id"
                    :restaurant="restaurant"
                />
            </div>
        </div>
        <h3
            class="text-center mb-5"
            v-else-if="
                store.filterCategory.length || (store.searched && store.typed)
            "
        >
            Nessun risultato trovato
        </h3>
        <h3
            class="text-center mb-5"
            v-if="store.searched === '' && store.btnClicked === true"
        >
            Per cercare inserire il nome di un ristorante
        </h3>
    </div>
</template>

<style lang="scss" scoped>
@use "../../scss/_variables.scss" as *;
</style>

<!-- // (!store.restaurants.length && store.filterCategory.length) ||
// (!store.restaurants.length && store.searched && store.typed) -->
