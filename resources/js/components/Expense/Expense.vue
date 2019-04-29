<template>
    <div class="container-fluid">
        <div class="row sticky-top">
            <div class="col">
                <h4 class="mt-2 mb-2">Expenses</h4>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <base-loading v-show="isLoadingExpenses"></base-loading>
                <expense-item
                    v-show="!isLoadingExpenses"
                    v-for="expense in expenses"
                    :key="expense.id"
                    :expense="expense"
                    @editExpense="editExpense(...arguments)"
                >
                </expense-item>
            </div>
        </div>
        <div id="newExpenseButton" v-show="!isLoadingExpenses">
            <button class="btn btn-primary font-weight-bold" v-on:click="newExpense">
                <svg id="i-plus" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="24" height="24" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3">
                    <path d="M16 2 L16 30 M2 16 L30 16" />
                </svg>
            </button>
        </div>
        <expense-form
            ref="expenseForm"
            :expense="expense"
        >
        </expense-form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                expense: {},
                expenses: [],
                isLoadingExpenses: true
            }
        },
        mounted() {
            axios.get('/expenses').then((response) => {
                this.expenses = response.data
                this.isLoadingExpenses = false
            });
        },
        methods: {
            showExpenseForm() {
                let expenseForm = this.$refs.expenseForm.$el
                $(expenseForm).modal('show')
            },
            newExpense() {
                this.expense = {}
                this.showExpenseForm()
            },
            editExpense(expense) {
                this.expense = expense
                this.showExpenseForm()
            }
        }
    }
</script>

<style>
    .sticky-top {
        background-color: #f8fafc;
        top: 3.5em;
    }
    #newExpenseButton {
        position: fixed;
        bottom: 10px;
        right: 30px;
    }
    #newExpenseButton button {
        height: 60px;
        width: 60px;
        border-radius: 50%;
    }
</style>
