<script>
import RestaurantsCards from "../components/RestaurantsCards.vue";
import SearchBar from "../components/SearchBar.vue";
import Category from "../components/Category.vue";
import SliderRestaurantsEvidence from "../components/SliderRestaurantsEvidence.vue";

export default {
    name: "Home",
    components: {
        RestaurantsCards,
        Category,
        SearchBar,
        SliderRestaurantsEvidence,
    },
};
</script>

<template>
    <div class="container home-container mb-5">
        <h2 class="mb-5">Cerca un ristorante per categoria o per nome</h2>
        <Category class="mb-5" />
        <SearchBar class="mb-5" />
        <RestaurantsCards />

        <h2 class="mb-5">Ristoranti in primo piano</h2>
        <SliderRestaurantsEvidence />
    </div>
</template>

<style lang="scss" scoped>
@use "../../scss/_variables.scss" as *;

.home-container {
    min-height: calc(100vh - 450px);
    display: flex;
    flex-direction: column;
    h2 {
        font-size: 2.5rem;
        color: $dark-gray;
    }
}

@media all and (max-width: 480px) {
    .home-container h2 {
        font-size: 2rem;
    }
}
</style>
