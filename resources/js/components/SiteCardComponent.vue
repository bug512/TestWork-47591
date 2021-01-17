<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-start">
            <div @click="updateCard" title="click for edit" class="card-title">
                {{ title }}
            </div>
            <button @click="removeCard(id)" title="delete card" class="btn btn-outline-danger btn-sm btn-close">
                <i class="bi bi-x m-0"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="card-link mb-1">
                <a :href="url">{{ url }}</a>
            </div>
            <div class="card-text">
                <small>{{ description }}</small>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            id: '',
            title: '',
            url: '',
            description: '',
        },
        methods: {
            removeCard(id) {
                axios
                    .delete('http://localhost/api/sitecard/' + id)
                    .then(() => {
                        this.$emit('onDelete')
                    })
                    .catch(error => console.log(error));
            },
            updateCard() {
                this.$emit('onUpdate', {
                    id: this.id,
                    title: this.title,
                    url: this.url,
                    description: this.description,
                })
            },
        },
    }
</script>
