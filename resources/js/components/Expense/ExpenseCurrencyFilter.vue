<template>
    <div class="row sticky-top total">
        <div class="col">
            <h4 class="mt-4 mb-3">Expenses</h4>
        </div>
        <div class="col">
            <div class="input-group">
                <select
                    class="form-control mt-3 mb-3"
                    v-model="currency"
                    v-on:change="updateDefaultCurrency"
                >
                    <option
                        v-for="currency in currencies"
                        :key="currency.id"
                        :value="currency.id"
                    >
                        {{ currency.name }}
                    </option>
                </select>
                <div class="input-group-append">
                    <span class="input-group-text mt-3 mb-3">{{ total | formatCurrency(formatCurrencyOptions)}}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        'expenses': Array,
        'currencies': Array,
        'defaultCurrency': Object
    },
    data() {
        return {
            'currency': null
        }
    },
    computed: {
        total() {
            if (!this.currency) {
                return 0
            }

            return this.expenses.reduce((total, expense) => {
                if (expense.currency_id == this.currency) {
                    return total + parseFloat(expense.amount)
                }

                return total
            }, 0)
        },
        formatCurrencyOptions() {
            if (!this.currency) {
                return
            }

            const currency = this.currencies.find(currency => currency.id === this.currency)

            return {
                locale: currency.locale,
                code: currency.code
            }
        }
    },
    watch: {
        defaultCurrency: function (currency, oldCurrency) {
            if (currency.id) {
                this.currency = currency.id
            }
        }
    },
    methods: {
        updateDefaultCurrency() {
            this.$emit('updateDefaultCurrency', this.currency)
        }
    }
}
</script>

<style>
    .total {
        background-color: #f8fafc;
        top: 3.5em;
    }
</style>
