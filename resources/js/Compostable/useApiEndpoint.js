import {getCurrentInstance, ref} from "vue";


export function useApiEndpoint(instance) {
    return instance.appContext.config.globalProperties.$apiEndpoint;
}
