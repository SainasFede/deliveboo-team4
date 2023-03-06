import { createStore } from "vuex";
import Cart from "../class/Cart.js";

function updateLocalStorage(cart) {
  localStorage.setItem("cart", JSON.stringify(cart));
}

export default createStore({
  state: {
    cart: new Cart()
  },


  getters: {
    getCart: (state) => {
      return state.cart;
    }
  },

  mutations: {
    updateCart(state) {
      updateLocalStorage(state.cart);
    },

    updateCartFromLocalStorage(state) {
      const cartJson =  localStorage.getItem("cart");
      if (cartJson) {
        const cartStorage = JSON.parse(cartJson);
        state.cart = new Cart();
        state.cart.loadFromStorage(cartStorage);
      }
    },
  },
  actions: {},
  modules: {},
});
