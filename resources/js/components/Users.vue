<template>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                {{title}}
            </div>

            <div class="users p-sm-2 p-md-4">
                <div v-if="error" class="error">
                    <p>{{ error }}</p>
                </div>

                <ul v-if="users" class="list-group list-group-flush mb-5">
                    <li v-for="{ id, name, github_username } in users"
                        class="list-group-item mb-3">
                        <h5 class="mb-1">Name: {{ name }}</h5>
                        <h5 class="mb-1">GitHub Username: {{ github_username }}</h5>
                        <router-link :to="{ name: 'users.index', params: { id } }" class="btn btn-primary">
                            View {{ name }}&apos;s GitHub Repos
                        </router-link>
                    </li>
                </ul>

                <div class="pagination">
                    <button :disabled="! prevPage" @click.prevent="goToPrev">Previous</button>
                    {{ paginatonCount }}
                    <button :disabled="! nextPage" @click.prevent="goToNext">Next</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';

    const getUsers = (page, callback) => {
        const params = {page};

        axios
            .get('/api/users', {params})
            .then(response => {
                callback(null, response.data);
            }).catch(error => {
            callback(error, error.response.data);
        });
    };

    export default {
        data() {
            return {
                users: null,
                meta: null,
                links: {
                    first: null,
                    last: null,
                    next: null,
                    prev: null,
                },
                error: null,
            };
        },
        computed: {
            nextPage() {
                if (!this.meta || this.meta.current_page === this.meta.last_page) {
                    return;
                }

                return this.meta.current_page + 1;
            },
            prevPage() {
                if (!this.meta || this.meta.current_page === 1) {
                    return;
                }

                return this.meta.current_page - 1;
            },
            paginatonCount() {
                if (!this.meta) {
                    return;
                }

                const {current_page, last_page} = this.meta;

                return `${current_page} of ${last_page}`;
            },
        },
        beforeRouteEnter(to, from, next) {
            getUsers(to.query.page, (err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        // when route changes and this component is already rendered,
        // the logic will be slightly different.
        beforeRouteUpdate(to, from, next) {
            this.users = this.links = this.meta = null
            getUsers(to.query.page, (err, data) => {
                this.setData(err, data);
                next();
            });
        },
        methods: {
            goToNext() {
                this.$router.push({
                    query: {
                        page: this.nextPage,
                    },
                });
            },
            goToPrev() {
                this.$router.push({
                    name: 'users.index',
                    query: {
                        page: this.prevPage,
                    }
                });
            },
            setData(err, {data: users, links, meta}) {
                if (err) {
                    this.error = err.toString();
                } else {
                    this.users = users;
                    this.links = links;
                    this.meta = meta;
                }
            },
        },
        props: ['title']
    }
</script>
<style scoped>
    html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 100;
        height: 80vh;
        margin: 0;
    }

    .full-height {
        min-height: 80vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 30px;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .m-b-md {
        margin-bottom: 30px;
    }
</style>
