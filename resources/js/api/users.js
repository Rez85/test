import axios from 'axios';

const client = axios.create(
    {
        baseURL: '/api',
    }
);

export default {
    all(params) {
        return client.get('users', params);
    },
    find(id) {
        return client.get(`users/${id}`);
    },
};
