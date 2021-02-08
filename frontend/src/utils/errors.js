export default class Errors {
    constructor() {
        this.errors = {};
    }

    get(field) {
        if (this.errors[field]) {
            return this.errors[field][0];
        }
    }

    record(errors) {
        this.errors = errors;
    }

    clear(field) {
        delete this.errors[field];
    }

    has(field) {
        return Object.prototype.hasOwnProperty.call(this.errors, field);
    }

    any() {
        return Object.keys(this.errors).length > 0;
    }
}