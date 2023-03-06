<script>
import Header from "./components/Header.vue";
import Jumbotron from "./components/Jumbotron.vue";
import JumbotronRestaurant from "./components/JumbotronRestaurant.vue";
import Footer from "./components/Footer.vue";
import Btn from "./components/Btn.vue";
import { store } from "./data/store";

export default {
    name: "App",
    components: {
        Header,
        Jumbotron,
        JumbotronRestaurant,
        Footer,
        Btn,
    },
    data() {
        return {
            store,
        };
    },
    mounted() {
        this.$store.commit("updateCartFromLocalStorage");
    },
};
</script>

<template>
    <Header />
    <Jumbotron v-show="$route.name == 'home'" />
    <JumbotronRestaurant v-show="$route.name == 'restaurant'" />
    <main>
        <router-view> </router-view>
    </main>
    <Footer />
    <Btn />
</template>

<style lang="scss">
@use "../scss/appVue.scss";
</style>
