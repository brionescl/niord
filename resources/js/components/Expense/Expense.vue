<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Expenses</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <expense-item
                            v-for="(expense, index) in expenses"
                            :key="expense.id"
                            :expense="expense"
                            @update="updateExpense(index, ...arguments)"
                            @delete="deleteExpense(index)"
                        >
                        </expense-item>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                expenses: []
            }
        },
        mounted() {
            axios.get('/expenses').then((response) => {
                this.expenses = response.data;
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
