<template>
    <div class="container mb-2 bg-white">
        <div class="row">
            <div class="category" :style="categoryStyle">
                &nbsp;
            </div>
            <div class="col pl-2 pr-0">
                <div class="container pl-0 pr-2">
                    <div class="row" v-on:click="editExpense">
                        <div class="col">{{ expense.description }}</div>
                        <div class="w-100"></div>
                        <div class="col-6">
                            <small>
                                {{ expense.created_at | formatDate('DD/MM/YYYY') }}
                            </small>
                        </div>
                        <div class="amount col-6 text-right font-weight-bold">
                            {{ expense.amount | formatCurrency(formatCurrencyOptions) }}
                        </div>
                    </div>
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
            categoryStyle() {
                const category = this.categories.find(category => category.id === this.expense.category_id)
                return {
                    'background-color': `#${category.color_hex}`
                }
            },
            formatCurrencyOptions() {
                const currency = this.currencies.find(currency => currency.id === this.expense.currency_id)
                return {
                    locale: currency.locale,
                    code: currency.code
                }
            }
        },
        methods: {
            editExpense() {
                this.$emit('editExpense', this.expense)
            }
        }
    }
</script>

<style>
    .category {
        flex: 0 0 5px;
    }
    .amount {
        font-size: 1.2em;
    }
</style>
