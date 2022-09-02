import api from "../api";
import { AuthResponseProps } from "../models/Auth.model";

export const onLogin = (form: any) => {
    return api.post<AuthResponseProps>('login', form, { headers: { 'SkipToken': true } });
}

export const onLogout = () => {
    return api.post('logout');
}

export const setAuth = (auth: AuthResponseProps): void => {
    localStorage.setItem('vue-auth', JSON.stringify(auth));
}

export const getAuthUser = () => {
    return api.get('/');
}

export const getToken = (): string | null => {
    try {
        return JSON.parse(localStorage?.getItem('vue-auth') as string)?.access_token;
    } catch (error) {
        return null;
    }
}

export const removeAuth = (): void => {
    return localStorage.removeItem('vue-auth');
}