<template>
<div class="main">
  <div class="header">
    <div class="gameTitle">
        <h1>
            Truck Collector
        </h1>
    </div>
    <div class="navBar">
        <button @click.prevent="toggleProfile" class="navButton">Profile</button>
        <button @click.prevent="toggleInventory" class="navButton">Inventory</button>
        <button @click.prevent="toggleShop" class="navButton">Shop</button>
        <button @click.prevent="logout" class="navButton">Logout</button>
    </div>
  </div>

  <div class="content">
    <UserInfo />
    
    <TransitionGroup :duration="{ enter: 650, leave: 200}" name="shopAnim">
      <Profile v-if="showProfile" />
      <Shop v-if="showShop" />
      <Inventory v-if="showInventory" />
    </TransitionGroup>

  </div>
</div>

  
</template>

<script setup>
import { ref } from "vue";
import Shop from "./components/Shop.vue";
import UserInfo from "./components/UserInfo.vue";
import Inventory from "./components/Inventory.vue";
import Profile from "./components/Profile.vue";

const response = ref();
const responseVehicle = ref();
const responseInventory = ref();
const showShop = ref(false);
const showInventory = ref(false);
const showProfile = ref(false);

const toggleShop = () => {
    showShop.value = !showShop.value;
    showInventory.value = false;
    showProfile.value = false;
};
const toggleInventory = () => {
    showInventory.value = !showInventory.value;
    showShop.value = false;
    showProfile.value = false;
};
const toggleProfile = () => {
    showInventory.value = false;
    showShop.value = false;
    showProfile.value = !showProfile.value;
};
</script>

<script>
export default {
  components: {
    Shop,
    UserInfo,
    Inventory,
    Profile
  }
}
</script>

<style>
body{
  font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
  margin: 0;
  background-color: #e3dad5;
  min-height: 100vh;
}
.main {
  display: flex;
  flex-direction: column;
}
.header{
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  position: fixed;
  top: 0;
  width: 100%;
  height: 90px;
  margin: 0;
  padding: 0;
  overflow: hidden;
  /*background-color: #333;*/
  background-color: #00292a;
  color: white;
}
.content{
  margin-top: 110px;
}
.gameTitle{
  font-style: italic;
  margin-left: 30px;
}
.navBar{
  margin-right: 30px;
  display: flex;
  flex-direction: row;
  justify-content: space-evenly;
  width: 30%;
}
.navButton{
  cursor: pointer;
  font-size:17px;
  width:100px;
  height:50px;
  border-width:1px;
  color:#fff;
  border-color:#566963;
  font-weight:bold;
  border-top-left-radius:5px;
  border-top-right-radius:5px;
  border-bottom-left-radius:5px;
  border-bottom-right-radius:5px;
  box-shadow:inset 0px 1px 3px 0px #91b8b3;
  text-shadow:inset 0px -1px 0px #2b665e;
  /*background:linear-gradient(#768d87, #6c7c7c);*/
  background:linear-gradient(#007c7d, #003e3f);
}
.navButton:hover{
  /*background: linear-gradient(#6c7c7c, #768d87);*/
  background: linear-gradient(#003e3f, #007c7d);
}

.shopAnim-enter-active, .shopAnim-leave-active {
	transition: opacity 0.65s ease-in-out, transform 0.65s ease-in-out;
}
/*.shopAnim-leave-active {
  transition-delay: 0.25s;
}
.shopAnim-enter-from,
.shopAnim-leave-to {
  transform: translateY(100px);
  opacity: 0;
}*/
.shopAnim-enter-from, .shopAnim-leave-to {
  opacity: 0;
  transform: translateY(150px);
}

.shopAnim-enter-to {
  opacity: 1;
  transform: translateY(0);
}

.shopAnim-leave-from {
  opacity: 1;
  transform: translateY(0);
}

</style>