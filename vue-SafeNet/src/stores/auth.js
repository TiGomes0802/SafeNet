import {ref } from 'vue'
import {defineStore} from 'pinia'
import axios from 'axios'
import { useRouter } from 'vue-router'
import { useErrorStore } from "@/stores/error";
import { useCoinsStore } from "@/stores/coins";
import { useCursoStore } from '@/stores/curso';
import { useMissaoStore } from '@/stores/missao';

export const useAuthStore = defineStore('auth', () => {
    const router = useRouter()
    const storeError = useErrorStore();
    const storeCoins = useCoinsStore();
    const storeCurso = useCursoStore();
    const storeMissao = useMissaoStore();
    
    //const { toast } = Toaster()
    
    const user = ref(null)
    const token = ref(null)

    const errorLogin = ref(null)
    const errorResgistar = ref(null)

    let intervalToRefreshToken = null;
    const resetIntervalToRefreshToken = () => {
      if (intervalToRefreshToken) {
        clearInterval(intervalToRefreshToken);
      }
      intervalToRefreshToken = null;
    };

    const clearUser = () => {
      resetIntervalToRefreshToken();  
      user.value = null;
      axios.defaults.headers.common.Authorization = "";
      localStorage.removeItem("token");
    };

    const repeatRefreshToken = () => {
        if (intervalToRefreshToken) {
          clearInterval(intervalToRefreshToken);
        }
        intervalToRefreshToken = setInterval(async () => {
          try {
            const response = await axios.post("auth/refreshtoken");
            token.value = response.data.token;
            axios.defaults.headers.common.Authorization = "Bearer " + token.value;
            localStorage.setItem("token", token.value);
            return true;
          } catch (e) {
            clearUser();
            storeError.setErrorMessages(
              e.response.data.message,
              e.response.data.errors,
              e.response.status,
              "Authentication Error!"
            );
            return false;
          }
        }, 1000 * 60 * 110); // repeat every 110 minutes
        // To test the refresh token, replace previous line with the following code
        // This will repeat the refreshtoken endpoint every 10 seconds:
        //}, 1000 * 10)
        return intervalToRefreshToken;
      };

    const login = async (credentials) => {
        storeError.resetMessages();
        try{
          const responseLogin = await axios.post("auth/login", credentials);
          token.value = responseLogin.data.token;
          axios.defaults.headers.common.Authorization = `Bearer ${token.value}`;
          localStorage.setItem("token", token.value);
          await getUser();
          storeCurso.getCursos();
          if (user.value.type == "J") {
            storeMissao.getMinhasmissoes();
            storeCoins.getCoins();
          }
          repeatRefreshToken();
          router.push({name: "home"});
          return user.value;
        } catch (e) {
            clearUser();
            console.log(e.response.data.message);
            if (e.response.data.message == "Unauthorized") {
                errorLogin.value = true;
                console.log("Unauthorized");
            }else{
              storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Authentication Error!"
              );
            }
            return false;
        }
    }

    const getUser = async () => {
      try {
        const responseUser = await axios.get("users/me");
        user.value = responseUser.data.data;
        return true
      } catch (error) {
        clearUser();
        storeError.setErrorMessages(
          error.response.data.message,
          error.response.data.errors,
          error.response.status,
          "Authentication Error!"
        );
        return false;
      }
    }

    const register = async (credentials) => {
      errorResgistar.value = null;
      storeError.resetMessages(); // Reseta mensagens de erro antes de iniciar
      try {
        await axios.post("auth/register", credentials);
        await login({
          email: credentials.email,
          password: credentials.password,
        });

      } catch (e) {
        storeError.setErrorMessages(
          e.response.data.message,
          e.response.data.errors,
          e.response.status,
          "Registration Error!"
        );
        console.log(e.response.data);
        if (e.response?.data.errors != null) {
          if (e.response.data.errors.username == "Já existe um utilizador com estes dados." || e.response.data.errors.email == "Já existe um utilizador com estes dados.") {
            errorResgistar.value = "Já existe um utilizador com estes dados.";
          }
        }
        return false;
      }
    };

    const logout = async () => {
      storeError.resetMessages();
      try {
        await axios.post("auth/logout");
        router.push({ name: 'login' })
        clearUser();
        return true;
      } catch (e) {
        clearUser();
        storeError.setErrorMessages(
          
          e.response.data.message,
          [],
          e.response.status,
          "Authentication Error!"
        );
        return false;
      }
    };
        
    const restoreToken = async function () {
      let storedToken = localStorage.getItem("token");
      if (storedToken) {
        try {
          token.value = storedToken;
          axios.defaults.headers.common.Authorization = "Bearer " + token.value;
          const responseUser = await axios.get("users/me");
          storeCoins.getCoins();
          user.value = responseUser.data.data;
          repeatRefreshToken();
          return true;
        } catch {
          clearUser();
          return false;
        }
      }
      return false;
    };

    return {
      user,
      errorLogin,
      errorResgistar,
      getUser,
      login,
      register,
      logout,
      restoreToken
    };
});