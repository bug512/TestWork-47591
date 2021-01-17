<template>
    <div class="row">
        <div class="col-md-4 mt-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="input-group">
                            <input type="text" class="form-control" v-model="title" placeholder="Name"
                                   aria-label="Name">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-link mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" v-model="url" placeholder="Link" aria-label="Link">
                        </div>
                    </div>
                    <div class="card-text mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Description</span>
                            </div>
                            <textarea class="form-control" aria-label="Description" v-model="description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="button" @click="clear" class="btn btn-outline-secondary btn-sm mr-2">Clear</button>
                    <button type="button" @click="save" class="btn btn-outline-primary btn-sm">Save</button>
                </div>
            </div>
        </div>
        <div class="toast" role="alert" aria-live="polite" aria-atomic="true" data-delay="3000"
             style="width: 300px; position: fixed; bottom: 30px; right: 30px;">
            <div class="toast-header">
                <strong class="text-danger mr-auto">Error</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                <ul class="list-group ">
                    <li class="list-group-item list-group-item-light" v-for="errorMessage in errorMessages">
                        <span class="text-danger" v-for="message in errorMessage">{{ message }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            updateId: null,
            updateTitle: '',
            updateUrl: '',
            updateDescription: '',
        },
        data() {
            return {
                title: '',
                url: '',
                description: '',
                errorMessages: [],
            }
        },
        watch: {
            updateId(value) {
                if (value) {
                    this.title = this.updateTitle
                    this.url = this.updateUrl
                    this.description = this.updateDescription
                }
            }
        },
        methods: {
            createRequest() {
                axios
                    .post('http://localhost/api/sitecard/', {
                        data: {
                            type: 'site_card',
                            attributes: {
                                action: 'create',
                                title: this.title,
                                url: this.url,
                                description: this.description,
                            }
                        }
                    })
                    .then((response) => {
                        this.$emit('onCreate')
                    })
                    .catch((error) => {
                        this.errorMessages = error.response.data.messages
                        $('.toast').toast('show')
                        this.$emit('onError')
                    })
            },
            updateRequest() {
                axios
                    .put('http://localhost/api/sitecard/' + this.updateId, {
                        data: {
                            type: 'site_card',
                            attributes: {
                                action: 'update',
                                title: this.title,
                                url: this.url,
                                description: this.description,
                            }
                        }
                    })
                    .then((response) => {
                        this.$emit('onCreate')
                    })
                    .catch((error) => {
                        this.errorMessages = error.response.data.messages
                        $('.toast').toast('show')
                        this.$emit('onError')
                    })
            },
            save() {
                if (this.updateId) {
                    this.updateRequest()
                } else {
                    this.createRequest()
                }
            },
            clear() {
                this.updateId = null
                this.updateTitle = ''
                this.updateUrl = ''
                this.updateDescription = ''
                this.title = ''
                this.url = ''
                this.description = ''
            }
        },
    }
</script>
