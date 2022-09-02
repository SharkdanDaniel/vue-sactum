import { email, helpers, required } from "@vuelidate/validators";

export const requiredMsg = ($params?: any) => helpers.withMessage('Campo obrigatório', required);
export const emailMsg = ($params?: any) => helpers.withMessage('Email inválido', email);

export const getErrorMessage = (field: any) => field.$silentErrors[0]?.$message