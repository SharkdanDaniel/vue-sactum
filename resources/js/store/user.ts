import { defineStore } from "pinia";
import { GetResponseProps } from "../models/GetResponse.model";
import { PaginatorProps } from "../models/Table.model";
import { UserProps } from "../models/User.model";
import { getUsers } from "../services/userService";

interface UserState {
    data: GetResponseProps<UserProps> | null,
    loading: boolean,
    error: any | null
}

export const useUserStore = defineStore({
    id: 'user',
    state: (): UserState => ({
        data: null,
        loading: false,
        error: null
    }),
    getters: {
        getUserById: (state) => state.data,
        // getUsers: (state) => state.data,
    },
    actions: {
        async getUsers(e?: PaginatorProps, search?: string) {
            try {
                this.error = null;
                this.loading = true;
                const { data } = await getUsers(e, search);
                return Promise.resolve(data);
            } catch(err) {
                this.error = err;
                return Promise.reject(err);
            } finally {
                this.loading = false;
            }
        },
        setUsers(data: GetResponseProps<UserProps>) {
            this.data = data
        }        
    }
})
