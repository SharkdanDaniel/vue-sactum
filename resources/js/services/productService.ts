import api from '../api'
import { GetResponseProps } from '../models/GetResponse.model'
import { ProductProps } from '../models/Product.model'
import { PaginatorProps } from '../models/Table.model'

export const getProducts = (
    e: PaginatorProps = {
        page: 1,
        descending: false,
        rowsPerPage: 10,
        sortBy: 'updated_at',
    },
    search?: string,
) => {
    return api.get<GetResponseProps<ProductProps>>(
        `products?page=${e.page}&per_page=${e.rowsPerPage}&order_by=${e.sortBy ?? 'updated_at'
        }&sort=${e.descending ? 'desc' : 'asc'}${search ? '&search=' + search : ''
        }`,
    )
}

export const getProductById = (id: string) => {
    return api.get<ProductProps>(`products/${id}`)
}

export const createProduct = (product: ProductProps) => {
    return api.post<ProductProps>(`products`, product)
}

export const updateProduct = (product: ProductProps) => {
    return api.put<ProductProps>(`products/${product.id}`, product)
}

export const deleteProduct = (id: string) => {
    return api.delete<boolean>(`products/${id}`)
}

export const deleteAllProducts = (products: ProductProps[]) => {
    return api.patch<boolean>(`products/delete`, products)
}
