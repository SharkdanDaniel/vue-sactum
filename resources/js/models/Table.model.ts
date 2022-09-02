export interface TableColumns {
    name?: string;
    label?: string;
    field?: string;
    sortable?: boolean;
    required?: boolean;
    isInnerHtml?: boolean;
    sort?: (a: any, b: any, rowA: any, rowB: any) => any;
    sortOrder?: 'ad' | 'da';
    format?: (val: any, row: any) => String;
    style?: string;
    align?: string;
    class?: string;   
}

export interface TableAction {
    icon: string;
    eventName?: string;
    class?: string;
    color?: string;
}

export interface PaginatorProps {
    descending: boolean;
    page: number;
    rowsPerPage: number;
    rowsNumber?: number;
    sortBy?: string;
}