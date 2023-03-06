<script>
export default {
    name: "RestaurantItem",
    props: {
        restaurant: Object,
    },
};
</script>

<template>
    <div class="col">
        <router-link
            :to="{ name: 'restaurant', params: { slug: restaurant.slug } }"
            class="text-decoration-none"
        >
            <div class="card d-flex flex-row mb-5 mx-2">
                <div class="card-image">
                    <img
                        v-if="restaurant.img"
                        :src="`/storage/${restaurant.img}`"
                        :alt="restaurant.name"
                    />
                    <img
                        v-else
                        src="../../img/placeholder.png"
                        :alt="restaurant.name"
                    />
                </div>
                <div class="card-body">
                    <p class="card-title fw-bold">
                        {{ restaurant.name }}
                    </p>
                    <p class="card-text address">{{ restaurant.address }}</p>
                    <div class="category-box">
                        <span
                            v-for="category in restaurant.categories"
                            class="badge me-1 fw-normal"
                            >{{ category.name }}</span
                        >
                    </div>
                </div>
            </div>
        </router-link>
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

    .card-title {
        color: $dark-gray !important;
        text-overflow: ellipsis;
        overflow: hidden;
        font-size: 1.1rem;
    }

    .card-body {
        width: 100%;
        padding-left: 100px;
        white-space: nowrap;

        h5,
        p {
            color: $dark-gray;
        }

        h5 {
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
    }
}
</style>
