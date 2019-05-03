<template>
    <div class="modal fade" tabindex="-1" role="dialog">
        <form v-on:submit.prevent="handleSubmit">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">
                            <span v-if="editMode">Edit Expense</span>
                            <span v-else>New Expense</span>
                        </h5>
                        <button type="button" class="close" aria-label="Close" v-on:click="cancelEditExpense">
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
                        <button v-show="editMode" type="button" class="btn btn-danger" v-on:click="deleteExpense">
                            <svg id="i-trash" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="24" height="24" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" v-show="!isDeleting">
                                <path d="M28 6 L6 6 8 30 24 30 26 6 4 6 M16 12 L16 24 M21 12 L20 24 M11 12 L12 24 M12 6 L13 2 19 2 20 6" />
                            </svg>
                            <span v-show="isDeleting" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span v-if="editMode" v-show="!isSubmitting">Save changes</span>
                            <span v-else v-show="!isSubmitting">Save</span>
                            <span v-show="isSubmitting" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isSubmitting: false,
            isDeleting: false
        }
    },
    props: [
        'categories',
        'currencies',
        'expense',
        'editMode'
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
                )
            }

            return 0
        }
    },
    methods: {
        currencySelected() {
            return this.currencies.find(currency => currency.id === this.expense.currency_id)
        },
        handleSubmit() {
            const params = {
                category_id: this.expense.category_id,
                currency_id: this.expense.currency_id,
                amount: this.expense.amount,
                description: this.expense.description
            }

            this.isSubmitting = true

            if (this.editMode) {
                this.putExpense(params)
                return
            }

            this.postExpense(params)
            return
        },
        putExpense(params) {
            const self = this

            axios
                .put(`/expenses/${self.expense.id}`, params)
                .then(response => {
                    self.$emit('updateExpenseItem', response.data)
                    self.$snotify.success('Expense modified');
                })
                .catch(error => {
                    self.$snotify.error(error.response.statusText, `Error ${error.response.status}`);
                })
                .then(function () {
                    self.isSubmitting = false
                })
        },
        postExpense(params) {
            const self = this

            axios
                .post('/expenses', params)
                .then(response => {
                    self.$emit('addExpenseItem', response.data)
                    self.$snotify.success('Expense added');
                })
                .catch(error => {
                    self.$snotify.error(error.response.statusText, `Error ${error.response.status}`);
                })
                .then(function () {
                    self.isSubmitting = false
                })
        },
        deleteExpense() {
            const self = this
            self.isDeleting = true

            if (confirm('Are you sure you want to delete?')) {
                axios
                    .delete(`/expenses/${self.expense.id}`)
                    .then(response => {
                        self.$emit('deleteExpenseItem', self.expense)
                        self.$snotify.success('Expense deleted');
                    })
                    .catch(error => {
                        self.$snotify.error(error.response.statusText, `Error ${error.response.status}`);
                    })
                    .then(function () {
                        self.isDeleting = false
                    })
            } else {
                self.isDeleting = false
            }
        },
        cancelEditExpense() {
            this.$emit('cancelEditExpense', this.expense)
        }
    }
}
</script>
