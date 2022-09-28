import { BaseProps } from "./Base.model";

export interface UserProps extends BaseProps {
    name: string,
    email: string,
    password?: string,
    avatar?: UserAvatarProps
}

export interface UserAvatarProps {
    data: string;
    file_name: string;
    media_type: string;
    user_id: string;
    src?: string;
}