import { forEach } from "lodash";
import CartItem from "./CartItem.js";

export default class Cart {
    constructor(_restaurant = null, _items = []) {
        this._restaurant = _restaurant;
        this._items = _items;
    }

    get amount() {
        return this._items.reduce((sum, item) => sum + item.totalPrice, 0);
    }

    get totalQuantity() {
        return this._items.reduce((sum, item) => sum + item.quantity, 0);
    }

    get items() {
        return this._items;
    }

    get restaurant() {
        return this._restaurant;
    }

    isEmpty() {
        return this._items.length === 0;
    }

    findItem(product) {
        return this._items.find((item) => item.product.id === product.id);
    }

    addItem(product, productRestaurant) {
        if (this.isEmpty()) {
            this._restaurant = productRestaurant;
            const newItem = new CartItem(product);
            this._items.push(newItem);
            return true;
        } else if (this._restaurant.id === product.restaurant_id) {
            const item = this.findItem(product);
            if (item) {
                item.increaseQuantity();
            } else {
                const newItem = new CartItem(product);
                this._items.push(newItem);
            }
            return true;
        } else {
            return false;
        }
    }

    decreaseItem(product) {
        const item = this.findItem(product);
        if (item) {
            item.decreaseQuantity();
            if (item.quantity === 0) {
                const indexItem = this._items.indexOf(item);
                this._items.splice(indexItem, 1);
            }
        }
    }

    deleteItem(product) {
        const item = this.findItem(product);
        if (item) {
            const indexItem = this._items.indexOf(item);
            this._items.splice(indexItem, 1);
        }
    }

    clear() {
        this._restaurant = null;
        this._items = [];
    }

    loadFromStorage(cartStorage) {
        this._restaurant = cartStorage._restaurant;
        cartStorage._items.forEach((item) => {
            this._items.push(new CartItem(item._product, item._quantity));
        });
    }

    toFormData() {
        return JSON.stringify({
            restaurant: this.restaurant.id,
            items: Array.from(this._items, (item) => item.toFormData()),
        });
    }
}
