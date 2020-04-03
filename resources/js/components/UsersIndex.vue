<template>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                {{title}}
            </div>

            <div v-if="! loaded">
                <div class="spinner-border text-dark" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div v-else>
                <div class="users p-sm-2 p-md-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item flex-column align-items-start pt-4 mb-3">
                            <h5 class="mb-1">Name: {{ user.name }}</h5>
                            <h5 class="mb-1">GitHub Username: {{ user.github_username }}</h5>
                            <p>
                                Repositories grabbed (up to 50)
                                <span class="badge badge-primary badge-pill">{{ repositoriesCount }}</span>
                            </p>
                        </li>
                    </ul>
                </div>

                <div v-if="repositoriesCount > 0">
                    <h4 class="mb-3">{{ user.name }}&apos;s Repositories</h4>
                    <div class="list-group list-group-flush user-repo-list">
                        <a v-for="repo in processedRepos"
                           v-on:click="handleSelectRepo(repo.name)"
                           v-scroll-to="'#commits'"
                           class="list-group-item list-group-item-action mb-3">
                            <div class="d-flex w-100 justify-content-between mt-2 mb-2">
                                <h5><strong>{{ repo.name }}</strong></h5>
                                <small>Watchers
                                    <span class="badge badge-secondary badge-pill">{{ repo.watchers_count }}</span>
                                </small>
                            </div>
                            <hr/>
                            <p v-if="repo.description" class="text-left mt-2 mb-2">
                                {{ repo.description }}
                            </p>
                            <small v-if="repo.owner" class="d-block text-left mt-1 mb-2">
                                <img v-bind:src="repo.owner.avatar_url" alt="GitHub Avatar" class="avatar">
                                <span class="author">
                                by <a :href="repo.owner.html_url" target="_blank">
                                {{ repo.owner.login }}</a>
                            </span> updated at <span class="date">{{ repo.updated_at | formatDate }}</span>
                            </small>
                        </a>
                    </div>
                </div>

                <div v-if="selectedRepo" id="commits" class="mt-5 mb-5">
                    <h4>You are viewing the latest <strong>master branch</strong> commits for the <strong>
                        {{ selectedRepo }}</strong> GitHub Repository
                    </h4>
                </div>

                <div v-if="processedCommits" class="list-group list-group-flush user-repo-commit-list mb-5">
                    <a v-for="record in processedCommits"
                       :href="record.html_url" target="_blank"
                       class="list-group-item list-group-item-action flex-column align-items-start mb-1 commit">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mt-1">{{ record.commit.message | truncate }}</h6>
                            <small>
                                <span class="badge badge-pill badge-light">{{ record.sha.slice(0, 7) }}</span>
                            </small>
                        </div>
                        <hr/>
                        <small v-if="record.author" class="d-block text-left mb-2">
                            <img v-bind:src="record.author.avatar_url" alt="GitHub Avatar" class="avatar">
                            <span class="author">
                                committed by <a :href="record.author.html_url" target="_blank">
                                {{ record.commit.author.name }}</a>
                            </span> on <span class="date">{{ record.commit.author.date | formatDate }}</span>
                        </small>
                        <small v-else class="d-block text-left">
                            <span class="author">
                                committed by {{ record.commit.author.name }}
                            </span> on <span class="date">{{ record.commit.author.date | formatDate }}</span>
                        </small>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import api from '../api/users';

    export default {
        data() {
            return {
                loaded: false,
                info: null,
                userGitHubRepoData: {},
                userGitHubRepoCommitData: {},
                selectedRepo: null,
                user: {
                    id: null,
                    name: "",
                    github_username: "",
                }
            };
        },
        computed: {
            repositoriesCount: function () {
                if (this.userGitHubRepoData.repositories) {
                    return this.userGitHubRepoData.repositories.length
                }
                return 'none yet...'
            },
            processedRepos: function () {
                if (this.userGitHubRepoData.repositories) {
                    return this.userGitHubRepoData.repositories
                }
            },
            processedCommits: function () {
                if (this.userGitHubRepoCommitData.commits) {
                    return this.userGitHubRepoCommitData.commits
                }
            }
        },
        created() {
            api.find(this.$route.params.id)
                .then((response) => {
                    this.user = response.data.data;

                    this.GitHubAPI.get(
                        '/users/' + this.user.github_username + '/repos?per_page=50&visibility=public&type=owner',
                        {},
                        [this.userGitHubRepoData, 'repositories'], ''
                    );

                    setTimeout(() => {
                        this.loaded = true;
                    }, 1200);
                })
                .catch((err) => {
                    this.$router.push({name: '404'});
                });
        },
        filters: {
            truncate: function (v) {
                var newline = v.indexOf("\n");
                return newline > 0 ? v.slice(0, newline) : v;
            },
            formatDate: function (v) {
                return v.replace(/T|Z/g, " ");
            }
        },
        methods: {
            fetchCommitData: function (selectedRepo) {
                this.GitHubAPI.get(
                    '/repos/' + this.user.github_username + '/' + selectedRepo + '/commits',
                    {},
                    [this.userGitHubRepoCommitData, 'commits'], ''
                );
            },
            handleSelectRepo(repo) {
                this.selectedRepo = repo;
                this.fetchCommitData(this.selectedRepo);
            }
        },
        props: ['title']
    };
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

    .content small a {
        text-align: left;
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
