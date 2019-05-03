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
                    :categories="categories"
                    :currencies="currencies"
                    @editExpense="editExpense"
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
            :categories="categories"
            :currencies="currencies"
            :editMode="expenseFormEditMode"
            @addExpenseItem="addExpenseItem"
            @updateExpenseItem="updateExpenseItem"
            @deleteExpenseItem="deleteExpenseItem"
        >
        </expense-form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                categories: [],
                currencies: [],
                expenses: [],
                expense: {
                    user_id: null,
                    category_id: null,
                    currency_id: null,
                    description: '',
                    amount: 0
                },
                isLoadingExpenses: true,
                expenseFormEditMode: false
            }
        },
        mounted() {
            const self = this
            Promise.all([
                axios.get('/categories'),
                axios.get('/currencies'),
                axios.get('/expenses')
            ]).then(function ([categories, currencies, expenses]) {
                self.categories = categories.data
                self.currencies = currencies.data
                self.expenses = expenses.data
                self.isLoadingExpenses = false
            })
        },
        methods: {
            showExpenseForm() {
                $(this.$refs.expenseForm.$el).modal('show')
            },
            hideExpenseForm() {
                $(this.$refs.expenseForm.$el).modal('hide')
            },
            newExpense() {
                this.expense = {
                    category_id: this.categories[0].id,
                    currency_id: this.currencies[0].id
                }
                this.expenseFormEditMode = false
                this.showExpenseForm()
            },
            editExpense(expense) {
                this.expense = expense
                this.expenseFormEditMode = true
                this.showExpenseForm()
            },
            addExpenseItem(expense) {
                this.expenses.push(expense)
                this.hideExpenseForm()
            },
            updateExpenseItem(expense) {
                const index = this.expenses.findIndex(e => e.id === expense.id)

                if (index != -1) {
                    this.expenses[index] = expense
                    this.hideExpenseForm()
                }
            },
            deleteExpenseItem(expense) {
                const index = this.expenses.findIndex(e => e.id === expense.id)

                if (index != -1) {
                    this.expenses.splice(index, 1)
                    this.hideExpenseForm()
                }
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
