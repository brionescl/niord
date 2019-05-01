<template>
    <div class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Expense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="category_id" class="sr-only">Category</label>
                            <select id="category_id" name="category_id" class="form-control" v-model="expense.category_id">
                                <option
                                    v-for="category in categories"
                                    :key="category.id"
                                    :selected="category.id == expense.category_id"
                                    :value="category.id"
                                >
                                    {{ category.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-4">
                            <label for="currency_id" class="sr-only">Currency</label>
                            <select id="currency_id" name="currency_id" class="form-control" v-model="expense.currency_id">
                                <option
                                    v-for="currency in currencies"
                                    :key="currency.id"
                                    :selected="currency.id == expense.currency_id"
                                    :value="currency.id"
                                >
                                    {{ currency.name }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-8">
                            <label for="amount" class="sr-only">Amount</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{ currencyCode }}</div>
                                </div>
                                <input
                                    id="amount"
                                    name="amount"
                                    type="text"
                                    pattern="\d*"
                                    class="form-control"
                                    :placeholder="currencyPlaceholder"
                                    v-model="expense.amount"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="description" class="sr-only">Description</label>
                            <textarea
                                id="description"
                                name="description"
                                class="form-control"
                                rows="3"
                                placeholder="Description"
                                v-model="expense.description"
                            >
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'categories',
        'currencies',
        'expense'
    ],
    computed: {
        currencyCode() {
            const currency = this.currencySelected()
            return currency ? currency.code : '$'
        },
        currencyPlaceholder() {
            const currency = this.currencySelected()

            if (currency) {
                return this.$options.filters.formatCurrency(
                    10000,
                    {
                        locale: currency.locale,
                        code: currency.code
                    }
                );
            }

            return 0
        }
    },
    methods: {
        currencySelected() {
            return this.currencies.find(currency => currency.id === this.expense.currency_id)
        }
    }
}
</script>
