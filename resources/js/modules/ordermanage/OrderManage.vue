<template>
  <div class="container">
    <div class="container">
      <div class="row">
        <div class="col-md-10 mx-auto">
          <h1 class="text-center">Order Manage</h1>
          <!-- present the detail
        @event {click}: oncurrent item: to show order detail
      
      -->
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Customer Id</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Order Status</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="orderItem in orderList" v-bind:key="orderItem.id">
                <td>{{ orderItem.id }}</td>
                <td>{{ orderItem["user_id"] }}</td>
                <td>{{ orderItem["created_at"] }}</td>
                <td>{{ orderItem["updated_at"] }}</td>
                <td>{{ orderItem["order_status"] }}</td>
                <td>
                  <button
                    v-on:click="onCurrenOrder(orderItem.id)"
                    v-if="orderItem['order_status'] != 'Finish'"
                    class="btn btn-primary"
                  >
                    Update
                  </button>
                </td>
                <td>
                  <button
                    v-on:click="deleteOrder(orderItem.id)"
                    v-if="orderItem['order_status'] != 'Finish'"
                    class="btn btn-danger"
                  >
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <br /><br />
      <!-- present the detail
        @event {click}: customize: allow to customize the pizz
        @event {change}: to change the order status
        @property{string}: to change the status
      -->
      <div class="container" v-if="isUpdating == true">
        <h1 class="text-center" v-if="isUpdating == true">Update Form</h1>
        <div class="form-group">
          <label>Created At</label>
          <p>{{ created_at }}</p>
        </div>
        <div class="form-group">
          <label>Finished At</label>
          <p>{{ finished_at }}</p>
        </div>
        <div class="form-group">
          <p>Order status</p>

          <select class="form-control" v-model="orderStatus">
            <option value="Finish">Finish</option>
            <option value="On Editing">On Editing</option>
            <option value="On Working">On Working</option>
          </select>
        </div>
        <div class="form-group" v-for="(item, i) in items" v-bind:key="i">
          <p>Item number {{ i + 1 }}</p>
          <div class="row">
            <div class="col-lg-5">
              <p>
                Name: {{ item.pizza.name }} - Quantity:
                {{ item.pizza.quantity }}
              </p>
              <h6 class="card-text">Topping</h6>
              <div v-for="(topping, i) in item.topping" v-bind:key="i">
                <h6 class="text-muted">
                  {{ topping.name }} - {{ topping.price }}
                </h6>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <p>Total Price: {{ this.total }}</p>
        </div>
      </div>
      <button
        type="submit"
        class="btn btn-primary"
        @click.prevent="submitForm()"
        v-show="isUpdating == true"
      >
        Submit
      </button>
    </div>
  </div>
</template>

<script>
import Vue from "vue/dist/vue.js";
export default {
  name: "OrderManageTable",
  created() {
    this.orderList = this.orders;
  },
  methods: {
    /**
     * This function responsible for resprenting all items in the menu to screen
     * @param array result response from the server
     * @param string error error response
     * @event success get item from the menu
     * @event error log the error out to the console
     */
    onCurrenOrder(id) {
      this.currentUpdateOrder = id;

      this.isUpdating = true;
      // get a item from the menu
      axios({ method: "GET", url: `api/ordermanage/${id}` }).then(
        (response) => {
          console.log(response.data);
          this.items = [];

          let total = 0;
          // calculate total price for each pizza
          for (let i = 0; i < response.data["order"].length; i++) {
            let item = {
              topping: [],
              pizza: "",
            };
            item.pizza = response.data["order"][i];

            this.items.push(item);
          }
          // calculate total price for each topping
          for (let j = 0; j < response.data["order_topping"].length; j++) {
            for (let i = 0; i < this.items.length; i++)
              if (
                response.data["order_topping"][j]["id"] ==
                this.items[i]["pizza"]["id"]
              ) {
                this.items[i]["topping"].push(
                  response.data["order_topping"][j]
                );
              }
          }
          console.log(this.items);
          for (let i = 0; i < this.items.length; i++) {
            let subtotal = 0;
            subtotal += parseFloat(this.items[i]["pizza"]["price"]);
           
            for (let k = 0; k < this.items[i].topping.length; k++) {
              subtotal += parseFloat(this.items[i].topping[k].price *
                this.items[i].topping[k].quantity);
                
            }
            subtotal *= this.items[i]["pizza"]["quantity"];
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
     * This function responsible for resprenting all items in the menu to screen
     * @param array result response from the server
     * @param string error error response
     * @event success get item from the menu
     * @event error log the error out to the console
     */
    submitForm() {
      
      axios({
        method: "PUT",
        url: `api/ordermanage/update/${this.currentUpdateOrder}`,
        data: {
          orderStatus: this.orderStatus,
        },
      }).then(
        (response) => {
          this.getOrderItems();

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
    deleteOrder(id) {
      axios({
        method: "DELETE",
        url: `api/ordermanage/${id}`,
      }).then(
        (response) => {
          console.log("working");
        },
        (error) => {
          console.error(error);
        }
      );
    },
    getOrderItems(){
      axios({
        method: "GET",
        url: `api/ordermanage/`,
      }).then(
        (response) => {
          
          this.orderList = response.data;
          this.created_at = null;
          this.finished_at = "It has not finished";
          this.items = [];
          this.orderStatus = "Finish";
          this.isUpdating = false;
          this.currentUpdateOrder = 0;
          this.total = 0;
        },
        (error) => {
          console.error(error);
        }
      );
    }
  },

  data: function () {
    return {
      orderList: null,
      created_at: null,
      finished_at: "It has not finished",
      items: [],
      orderStatus: "Finish",
      isUpdating: false,
      currentUpdateOrder: 0,
      total: 0,
    };
  },
  props: ["orders"],
};
</script>