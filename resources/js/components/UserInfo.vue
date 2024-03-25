<template>
    <div class="userWindow">
      <h2>Player details</h2>
      <div class="userDetails">
        <div class="userName">
            <div >
                Name
            </div>
            <div>
                {{ userInfo.user_name }}
            </div>
        </div>
        <div class="userBalance">
            <div >
                Balance
            </div>
            <div :class="{ shake: disabled, colorRed: redDisabled, colorGreen: greenDisabled  }" >
                {{ userInfo.user_cash }} c.
            </div>
        </div>
        <div class="userVehicles">
            <div >
                Trucks in garage
            </div>
            <div :class="{ shake: disabled }">
                {{ invSum }}
            </div>
        </div>
      
        </div>
    </div>
</template>

<script>
import { ref, onMounted, watch } from 'vue';
import { userInfo, updateUser, invSum } from '@/shared-state';

export default {
  setup() {
    const disabled = ref(false);
    const redDisabled = ref(false);
    const greenDisabled = ref(false);

    function warnDisabled() {
        disabled.value = true;
        setTimeout(() => {
            disabled.value = false
        }, 1500)
    }
    function colorDisabled(color) {
        if (color == 'red') {
            redDisabled.value = true;
            setTimeout(() => {
                redDisabled.value = false
            }, 1500)
        }
        if (color == 'green') {
            greenDisabled.value = true;
            setTimeout(() => {
                greenDisabled.value = false
            }, 1500)
        }
    }

    watch(userInfo, (newValue, oldValue) => {
        //console.log('it changed');
        //console.log(newValue.user_cash + ' ' + oldValue.user_cash);
        //console.log(newValue.user_name + ' ' + oldValue.user_name);
        if(oldValue.user_name == newValue.user_name){
            if(oldValue.user_cash > newValue.user_cash){
                colorDisabled('red');
            }
            if(oldValue.user_cash < newValue.user_cash){
                colorDisabled('green');
            }
            warnDisabled();
        }

        //warnDisabled();
    });

    onMounted(async () => {
      await updateUser(1); // Fetch user information initially
    });

    return {
      userInfo,
      invSum,
      disabled,
      redDisabled,
      greenDisabled
    };

  }
};
</script>

<style scoped>
    .userWindow{
        background-color: #add8e6;
        width: 250px;
        border-radius: 10px;
        margin-left: 30px;
        font-size: 18px;
        position: fixed;
        top: 160;
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
    .userDetails{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 10px;
    }
    .userName, .userBalance, .userVehicles{
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .shake {
        animation: shake 0.82s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
        transform: translate3d(0, 0, 0);
      }

    .colorRed {
        color: red;
    }
    .colorGreen{
        color: green;
    }
      
    @keyframes shake {
        10%,
        90% {
            transform: translate3d(-1px, 0, 0);
        }
        
        20%,
        80% {
            transform: translate3d(2px, 0, 0);
        }
        
        30%,
        50%,
        70% {
            transform: translate3d(-4px, 0, 0);
        }
        
        40%,
        60% {
            transform: translate3d(4px, 0, 0);
        }
    }
</style>