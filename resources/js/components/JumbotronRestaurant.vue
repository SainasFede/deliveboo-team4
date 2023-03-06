<script>
import { store } from "../data/store";
export default {
    name: "Jumbotron",

    data() {
        return {
            store,
        };
    },
};
</script>

<template>
    <div
        class="jumbotron"
        :style="{ backgroundImage: `url(/storage/${store.restaurant.img})` }"
    >
        <div class="container">
            <h2>{{ store.restaurant.name }}</h2>
            <h4>{{ store.restaurant.address }}</h4>
            <img :src="store.restaurant.img" alt="" />
            <span
                class="badge fw-normal me-2"
                v-for="(categories, index) in store.restaurant.categories"
                :key="index"
            >
                {{ categories.name }}
            </span>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@use "../../scss/_variables.scss" as *;

.jumbotron {
    display: flex;
    //justify-content: center;
    align-items: center;
    width: 100%;
    height: 450px;
    box-shadow: inset 0px 100px 100px rgba(0, 0, 0, 0.25);
    color: $white;

    background: rgba(0, 0, 0, 0.6);
    background-blend-mode: darken;
    background-position: center 55%;
    background-repeat: no-repeat;
    background-size: cover;

    h2 {
        font-size: 4rem;
        //margin-left: 100px;
    }

    h2,
    h4 {
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .badge {
        background-color: $light-gray;
        color: $dark-gray;
    }
}

@media all and (max-width: 480px) {
    .jumbotron {
        height: 250px;

        .container {
            padding-left: 30px;
            h2 {
                font-size: 25px;
                text-overflow: ellipsis;
                overflow: hidden;
            }
            h4 {
                font-size: 15px;
                text-overflow: ellipsis;
                overflow: hidden;
            }
        }
    }
}
</style>
