import { defineStore } from "pinia";
import { AuthResponseProps } from "../models/Auth.model";
import { getToken, onLogin, removeAuth, setAuth } from "../services/authService";

interface AuthState {
    data: AuthResponseProps,
    loading: boolean,
    error: any | null
}

export const useAuthStore = defineStore({
    id: 'auth',
    state: (): AuthState => ({
        data: {
            access_token: '',
            token_type: '',
            user: {
                id: '',
                name: '',
                email: ''
            }
        },
        loading: false,
        error: null
    }),
    getters: {
        accessToken: (state) => state.data.access_token,
        authUser: (state) => state.data.user,
        checkToken: () => getToken()
    },
    actions: {
        setAuth(auth: AuthResponseProps) {
            this.data = auth;
            setAuth(auth);
        },
        async onLogin(form: any) {
            try {
                this.error = null;
                this.loading = true;
                const { data } = await onLogin(form);
                this.setAuth(data);
                return Promise.resolve(data);
            } catch(err) {
                this.error = err;
                return Promise.reject(err);
            } finally {
                this.loading = false;
            }
        }, 
        removeAuth() {
            removeAuth();
            this.$reset();
        },
    }
})
