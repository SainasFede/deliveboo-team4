<script>
export default {
    name: "Footer",
};
</script>

<template>
    <footer>
        <div class="container d-flex justify-content-between py-5">
            <div class="box-col">
                <h3>Scopri DeliveBoo</h3>
                <ul>
                    <li>
                        <a href="#" class="">Investitori</a>
                    </li>

                    <li>
                        <a href="#" class="">Chi siamo</a>
                    </li>

                    <li>
                        <a href="#" class="">Ristoranti</a>
                    </li>

                    <li>
                        <a href="#" class="">Altro</a>
                    </li>

                    <li>
                        <a href="#" class="">Pressroom</a>
                    </li>

                    <li>
                        <a href="#" class="">Programmazione</a>
                    </li>

                    <li>
                        <a href="#" class="">Design</a>
                    </li>

                    <li>
                        <a href="#" class="">Lavora con noi</a>
                    </li>

                    <li>
                        <a href="#" class="">Diventa nostro partner</a>
                    </li>
                </ul>
            </div>

            <div class="box-col">
                <h3>Note Legali</h3>
                <ul>
                    <li>
                        <a href="#" class="">Termini & Condizioni</a>
                    </li>

                    <li>
                        <a href="#" class="">Chi siamo</a>
                    </li>

                    <li>
                        <a href="#" class="">Ristoranti</a>
                    </li>
                </ul>
            </div>

            <div class="box-col">
                <h3>Aiuto</h3>
                <ul>
                    <li>
                        <a href="#" class="">Contatti</a>
                    </li>

                    <li>
                        <a href="#" class="">FAQ</a>
                    </li>

                    <li>
                        <a href="#" class="">Tipi di cucina</a>
                    </li>
                </ul>
            </div>
            <div class="box-col img">
                <div class="deliveboo-logo d-flex align-items-center">
                    <a href="#">
                        <img src="../../img/logo.png" alt="" />
                        <span class="fs-2 fw-bold"> DeliveBoo </span>
                    </a>
                </div>
                <div class="boolean-logo d-flex align-items-center">
                    <a href="https://boolean.careers/">
                        <img src="../../img/boolean-logo.png" alt="" />
                        <span class="fs-2 fw-bold"> Boolean </span>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>

<style lang="scss" scoped>
@use "../../scss/_variables.scss" as *;

footer {
    height: 100%;
    width: 100%;
    background-color: $dark-gray;

    .box-col {
        display: flex;
        flex-direction: column;
        width: calc(100% / 3);
        //padding: 40px 80px;
        h3 {
            color: $light-gray;
        }
        ul {
            text-decoration: none;
            padding: 0;
            a {
                color: $light-gray;
                &:hover {
                    text-decoration: underline;
                }
            }
        }

        .boolean-logo,
        .deliveboo-logo {
            height: calc(100% / 2);
            img {
                width: 70px;
                margin-right: 30px;
            }
            span {
                font-size: 1.15rem;
                color: $light-gray;
            }
        }
    }
}

@media all and (max-width: 480px) {
    .container {
        // margin-bottom: 60px;
        flex-direction: column;
        justify-content: center;
        padding: 0 40px;
        h3 {
            width: 100%;
        }

        .box-col {
            width: 100%;
        }

        .box-col.img {
            flex-direction: row;
            justify-content: space-between;

            img {
                width: 40px;
            }
            span {
                font-size: 1rem;
                color: $light-gray;
            }
        }
    }
}
</style>
