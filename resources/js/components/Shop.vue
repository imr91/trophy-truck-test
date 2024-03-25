<template>
    <div class="shopWindow">
        <h2>Filters</h2>
        <div class="filterWindow">
            
            <div>
                <div>Brand</div>
                <div>
                    <select v-model="brandFilter" >
                        <option value="all">All</option>
                        <option v-for="(brand) in brands" :value="brand.vehicle_brand">
                            {{ brand.vehicle_brand }}
                        </option>
                    </select>
                </div>
            </div>
            <div>
                <div>Type</div>
                <div>
                    <select v-model="typeFilter">
                        <option value="-">All</option>
                        <option value="diesel">Diesel</option>
                        <option value="electric">Electric</option>
                    </select>
                </div>
            </div>
            <div>
                <div>Cost</div>
                <div>
                    <select v-model="costFilter">
                        <option value="-">-</option>
                        <option value="high">Highest first</option>
                        <option value="low">Lowest first</option>
                    </select>
                </div>
            </div>

            <button @click.prevent="runFilters()" class="buyButton" >Filter</button>
        </div>
      <h2>Vehicle Shop</h2>
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
                            Cost
                        </div>
                        <br>
                        <div class="cost">
                            {{ vehicle.price }} c.
                        </div>
                    </div>
                    <div>
                        <button @click.prevent="buyItem(vehicle.vehicle_id, vehicle.price, index, userInfo.user_cash, userInfo.user_id)" class="buyButton">Buy</button>
                    </div>
                    <div v-if="vehicle.errorMessage">
                        {{ vehicle.errorMessage }}
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
      const brands = ref([]);
      const brandFilter = ref('all');
      const typeFilter = ref('-');
      const costFilter = ref('-');

      const fetchVehicles = async (brand, type, cost) => {
        try {
          const response = await axios.get("/api/getVehicles", {
      params: {
        brand: brand.value,
        type: type.value,
        cost: cost.value
      }
    });
          vehicles.value = response.data;
          //console.log(response.data);
        } catch (error) {
          console.error(error);
        }
      };

      const buyItem = async (vehicleId, amount, index, cash, userid) => {
        //console.log(amount + ' ' + cash)
        if(cash > amount){
            try {
                const response = await axios.post("/api/buyVehicle", { userid: userid, vehicleId: vehicleId });
                //console.log(response.data);
            } catch (error) {
                console.error(error);
            }
            try {
                const response = await axios.post("/api/subBalance", { userid: userid, amount: amount });
                //console.log(response.data);
            } catch (error) {
                console.error(error);
            }
            await updateUser(userInfo.value.user_id);
            vehicles.value[index].errorMessage = '';
        }
        else{
            vehicles.value[index].errorMessage = 'Not enough credit!';
        }
      };

      const fetchBrands = async () => {
        try {
          const response = await axios.get("/api/getBrands");
          brands.value = response.data;
          //console.log(users.value);
        } catch (error) {
          console.error(error);
        }
      };

      const runFilters = async () => {
        const selBrand = brandFilter;
        const selType = typeFilter;
        const selCost = costFilter;
        //console.log(selBrand + ' ' + selType + ' ' + selCost);
        
        fetchVehicles(selBrand, selType, selCost);

      }

  
      onMounted(fetchVehicles(brandFilter, typeFilter, costFilter));
      onMounted(fetchBrands);
  
      return {
        vehicles,
        buyItem,
        userInfo,
        brands,
        runFilters,
        brandFilter,
        typeFilter,
        costFilter
      };

    }
  };
  </script>
  
<style scoped>
.shopWindow{
    width: 50%;
    background-color: #add8e6;
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

.buyButton{
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
  
  .buyButton:hover{
    background: linear-gradient( #389ebf, #1b7593);
  }

  .cost{
    font-weight: bold;
    font-size: 22px;
    color: darkgreen;
  }

  .filterWindow{
    display: flex;
    flex-direction: row;
    justify-content: space-evenly;
    align-items: center;
    width: 100%;
    height: 70px;
    font-size: 17px;
    margin-bottom: 20px;
  }
  .filterWindow select{
    font-size: 17px;
    width: 150px;
    border-radius: 10px;
    padding: 5px;
  }

</style>