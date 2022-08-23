import axios from 'axios';
import { getToken, removeAuth } from '../services/authService';

const api = axios.create({
    baseURL: 'http://127.0.0.1:8000/api'
})

api.interceptors.request.use(
    (config: any) => {
        if(!config.headers['SkipToken']) {
            const token = getToken();
            if (token) config.headers['Authorization'] = 'Bearer ' + token;
        }
        return config;
    },
    (error) => Promise.reject(error),
)

api.interceptors.response.use(
    (res) => res,
    (err) => {
        if (err.response?.status === 401) removeAuth();
        return Promise.reject(err);
    },
)

export default api;