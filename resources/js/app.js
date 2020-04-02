import Vue from 'vue'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'
import GitHubAPI from 'vue-github-api';
import App from './components/App'
import Welcome from './components/Welcome'
import Users from './components/Users'
import UsersIndex from './components/UsersIndex';
import NotFound from './components/NotFound';

var VueScrollTo = require('vue-scrollto');

Vue.use(VueRouter);
Vue.use(VueResource);

Vue.use(
    VueScrollTo, {
        container: "body",
        duration: 1000,
        easing: "ease",
        offset: -20,
        force: true,
        cancelable: true,
        onStart: false,
        onDone: false,
        onCancel: false,
        x: false,
        y: true
    }
);

Vue.use(GitHubAPI, {token: 'd700009f8d9b0c8014352b995250d590f4d70fa1'});

const router = new VueRouter(
    {
        mode: 'history',
        routes: [
            {
                path: '/',
                name: 'welcome',
                component: Welcome,
                props: {title: "Welcome to the Test"}
            },
            {
                path: '/users',
                name: 'users',
                component: Users,
                props: {title: "List of Test Accounts"}
            },
            {
                path: '/users/:id',
                name: 'users.index',
                component: UsersIndex,
                props: {title: "Test Account Details"}
            },
            {
                path: '/404',
                name: '404',
                component: NotFound
            },
            {
                path: '*',
                redirect: '/404'
            },
        ],
    }
);

const app = new Vue(
    {
        el: '#app',
        components: {App},
        router
    }
);
