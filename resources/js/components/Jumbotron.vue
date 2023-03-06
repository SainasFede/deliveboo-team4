<script>
export default {
    name: "Jumbotron",
};
</script>

<template>
    <div class="jumbotron" id="Home">
        <div class="container">
            <div class="col-left">
                <h2>I piatti che ami,<span></span></h2>
                <h2>a domicilio.<span></span></h2>
            </div>
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

    background: rgba(0, 0, 0, 0.5) url("../../img/jumbotron.jpg");
    background-blend-mode: darken;
    background-position: center 55%;
    background-repeat: no-repeat;
    background-size: cover;
    .container {
        padding: 0;
        .col-left {
            display: flex;
            flex-direction: column;
            align-items: start;
            h2 {
                font-size: 80px;
                color: transparent;
                position: relative;
                animation: text_reveal 0.5s ease forwards;
                animation-delay: 1s;

                span {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 0;
                    height: 100%;
                    animation: overlay 1s ease forwards;
                    animation-delay: 0.5s;
                    background-color: $orange;
                }
            }
        }
    }
}

.jumbotron .col-left h2:nth-child(1) {
    animation-delay: 1s;
}

.jumbotron .col-left h2:nth-child(2) {
    animation-delay: 2s;
}

.jumbotron .col-left h2:nth-child(1) span {
    animation-delay: 0.5s;
}

.jumbotron .col-left h2:nth-child(2) span {
    animation-delay: 1.5s;
}

@keyframes overlay {
    50% {
        width: 100%;
        left: 0;
    }
    100% {
        left: 100%;
        width: 0;
    }
}

@keyframes text_reveal {
    100% {
        color: $white;
    }
}

@media all and (max-width: 480px) {
    .jumbotron {
        height: 250px;

        .container {
            padding-left: 30px;
            .col-left {
                width: 100%;
                h2 {
                    font-size: 30px;
                    display: inline-block;
                }
            }
        }
    }
}
</style>
