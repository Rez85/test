<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <ul class="navbar-nav">
                    <router-link :to="{ name: 'welcome' }" class="nav-link">Home</router-link>
                    <router-link :to="{ name: 'users' }" class="nav-link">Accounts</router-link>
                </ul>
            </div>
        </nav>
        <main>
            <div class="container">
                <router-view></router-view>
            </div>
        </main>
    </div>
</template>
<script>
    export default {}
</script>
