import { UserProps } from "./User.model";

export interface AuthResponseProps {
    access_token: string,
    token_type: string,
    user: UserProps
}