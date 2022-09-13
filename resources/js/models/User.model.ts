import { BaseProps } from "./Base.model";

export interface UserProps extends BaseProps {
    name: string,
    email: string,
    password?: string,
}