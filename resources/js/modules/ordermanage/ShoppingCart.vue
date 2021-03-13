<template>
  <div class="container">
    <h1 class="text-center">Shopping Cart</h1>
    <div class="row" v-for="(item, index) in orderList" v-bind:key="index">
      <div class="col-lg-5" style="margin-top: 40px">
        <div class="card col-lg-12">
          <!-- present the shopping cart
        @event {click}: click: customize the pizza
        @event {click}: to order another same type of pizza
        @event{click}: add new special requirement
      -->
          <img
            class="card-img-top"
            :src="item['pizza'].item_image"
            alt="Card image"
            height="200px"
          />
          <div class="card-body">
            <h4 class="card-title">Name: {{ item["pizza"].name }}</h4>
            <p class="card-text">
              Description: {{ item["pizza"].description }}
            </p>
            <p class="card-text">
              Size: {{ item["pizza"].size }} - Price: {{ item["pizza"].price }} - Quantity: {{item["pizza"].quantity}}
            </p>
            
            <p class="card-text">Topping</p>
            <p
              class="card-text"
              v-for="(topping, index) in item['topping']"
              v-bind:key="index"
            >
              Size: {{ topping.name }} - Price: {{ topping.price }} - Quantity: {{topping.quantity}}
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="d-flex justify-content-center" style="margin-top: 80px">
          <form>
            <!-- present the shopping cart
        @event {click}: customize pizza
        @event {click}: order one more: order one more item
        @event{click}: delete the item
      -->
            <div class="form-group">
              <a
                :href="'./modify/' + item['pizza'].id"
                class="btn btn-warning col-lg-10"
                v-if="
                  item['pizza']['item_type_id'] == 1 ||
                  item['pizza']['item_type_id'] == 2
                "
                >Customize Pizza</a
              >
            </div>

            <div class="form-group">
              <button
                class="btn btn-primary col-lg-10"
                @click.prevent="orderAgain(item['pizza'].id)"
              >
                Order one more
              </button>
            </div>
            <div class="form-group">
              <button
                class="btn btn-danger col-lg-10"
                @click.prevent="deleteItem(item['pizza'].id)"
              >
                Delete from order
              </button>
            </div>

            <div class="form-group">
              <label>Special Requirement</label>
              <textarea
                class="form-control"
                v-model="item['pizza']['special_instructions']"
                rows="4"
              ></textarea>
              <br /><br />
              <button
                class="btn btn-warning col-lg-12"
                @click.prevent="
                  saveRequirement(
                    item['pizza'].id,
                    item['special_instructions']
                  )
                "
              >
                Save special requirement
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <h2 class="d-flex justify-content-center">Price: {{ total }}$</h2>
    <div class="d-flex justify-content-center" style="margin-top: 15px">
      <a href="./address" class="btn btn-warning" style="margin-right: 10px"
        >Order</a
      >
      <button class="btn btn-primary">Back to the homepage</button>
    </div>
  </div>
</template>
<script>
export default {
  name: "ShoppingCart",
  data: function () {
    return {
      total: 0,
      orderList: [],
    };
  },
  created() {
    this.getItemForShoppingCart();
  },
  methods: {
    /**
     * This function responsible for deleting the order
     * @param array result response from the server
     * @param string error error response
     * @event success get item from the menu
     * @event error log the error out to the console
     */
    getItemForShoppingCart() {
      axios({ method: "GET", url: "api/shoppingcart" }).then(
        (response) => {
          
          this.orderList = [];
          
          let total = 0;
          // calculate total price for each pizza
          for (let i = 0; i < response.data["order"].length; i++) {
            let item = {
              topping: [],
              pizza: "",
            };
            item.pizza = response.data["order"][i];
           
            this.orderList.push(item);
          }
          // calculate total price for each topping
          for (let j = 0; j < response.data["order_topping"].length; j++) {
            
            for (let i = 0; i < this.orderList.length; i++)
              if (
                response.data["order_topping"][j]["id"] ==
                this.orderList[i]["pizza"]["id"]
              ) {
                this.orderList[i]["topping"].push(
                  response.data["order_topping"][j]
                );
              }
          }
          
          for(let i = 0; i < this.orderList.length; i++){
            let subtotal = 0;
            subtotal += parseFloat(this.orderList[i]['pizza']['price']);
            
            for(let k = 0; k < this.orderList[i].topping.length; k++){
              subtotal += parseFloat(this.orderList[i].topping[k].price*this.orderList[i].topping[k].quantity);
            }
            subtotal *= parseFloat(this.orderList[i]['pizza']['quantity']);
            total += subtotal;
          }
          
          this.total = parseFloat(total).toFixed(2);
          
        },
        (error) => {
          console.error(error);
        }
      );
    },
    /**
     * This function responsible for deleting the order
     * @param array result response from the server
     * @param string error error response
     * @event success get item from the menu
     * @event error log the error out to the console
     */
    deleteItem(id) {
      console.log(id);
      axios({
        method: "DELETE",
        url: `api/shoppingcart/${id}`,
      }).then(
        (response) => {
          console.log(response.data);
          this.getItemForShoppingCart();
        },
        (error) => {
          console.error(error);
        }
      );
    },
    /**
     * This function responsible for saving new items for the customers
     * @param array result response from the server
     * @param string error error response
     * @event success get item from the menu
     * @event error log the error out to the console
     */
    saveRequirement(id, requirement) {
      console.log(id);
      axios({
        method: "PUT",
        url: `api/shoppingcart/update/instructions/${id}`,
        data: {
          requirement: requirement,
        },
      }).then(
        (response) => {
          this.getItemForShoppingCart();
        },
        (error) => {
          console.error(error);
        }
      );
    },
    /**
     * This function responsible for saving new items for the customers
     * @param array result response from the server
     * @param string error error response
     * @event success get item from the menu
     * @event error log the error out to the console
     */
    orderAgain(id) {
      console.log(id);
      axios({
        method: "POST",
        url: `api/shoppingcart/add`,
        data: {
          id: id,
        },
      }).then(
        (response) => {
          this.getItemForShoppingCart();
          console.log("work");
        },
        (error) => {
          console.error(error);
        }
      );
    },
  },
};
</script>