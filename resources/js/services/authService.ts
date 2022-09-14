import api from "../api";
import { AuthResponseProps } from "../models/Auth.model";
import { UserProps } from "../models/User.model";
import router from "../router";

export const onLogin = (form: any) => {
    return api.post<AuthResponseProps>('login', form, { headers: { 'SkipToken': true } });
}

export const onLogout = () => {
    return api.post('logout').then(() => removeAuth());
}

export const setAuth = (auth: AuthResponseProps): void => {
    localStorage.setItem('laravue@auth', JSON.stringify(auth));
}

export const getAuthUser = () => {
    return api.get<UserProps>('auth/user');
}

export const getToken = (): string | null => {
    try {
        return JSON.parse(localStorage?.getItem('laravue@auth') as string)?.access_token;
    } catch (error) {
        return null;
    }
}

export const removeAuth = (): void => {
    localStorage.removeItem('laravue@auth');
    router.push({ name: 'Login'});
}