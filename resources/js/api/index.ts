import axios from 'axios';
import { Notify } from 'quasar';
import router from '../router/index';
import { useAuthStore } from '../store/auth';

const baseAPI = (import.meta as any).env.VITE_API_URL;

const api = axios.create({ baseURL: baseAPI })

api.interceptors.request.use(
    (config: any) => {
        if (config?.headers['SkipToken']) {
            const token = useAuthStore().accessToken;
            if (token) config.headers['Authorization'] = 'Bearer ' + token;
        }
        return config;
    }
)

api.interceptors.response.use(
    (res) => res,
    (err) => {
        if (err.response?.status === 401) {
            router.push({ name: 'Login' });
            useAuthStore().removeAuth();
        }    
        Notify.create(
            {
                type: 'negative',
                position: window.innerWidth <= 600 ? 'top' : 'top-right',
                classes: window.innerWidth <= 600 ? 'full-width' : '',
                message: err?.response?.data?.message || 'Erro ao realizar requisição!',
                caption: err?.response?.status ? `Status: ${err?.response?.status}` : undefined
            });
        return Promise.reject(err);
    },
)

export default api;