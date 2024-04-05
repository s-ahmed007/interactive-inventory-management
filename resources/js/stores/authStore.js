import { defineStore } from 'pinia';

export const useAuthStore = defineStore('authStore', {
  state: () => ({
    user: null,
    token: null,
    reqHeader: null
  }),
  actions: {
    setAuthInfo(data, token) { // set auth info after login
        const tokenFromStorage = localStorage?.getItem('token');
        if(typeof tokenFromStorage == 'undefined' || tokenFromStorage == ''){
            this.removeAuthInfo()
            return
        }
        this.user = data
        this.token = token
        this.reqHeader = {'Authorization': `Bearer ${token}`}
      },
      removeAuthInfo() {
        this.user = null
        this.token = null
        this.reqHeader = null
        localStorage?.removeItem('token')
        localStorage?.removeItem('user')
      }
  },
});
