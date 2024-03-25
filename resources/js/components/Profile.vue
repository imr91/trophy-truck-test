<template>
    <div class="profileWindow">
      <h2>Profile</h2>
      <div class="container">
        <div class="userField">
            <div>
                Change user:
            </div>
            <div class="selectField">
                <select v-model="selectedUser" @change="changeUser($event)" >
                    <option v-for="(user) in users" :value="user.user_id">
                        {{ user.user_name }}
                    </option>
                </select>
            </div>
        </div>

      </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { userInfo, updateUser, invSum } from '@/shared-state';

export default {
  setup() {

    const selectedUser = ref();
    const users = ref();

    const changeUser = (event) => {
        //console.log(event);
        updateUser(selectedUser.value);
    }

    const fetchUsers = async () => {
        try {
          const response = await axios.get("/api/getUserList");
          users.value = response.data;
          //console.log(users.value);
        } catch (error) {
          console.error(error);
        }
      };

      onMounted(fetchUsers);

    return {
      userInfo,
      invSum,
      selectedUser,
      users,
      changeUser
    };

  }
};
</script>

<style scoped>
    .profileWindow{
        background-color: #add8e6;
        width: 25%;
        margin-left: 30px;
        font-size: 18px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
    }
    h2{
        width: 100%;
        background-color: #1b7593;
        color:whitesmoke;
        margin: 0 auto;
        padding-top: 10px;
        padding-bottom: 10px;
        text-align: center;
        border-radius: 10px 10px 0 0;
    }
    .container{
        width: 100%;
    }
    .userField{
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
        align-items: center;
        padding: 10px;
    }
    select{
        width: 120px;
        font-size: 17px;
        width: 150px;
        border-radius: 10px;
        padding: 5px;
    }

</style>