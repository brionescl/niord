<template>
    <div class="container mb-2 bg-white">
        <div class="row">
            <div class="category" v-bind:style="style">
                &nbsp;
            </div>
            <div class="col pl-2 pr-0">
                <div class="container pl-0 pr-2">
                    <div class="row">
                        <div class="col">{{ expense.description }} {{ expense.category.color_hex }}</div>
                        <div class="w-100"></div>
                        <div class="col-6">
                            <small>
                                {{ expense.created_at | formatDate('DD/MM/YYYY') }}
                            </small>
                        </div>
                        <div class="amount col-6 text-right font-weight-bold">
                            {{ expense.amount | formatCurrency(expense.currency.code, expense.currency.locale) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['expense'],
        computed: {
            style: function() {
                return {
                    'background-color': '#' + this.expense.category.color_hex
                }
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
