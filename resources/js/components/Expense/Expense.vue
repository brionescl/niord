<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h4 class="mb-3">Expenses</h4>
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
