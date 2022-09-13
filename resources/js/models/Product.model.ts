import { BaseProps } from "./Base.model";

export interface ProductProps extends BaseProps {
    name: string,
    price: number,
    description: string,
}