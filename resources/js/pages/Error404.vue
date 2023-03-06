<script>
export default {
    name: "Error404",
    mounted() {
        const all = document.querySelector(".all");
        all.addEventListener("animationiteration", () => {
            all.classList.add("all--animation-complete");
        });
    },
};
</script>

<template>
    <div class="all">
        <h2>404 Pagina non trovata</h2>
    </div>
</template>

<style lang="scss" scoped>
@use "../../scss/_variables.scss" as *;
.all {
    height: calc(100vh - 60px);
    background: url("https://t.ly/dXMr") no-repeat center center fixed;
    color: $white;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;

    h2 {
        font-size: 4rem;
    }
}
</style>
