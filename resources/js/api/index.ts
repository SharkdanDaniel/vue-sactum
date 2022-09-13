import axios from 'axios';
import { env } from 'process';
import { Notify } from 'quasar';
import router from '../router/index';
import { getToken, removeAuth } from '../services/authService';

const api = axios.create({ baseURL: env.APP_API })

api.interceptors.request.use(
    (config: any) => {
        if (config?.headers['SkipToken']) {
            const token = getToken();
            if (token) config.headers['Authorization'] = 'Bearer ' + token;
        }
        return config;
    },
    (err) => {
        if (err.response?.status === 401) removeAuth();
        Notify.create(
            {
                type: 'negative',
                message: err?.response?.data?.message || 'Erro ao realizar requisição!',
                caption: err?.response?.status ? `Status: ${err?.response?.status}` : undefined
            });
        router.push({ name: 'Login' })
        return Promise.reject(err);
    }
)

export default api;