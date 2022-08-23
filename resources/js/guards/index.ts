import { RouteLocationNormalized } from "vue-router";
import { getToken } from "../services/authService";

export const authGuard = (to: RouteLocationNormalized) => {
    const token = getToken();
    return token ? true : { path: '/login' };
}