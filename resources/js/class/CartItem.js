export default class CartItem {
    constructor(_product, _quantity = 1) {
        this._product = _product;
        this._quantity = _quantity;
    }

    get quantity() {
        return this._quantity;
    }

    get totalPrice() {
        return this._product.price * this._quantity;
    }

    get product() {
        return this._product;
    }

    increaseQuantity() {
        this._quantity++;
    }

    decreaseQuantity() {
        if (this._quantity > 0) {
            this._quantity--;
        }
    }

    toFormData() {
        return {
            product: this._product.id,
            quantity: this._quantity,
        };
    }
}
