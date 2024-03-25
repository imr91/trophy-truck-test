import { ref } from 'vue';
import axios from 'axios';

export const userInfo = ref({});
export const invSum = ref(0);

export const updateUser = async (userId) => {
  try {
    //console.log('shared cucc ' + userId);
    const response = await axios.get("/api/getUser", { params: { userId: userId } });
    userInfo.value = response.data;
  } catch (error) {
    console.error(error);
  }
  try {
    const response = await axios.get("/api/countVehicle", { params: { userId: userId }});
    invSum.value = response.data;
    //console.log(invSum.value);
  } catch (error) {
    console.error(error);
  }
};