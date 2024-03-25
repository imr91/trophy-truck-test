<template>
    <div class="shopWindow">
      <h2>Owned Vehicles</h2>
      <div class="shopList">
      
        
            <div class="row" v-for="(vehicle, index) in vehicles" :key="index">
                <div class="picture">
                    <img :src="vehicle.img_path" alt="img" height="140">
                </div>
                <div class="vehicleInfo">
                    <div class="vehicleName">{{ vehicle.vehicle_brand }} {{ vehicle.vehicle_model }} </div>
                    <div class="vehicleDetails"> {{ vehicle.vehicle_details }} </div>
                </div>
                <div class="costInfo">
                    <div>
                        <div>
                            Sell price
                        </div>
                        <br>
                        <div>
                            {{ vehicle.sell_price }} c.
                        </div>
                    </div>
                    <div>
                        <button @click.prevent="sellItem(vehicle.item_id, vehicle.sell_price)" class="sellButton">Sell</button>
                    </div>
                </div>
            </div>
        
      
    </div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import { updateUser, userInfo } from '@/shared-state';
  
  export default {
    setup() {
      const vehicles = ref([]);

      const fetchVehicles = async () => {
        try {
          const response = await axios.get("/api/getInventory", { params: { userId: userInfo.value.user_id } });
          vehicles.value = response.data;
        } catch (error) {
          console.error(error);
        }
      };

    const sellItem = async (itemId, price) => {
        try {
            const response = await axios.post("/api/sellVehicle", { item_id: itemId });
            //console.log(response.data);
        } catch (error) {
            console.error(error);
        }
        try {
            const response = await axios.post("/api/addBalance", { userId: userInfo.value.user_id, amount: price });
            //console.log(response.data);
        } catch (error) {
            console.error(error);
        }

        await fetchVehicles();
        await updateUser(userInfo.value.user_id);
    };
  
      onMounted(fetchVehicles);
  
      return {
        vehicles,
        sellItem
      };

    }
  };
  </script>

<style scoped>
.shopWindow{
    width: 50%;
    background-color:#add8e6;
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
.shopList{
    width: 100%;
    
}
.row{
    width: 100%;
    height: 150px;
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    align-items: center;
    cursor: pointer;
    border-bottom: 2px solid #1b7593;
    padding-top: 5px;
    padding-bottom: 5px;
}
.row:last-of-type{
    border-bottom: 0px;
}
.row:hover{
    color: grey;
    background-color: rgb(171, 192, 219);
}
.picture{
    width: 33.333%;
    margin-left: 10px;
    background-color: white;
    text-align: center;
    border-radius: 10px;
}
.vehicleInfo{
    width: 33.333%;
    text-align: left;
    margin-left: 20px;
    
}
.vehicleName{
    font-size: 1.5rem;
}
.vehicleDetails{
    font-style: italic;
    margin-top: 15px;
    color: rgb(88, 86, 86);
}
.costInfo{
    width: 33.333%;
    text-align: right;
    font-size: 1.1rem;
    display: flex;
    flex-direction: row;
    justify-content: space-evenly;
}
.sellButton{
    cursor: pointer;
    font-size:14px;
    width:80px;
    height:30px;
    border-width:1px;
    color:#fff;
    border-color:#359275;
    font-weight:bold;
    border-top-left-radius:5px;
    border-top-right-radius:5px;
    border-bottom-left-radius:5px;
    border-bottom-right-radius:5px;
    box-shadow:inset 0px 1px 3px 0px #6fc0db;
    text-shadow:inset 0px -1px 0px #add8e6;
    background:linear-gradient( #1b7593, #389ebf);
  }
  
  .sellButton:hover{
    background: linear-gradient( #389ebf, #1b7593);
  }

</style>