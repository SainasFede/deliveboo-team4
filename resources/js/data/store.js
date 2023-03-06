import { reactive } from "vue";

export const store = reactive({
    restaurants: [],
    categories: [],
    team_members: [],
    allRestaurants: [],
    restaurantsInEvidence: [],
    filterCategory: new Array(),
    selectedProducts: [],
    restaurant: [],
    searched: "",
    isLoading: false,
    typed: false,
    btnClicked: false,
    categoryClicked: [],
    showCreditCardInput: false,
});
