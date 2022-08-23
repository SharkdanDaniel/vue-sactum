import api from "../api";

export type AuthResponseProps = {
    access_token: string,
    token_type: string,
    user: {
        name: string,
        email: string
    }
}

export const onLogin = (form: any) => {
    return api.post<AuthResponseProps>('login', form, { headers: { 'SkipToken': true } });
}

export const onLogout = () => {
    return api.post('logout');
}

export const setAuth = (auth: AuthResponseProps): void => {
    localStorage.setItem('vue-auth', JSON.stringify(auth));
}

export const getToken = (): string | undefined => {
    const auth = JSON.parse(localStorage?.getItem('vue-auth') || '');
    return auth?.access_token;
}

export const removeAuth = (): void => {
    return localStorage.removeItem('vue-auth');
}