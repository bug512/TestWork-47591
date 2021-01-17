<template>
    <div>
        <input-card-component
            @onCreate="refreshList"
            :updateId="id"
            :updateTitle="title"
            :updateUrl="url"
            :updateDescription="description"
        />
        <hr class="mt-4 mb-0">
        <div class="row">
            <div class="col-md-3 mt-4" v-for="site in sites">
                <site-card-component
                    :id="site.id"
                    :title="site.title"
                    :url="site.url"
                    :description="site.description"
                    @onDelete="refreshList"
                    @onUpdate="updateCard"
                />
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                sites: [],
                id: null,
                title: '',
                url: '',
                description: ''
            }
        },
        methods: {
            refreshList() {
                axios
                    .get('http://localhost/api/sitecard')
                    .then(response => (
                        this.sites = response.data.data
                    ))
            },
            updateCard(data) {
                this.id = data.id
                this.title = data.title
                this.url = data.url
                this.description = data.description
            }
        },
        mounted() {
            this.refreshList()
        }
    }
</script>
