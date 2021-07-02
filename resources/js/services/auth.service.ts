import axios from "@/api";
import router from "@/router";
import { reactive } from "vue";
import { useError } from "./cart.service";

// eslint-disable-next-line @typescript-eslint/explicit-module-boundary-types
export default function useAuth() {
  const { setError, unSetError } = useError();

  const user = reactive({
    id: null,
    name: localStorage.getItem("name") || "",
    salesId: localStorage.getItem("salesId") || "",
  });

  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  const saveItems = (data: any) => {
    localStorage.setItem("token", data.token);
    localStorage.setItem("name", data.user.name);
    localStorage.setItem("salesId", data.salesId);
  };

  const removeItems = () => {
    localStorage.removeItem("token");
    localStorage.removeItem("name");
    localStorage.removeItem("salesId");
  };

  //   login
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  const login = async (items: any) => {
    try {
      const res = await axios.post("/login", items);
      saveItems(res.data);
      unSetError();
      return res;
    } catch (error) {
      setError("Oops!! Unable to Login");
      return error;
    }
  };

  //   close Shift
  const closeShift = async (sale: number) => {
    try {
      const res = await axios.get(`/close-shift/${sale}`);
      unSetError();
      return res;
    } catch (error) {
      setError("Oops!! Error performing operation");
      return error;
    }
  };

  //   logout
  const logout = async () => {
    try {
      const res = await axios.post("/logout");
      unSetError();
      removeItems();
      router.push({ name: "Login" });
      return res;
    } catch (error) {
      removeItems();
      setError("Oops!! Error performing operation");
      return error;
    }
  };

  return { user, login, logout, closeShift };
}
