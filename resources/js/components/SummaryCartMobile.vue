<script>
export default {
    name: "SummaryCartMobile",
    props: {
        amount: String,
        totalQuantity: Number,
    },
};
</script>

<template>
    <router-link :to="{ name: 'cart' }" class="text-decoration-none">
        <div
            class="riepilogo-bar d-flex justify-content-around align-items-center"
        >
            <div class="d-flex align-items-center">
                <span class="badge rounded-pill fs-6 me-1 fw-bold">{{
                    totalQuantity
                }}</span>
                <i class="fa-solid fa-cart-shopping fs-5"></i>
            </div>
            <span class="fw-bold">Vai al pagamento</span>
            <span class="fw-bold">{{ amount }}</span>
        </div>
    </router-link>
</template>

<style scoped lang="scss">
@use "../../scss/_variables.scss" as *;

a {
    color: $white;
}
.riepilogo-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    z-index: 998;
    width: 100%;
    height: 60px;
    background-color: $orange;

    .badge {
        background-color: $white;
        color: $orange;
    }
}
</style>
