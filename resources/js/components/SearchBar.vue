<script>
import { store } from "../data/store";
import axios from "axios";

export default {
    name: "SearchBar",
    data() {
        return {
            store,
            baseUrl: "http://127.0.0.1:8000/api/restaurants",
        };
    },
    methods: {
        startSearch() {
            if (store.searched) {
                store.typed = true;
                store.isLoading = true;
                axios
                    .get(this.baseUrl + "/search", {
                        params: {
                            searched: store.searched,
                        },
                    })
                    .then((result) => {
                        store.restaurants = result.data.restaurants;
                        store.isLoading = false;
                    });

                store.filterCategory = [];
                store.categoryClicked = [];
            } else {
                store.restaurants = [];
                store.filterCategory = [];
                store.categoryClicked = [];
                store.btnClicked = true;
            }
        },
    },
};
</script>
<template>
    <div class="container d-flex justify-content-center p-0">
        <div class="input-group">
            <input
                type="text"
                class="form-control"
                aria-label="Recipient's username"
                aria-describedby="button-addon2"
                v-model.trim="store.searched"
                @keyup.enter="startSearch()"
                @keydown="
                    store.typed = false;
                    store.btnClicked = false;
                "
                placeholder="Cerca un ristorante per nome..."
            />
            <button
                class="btn my-btn-color fw-bold"
                type="button"
                id="button-addon2"
                @click="startSearch()"
            >
                Cerca
            </button>
        </div>
    </div>
</template>
<style lang="scss" scoped>
@use "../../scss/_variables.scss" as *;

.my-btn-color {
    background-color: $orange;
    color: $white;
    &:hover {
        background-color: lighten($orange, 10%);
        color: $white;
    }
}

.input-group {
    width: 50%;
    border-radius: 10px;
    box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.25);

    .form-control {
        border: none;
        &:focus {
            border-color: $orange;
            box-shadow: 0 0 0 0.2rem rgba(241, 90, 37, 0.25);
        }
    }
}

@media all and (max-width: 480px) {
    .input-group {
        width: 100%;
        padding: 0;
        margin: 0;
    }
}
</style>
