import {ref, computed} from 'vue'
import {defineStore} from 'pinia'
import axios from 'axios'
import { useErrorStore } from "@/stores/error";
import { useRouter } from 'vue-router'
import { Toaster } from 'vue-sonner';

export const useAuthStore = defineStore('auth', () => {
    const router = useRouter()
    const storeError = useErrorStore();
    
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
            console.log(credentials);
            const response = await axios.post("auth/login", credentials);
            console.log("response: ");
            console.log(response);
            token.value = response.data.token;
            axios.defaults.headers.common.Authorization = `Bearer ${token.value}`;
            localStorage.setItem("token", token.value);
            user.value = response.data.user;
            repeatRefreshToken();
            //store coins
            router.push({name: "home"});
            return user.value;
        } catch (e) {
            clearUser();
            console.log(e.response.data.message);
            if (e.response.data.message == "Unauthorized") {
                errorLogin.value = true;
                console.log("Unauthorized");
                /*toast({
                    title: "Unauthorized",
                    description: "Please, check your email and password.",
                    variant: 'destructive'
                });*/
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
          if (e.response.data.errors.username == "The username has already been taken." && e.response.data.errors.email == "The email has already been taken.") {
            errorResgistar.value = "Username e email já existem";
          }else if (e.response.data.errors.username == "The username has already been taken.") {
            errorResgistar.value = "Username já existe";            
          }else if (e.response.data.errors.email == "The email has already been taken.") {
            errorResgistar.value = "Email já existe";            
          }
        }
        return false;
      }
    };
        
    return {
      errorLogin,
      errorResgistar,
      login,
      register
    };
});