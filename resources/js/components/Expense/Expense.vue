<template>
    <div class="container-fluid">
        <div class="row sticky-top">
            <div class="col">
                <h4 class="mt-2 mb-2">Expenses</h4>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <base-loading v-show="isLoading"></base-loading>
                <expense-item
                    v-for="(expense, index) in expenses"
                    :key="expense.id"
                    :expense="expense"
                    @update="updateExpense(index, ...arguments)"
                    @delete="deleteExpense(index)"
                >
                </expense-item>
            </div>
        </div>
        <expense-add-button></expense-add-button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                expenses: [],
                isLoading: true
            }
        },
        mounted() {
            axios.get('/expenses').then((response) => {
                this.expenses = response.data;
                this.isLoading = false;
            });
        },
        methods: {
            addExpense(expense) {
                this.expenses.push(expense);
            },
            updateExpense(index, expense) {
                this.expenses[index] = expense;
            },
            deleteExpense(index) {
                this.expenses.splice(index, 1);
            }
        }
    }
</script>

<style>
    .sticky-top {
        background-color: #f8fafc;
        top: 3.5em;
    }
</style>
