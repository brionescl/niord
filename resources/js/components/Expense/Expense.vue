<template>
    <div class="container-fluid">
        <ExpenseCurrencyFilter
            v-show="!isLoadingExpenses"
            :expenses="expenses"
            :currencies="currencies"
            :defaultCurrency="defaultCurrency"
            @updateDefaultCurrency="updateDefaultCurrency"
        />
        <div class="row">
            <div class="col">
                <BaseLoading v-show="isLoadingExpenses" />
                <ExpenseItem
                    v-show="!isLoadingExpenses"
                    v-for="expense in filteredExpenses"
                    :key="expense.id"
                    :expense="expense"
                    :categories="categories"
                    :currencies="currencies"
                    @editExpense="editExpense"
                />
            </div>
        </div>
        <div id="newExpenseButton" v-show="!isLoadingExpenses">
            <button class="btn btn-primary font-weight-bold" v-on:click="newExpense">
                <svg id="i-plus" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="24" height="24" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3">
                    <path d="M16 2 L16 30 M2 16 L30 16" />
                </svg>
            </button>
        </div>
        <ExpenseForm
            ref="expenseForm"
            :expense="expense"
            :categories="categories"
            :currencies="currencies"
            :editMode="expenseFormEditMode"
            @addExpenseItem="addExpenseItem"
            @updateExpenseItem="updateExpenseItem"
            @deleteExpenseItem="deleteExpenseItem"
            @cancelEditExpense="cancelEditExpense"
        />
    </div>
</template>

<script>
    import ExpenseForm from './ExpenseForm'
    import ExpenseItem from './ExpenseItem'
    import ExpenseCurrencyFilter from './ExpenseCurrencyFilter'

    export default {
        components: {
            ExpenseForm,
            ExpenseItem,
            ExpenseCurrencyFilter
        },
        data() {
            return {
                categories: [],
                defaultCategory: {},
                currencies: [],
                defaultCurrency: {},
                expenses: [],
                expense: {},
                cachedExpense: {},
                isLoadingExpenses: true,
                expenseFormEditMode: false
            }
        },
        created() {
            const self = this
            Promise.all([
                axios.get('/categories'),
                axios.get('/currencies'),
                axios.get('/expenses')
            ]).then(function ([categories, currencies, expenses]) {
                self.categories = categories.data
                self.defaultCategory = JSON.parse(JSON.stringify(self.categories[0]))

                self.currencies = currencies.data
                self.defaultCurrency = JSON.parse(JSON.stringify(self.currencies[0]))

                self.expenses = expenses.data
                self.isLoadingExpenses = false
            })
        },
        computed: {
            filteredExpenses() {
                return this.expenses.filter((expense) => {
                    if (expense.currency_id == this.defaultCurrency.id) {
                        return true
                    }

                    return false
                })
            }
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
                    category_id: this.defaultCategory.id,
                    currency_id: this.defaultCurrency.id
                }
                this.expenseFormEditMode = false
                this.showExpenseForm()
            },
            editExpense(expense) {
                this.expense = expense
                this.cachedExpense = JSON.parse(JSON.stringify(expense))
                this.expenseFormEditMode = true
                this.showExpenseForm()
            },
            findIndexExpense(expense) {
                return this.expenses.findIndex(e => e.id === expense.id)
            },
            cancelEditExpense(expense) {
                if (this.expenseFormEditMode) {
                    const index = this.findIndexExpense(expense)

                    if (index != -1) {
                        Vue.set(this.expenses, index, this.cachedExpense)
                        this.expense = {}
                        this.cachedExpense = {}
                    }
                }

                this.hideExpenseForm()
            },
            addExpenseItem(expense) {
                this.expenses.push(expense)
                this.hideExpenseForm()
            },
            updateExpenseItem(expense) {
                const index = this.findIndexExpense(expense)

                if (index != -1) {
                    Vue.set(this.expenses, index, expense)
                    this.hideExpenseForm()
                }
            },
            deleteExpenseItem(expense) {
                const index = this.findIndexExpense(expense)

                if (index != -1) {
                    this.expenses.splice(index, 1)
                    this.hideExpenseForm()
                }
            },
            findIndexCurrency(currencyId) {
                return this.currencies.findIndex(e => e.id === currencyId)
            },
            updateDefaultCurrency(currency) {
                const index = this.findIndexCurrency(currency)
                this.defaultCurrency = JSON.parse(JSON.stringify(this.currencies[index]))
            }
        }
    }
</script>

<style>
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
