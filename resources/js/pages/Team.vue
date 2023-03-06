<script>
import axios from "axios";
import { store } from "../data/store";
export default {
    name: "Team",
    data() {
        return {
            baseUrl: "http://127.0.0.1:8000/api/restaurants/team_members",
            store,
        };
    },
    methods: {
        getTeamMembers() {
            axios.get(this.baseUrl).then((results) => {
                store.team_members = results.data.team_members;
                console.log(store.team_members);
            });
        },
    },
    mounted() {
        this.getTeamMembers();
    },
};
</script>

<template>
    <div class="container my-5">
        <div class="row">
            <div
                class="col-lg-4 col-md-6 col-sm-12"
                v-for="(team_member, index) in store.team_members"
                :key="index"
            >
                <div class="card mb-4">
                    <div class="card-info">
                        <div class="card-avatar">
                            <img
                                :src="`/storage/${team_member.img}`"
                                :alt="team_member.name"
                            />
                        </div>
                        <div class="card-title">
                            {{ team_member.name }} {{ team_member.surname }}
                        </div>
                        <div class="card-subtitle">Team 4 member</div>
                    </div>
                    <ul class="card-social">
                        <li class="card-social__item">
                            <a :href="team_member.li_link">
                                <i class="fa-brands fa-linkedin"></i>
                            </a>
                        </li>
                        <li class="card-social__item">
                            <a :href="team_member.gh_link">
                                <i class="fa-brands fa-github"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@use "../../scss/_variables.scss" as *;

.card {
    width: 100%;
    height: 400px;
    background: $light-gray;
    padding: 2rem 1.5rem;
    transition: box-shadow 0.3s ease, transform 0.2s ease;
}

.card-info {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    transition: transform 0.2s ease, opacity 0.2s ease;
}

/*Image*/
.card-avatar img {
    --size: 60px;
    background: linear-gradient(to top, #f1e1c1 0%, #fcbc97 100%);

    background-size: contain;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    transition: transform 0.2s ease;
    margin-bottom: 1rem;

    object-fit: cover;
}

/*Card footer*/
.card-social {
    transform: translateY(200%);
    display: flex;
    justify-content: space-around;
    width: 100%;
    opacity: 0;
    transition: transform 0.2s ease, opacity 0.2s ease;
    padding-left: 0;
}

.card-social__item {
    list-style: none;
    transition: fill 0.2s ease, transform 0.2s ease;
}

.card-social__item a {
    color: $dark_gray;
    cursor: pointer;
    transition: transform 0.15s ease;
    font-size: 1.4rem;
}

/*Text*/
.card-title {
    color: #333;
    font-size: 1.5em;
    font-weight: 600;
    line-height: 2rem;
}

.card-subtitle {
    color: #859ba8;
    font-size: 0.8em;
}

/*Hover*/
.card:hover {
    box-shadow: 0 8px 50px #23232333;
}

.card:hover .card-info {
    transform: translateY(-5%);
}

.card:hover .card-social {
    transform: translateY(100%);
    opacity: 1;
}

.card-social__item:hover {
    transform: scale(1.2);
}

.card-avatar img:hover {
    transform: scale(1.1);
}
</style>
