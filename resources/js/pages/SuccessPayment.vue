<script>
export default {
    name: "SuccessPayment",
};
</script>

<template>
    <div class="container ">
        <i class="fa-solid fa-circle-check"></i>
        <h2>Ordine avvenuto con successo!</h2>
    </div>
</template>

<style lang="scss" scoped>
@use "../../scss/_variables.scss" as *;

.container {
    min-height: calc(100vh - 60px - 370px);
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    color: $orange;

    .fa-circle-check{
        font-size: 4rem;
        margin-bottom: 30px;
    }
}

</style>
