<template>
    <li class="list-group-item">
        <div class="container">
            <div class="row">
                <div class="col">{{ expense.created_at }}</div>
                <div class="col-8">{{ expense.description }}</div>
                <div class="col">{{ expense.amount }}</div>
            </div>
        </div>
    </li>
</template>

<script>
    export default {
        props: ['expense']
    }
</script>
