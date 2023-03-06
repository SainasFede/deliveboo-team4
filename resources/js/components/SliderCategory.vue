<script>
import { Navigation } from "swiper";
import { Swiper, SwiperSlide } from "swiper/vue";
import { store } from "../data/store";
import "swiper/css";
import "swiper/css/navigation";

export default {
    name: "SliderCategory",
    components: {
        Swiper,
        SwiperSlide,
    },
    props: {
        categories: Array,
    },
    setup() {
        return {
            modules: [Navigation],
        };
    },
    data() {
        return {
            store,
        };
    },
    methods: {
        isChosen(id, name) {
            store.searched = "";
            if (!this.store.filterCategory.includes(id)) {
                this.store.filterCategory.push(id);
                this.store.categoryClicked.push(name);
            } else {
                const index = this.store.filterCategory.indexOf(id);
                this.store.filterCategory.splice(index, 1);
                this.store.categoryClicked.splice(index, 1);
            }
        },
    },
    mounted() {},
};
</script>

<template>
    <swiper
        :breakpoints="{
            '480': {
                slidesPerView: 3,
                spaceBetween: 10,
            },
            '767': {
                slidesPerView: 5,
                spaceBetween: 15,
            },
            '1024': {
                slidesPerView: 7,
                spaceBetween: 15,
            },
        }"
        :modules="modules"
        :navigation="true"
        class="mySwiper px-5"
    >
        <swiper-slide v-for="(category, index) in categories" :key="index">
            <div
                @click="
                    isChosen(category.id, category.name);
                    $emit('categoryClicked');
                "
                class="card"
            >
                <img
                    :src="`/storage/${category.img}`"
                    class="card-img-top"
                    alt="..."
                />
                <div class="card-body">
                    <h6
                        class="card-title m-0 p-0"
                        :class="{
                            '': !store.filterCategory.includes(category.id),
                            'is-chosen': store.filterCategory.includes(
                                category.id
                            ),
                        }"
                    >
                        <i
                            class="fa-solid fa-check"
                            :class="{
                                '': !store.filterCategory.includes(category.id),
                                'is-chosen': store.filterCategory.includes(
                                    category.id
                                ),
                            }"
                        ></i>
                        {{ category.name }}
                    </h6>
                </div>
            </div>
        </swiper-slide>
    </swiper>
</template>

<style scoped lang="scss">
@use "../../scss/_variables.scss" as *;

.mySwiper {
    height: 125px;
}
.card {
    height: 100%;
    cursor: pointer;

    img {
        height: 65%;
        object-fit: cover;
    }
    .card-body {
        display: flex;
        align-items: center;
        height: calc(100% - 65%);
        white-space: nowrap;
        h6 {
            text-overflow: ellipsis;
            overflow: hidden;
            color: $dark-gray;
            line-height: 1.5rem;
        }
        .fa-check {
            display: none;
        }
    }

    &:hover .card-title {
        display: inline-block;
        color: $orange;
    }

    .card-title.is-chosen,
    .fa-check.is-chosen {
        display: inline-block;
        color: $orange;
    }
}
</style>
