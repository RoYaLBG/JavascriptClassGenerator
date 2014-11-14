Object.prototype.inherits = function(parent) {
    this.prototype = Object.create(parent.prototype);
    this.prototype.constructor = this;
}

Object.prototype.isNullOrEmpty = function(field) {
    if (!field || field == null || field == '') {
        return true;
    }
    return false;
}

Object.prototype.isNumber = function(field) {
    if (field ^ 0 == field) {
        return true;
    }
    return false;
}

var Dessert = (function () {
    function Dessert(name,price,calories,quantityPerServing,timeToPrepare,isVegan,hasSugar) {
        Meal.call(this,name,price,calories,quantityPerServing,timeToPrepare,isVegan,hasSugar);
        this.setName(name);
        this.setPrice(price);
        this.setCalories(calories);
        this.setQuantityPerServing(quantityPerServing);
        this.setTimeToPrepare(timeToPrepare);
        this.setIsVegan(isVegan);
        this.setHasSugar(hasSugar);
    }

    Dessert.inherits(Meal);

    Dessert.prototype.setName = function(name) {
        if (this.isNullOrEmpty(name)) {
            throw new Error('The field should be a non-empty string');
        }
        this._name = name;
    }

    Dessert.prototype.getName = function() {
        return this._name;
    }

    Dessert.prototype.setPrice = function(price) {
        if (!this.isNumber(price)) {
            throw new Error('The field should be numeric');
        }
        this._price = price;
    }

    Dessert.prototype.getPrice = function() {
        return this._price;
    }

    Dessert.prototype.setCalories = function(calories) {
        if (!this.isNumber(calories)) {
            throw new Error('The field should be numeric');
        }
        this._calories = calories;
    }

    Dessert.prototype.getCalories = function() {
        return this._calories;
    }

    Dessert.prototype.setQuantityPerServing = function(quantityPerServing) {
        if (!this.isNumber(quantityPerServing)) {
            throw new Error('The field should be numeric');
        }
        this._quantityPerServing = quantityPerServing;
    }

    Dessert.prototype.getQuantityPerServing = function() {
        return this._quantityPerServing;
    }

    Dessert.prototype.setTimeToPrepare = function(timeToPrepare) {
        if (!this.isNumber(timeToPrepare)) {
            throw new Error('The field should be numeric');
        }
        this._timeToPrepare = timeToPrepare;
    }

    Dessert.prototype.getTimeToPrepare = function() {
        return this._timeToPrepare;
    }

    Dessert.prototype.setIsVegan = function(isVegan) {
        this._isVegan = isVegan;
    }

    Dessert.prototype.getIsVegan = function() {
        return this._isVegan;
    }

    Dessert.prototype.setHasSugar = function(hasSugar) {
        this._hasSugar = hasSugar;
    }

    Dessert.prototype.getHasSugar = function() {
        return this._hasSugar;
    }

    Dessert.prototype.toString = function() {
        return 'Name: ' + this.getName() + 'Price: ' + this.getPrice() + 'Calories: ' + this.getCalories() + 'QuantityPerServing: ' + this.getQuantityPerServing() + 'TimeToPrepare: ' + this.getTimeToPrepare() + 'IsVegan: ' + this.getIsVegan() + 'HasSugar: ' + this.getHasSugar();
    };

    return Dessert;
})();