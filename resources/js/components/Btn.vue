<script>
export default {
    name: "Btn",

    data() {
        return {
            isScrolledDown: false,
        };
    },

    methods: {
        scrollToTop() {
            window.scrollTo({ top: 0, behaviour: "smooth" });
            this.isScrolledDown = false;
        },
        handleScroll() {
            this.isScrolledDown = window.scrollY > 450;
        },
    },
    mounted() {
        window.addEventListener("scroll", this.handleScroll);
    },
};
</script>

<template>
    <button
        class="scroll-top-button"
        :class="{ hidden: !isScrolledDown }"
        @click="scrollToTop"
    >
        <i class="fas fa-chevron-up"></i>
    </button>
</template>

<style lang="scss" scoped>
@use "../../scss/_variables.scss" as *;

.scroll-top-button {
    z-index: 100;
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: $orange;
    color: $white;
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    font-size: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;

    &:hover {
        background-color: lighten($orange, 10%);
        color: $white;
    }
    &.hidden {
        display: none;
        pointer-events: none;
    }
}

@media all and (max-width: 480px) {
    .scroll-top-button {
        display: none;
    }
}
</style>
