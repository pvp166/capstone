<template>
  <div class="container">
    <div class="container">
      <div class="row">
        <div class="col-md-10 mx-auto">
          <h1 class="text-center">Order History</h1>
          <!-- present the table of history order for user
        @event {click}: onCurrentOrder: show Order Detail
          -->
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Created At</th>
                <th>Finish At</th>

                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="orderItem in orderList" v-bind:key="orderItem.id">
                <td>{{ orderItem.id }}</td>
                <td>{{ orderItem["created_at"] }}</td>
                <td>{{ orderItem["finished_at"] }}</td>

                <td>
                 
                  <button
                    v-on:click="onCurrentOrder(orderItem.id)"
                   
                    class="btn btn-primary"
                  >
                    Detail
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- present the detail
        @event {click}:add This Item: add the Item to menu
        @event {comment}: comment about the quality and save it
        @event {click}: update the order 
        @property {string}: comment
        @property {int}: item quality
      -->
      <br /><br />
      <div class="container" v-if="isGettingDetail == true">
        <h1 class="text-center">Item Details</h1>

        <div class="form-group">
          <label>Created At</label>
          <p>{{ basicDetail.created_at }}</p>
        </div>
        <div class="form-group">
          <label>Finished At</label>
          <p>{{ basicDetail.finished_at }}</p>
        </div>

        <div
          class="row"
          v-for="(item, index) in itemOrderedList"
          v-bind:key="index"
        >
          <div class="col-lg-4" style="margin-top: 40px">
            <h2>Item Number: {{ index + 1 }}</h2>
            <div class="card col-lg-12">
              <div class="card-body">
                <img
                  class="card-img-top"
                  :src="item.item_image"
                  alt="Card image"
                  height="200px"
                />
                <br /><br />
                <h4 class="card-title">Name: {{ item.name }}</h4>
                <p class="card-text">Description: {{ item.description }}</p>
              </div>
            </div>
          </div>
          <div class="col-lg-8">
            <div class="d-flex justify-content-center" style="margin-top: 80px">
              <form>
                <div class="form-group">
                  <button
                    v-on:click.prevent="addThisItem(item)"
                    class="btn btn-primary col-lg-10"
                  >
                    Add this item to order
                  </button>
                </div>
                <div class="form-group">
                  <label for="comment">Comment</label>
                  <textarea
                    class="form-control"
                    id="comment"
                    rows="4"
                    v-model="item.comments"
                  ></textarea>
                </div>
                <div class="form-group">
                  <label for="rating">Rating</label><br />
                  <input type="radio" v-model="item.rating" value="1" />
                  <label>*</label><br />
                  <input type="radio" v-model="item.rating" value="2" />
                  <label>**</label><br />
                  <input type="radio" v-model="item.rating" value="3" />
                  <label>***</label><br />
                  <input type="radio" v-model="item.rating" value="4" />
                  <label>****</label><br />
                  <input type="radio" v-model="item.rating" value="5" />
                  <label>*****</label><br />
                </div>
              </form>
            </div>
          </div>
        </div>
        <br /><br />
        <div class="row">
          <button v-on:click="updateOrder()" class="btn btn-warning col-lg-2">
            Update
          </button>
          <a href="./" class="btn btn-danger col-lg-2">Go to home page</a>
          <a href="./shoppingcart" class="btn btn-primary col-lg-2">Go to shopping cart</a>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
// This componenent is to print out all the item that a customer order before
import Vue from "vue/dist/vue.js";
export default {
  name: "OrderHistory",
  created() {
   this.getOrderItems();
  },
  methods: {
    /**
     * This function responsible for resprenting all items in the menu to screen
     * @param array result response from the server
     * @param string error error response
     * @event success close the form, let user to order new item
     * @event error log the error out to the console
     */
    getOrderItems() {
      axios({ method: "GET", url: "api/orderhistory" }).then(
        (response) => {
          // update the result from server to the main screen
          console.log(response.data);
          this.orderList = response.data;
        },
        (error) => {
          console.error(error);
        }
      );
    },

    deleteOrder(id) {
      axios({
        method: "DELETE",
        url: `api/orderhistory/${id}`,
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
     * This function responsible for respreting the detail from a particular order to the screem
     * @param int id id of the order that users want to get detail
     * @param array result response from the server
     * @param string error error response
     * @event success close the form, let user to order new item
     * @event error log the error out to the console
     */
    onCurrentOrder(id) {
      axios({
        method: "GET",
        url: `api/orderhistory/${id}`,
      }).then(
        (response) => {
          // Order basic detail
          console.log(response.data);
          this.basicDetail = response.data[0][0];
          this.orderStatus = response.data[0][0]["order_status"];
          this.itemOrderedList = response.data[1];

          // Show the order
          this.isGettingDetail = true;
        },
        (error) => {
          console.error(error);
        }
      );
    },
    /**
     * This function responsible for respreting the detail from a particular order to the screem
     * @param int id id of the order that users want to get detail
     * @param array result response from the server
     * @param string error error response
     * @event success close the form, let user to order new item
     * @event error log the error out to the console
     */
    updateOrder() {
      axios({
        method: "PUT",
        url: `api/orderhistory/${this.idItemUpdating}`,
        data: {
          order_items: this.itemOrderedList,
        },
      }).then(
        (response) => {
          this.isGettingDetail = false;
          this.idItemUpdating = 0;
          this.basicDetail = null;
          this.itemOrderedList = null;
        },
        (error) => {
          console.error(error);
        }
      );
    },
    // Add the item from history to order
    addThisItem(item) {
      axios({
        method: "POST",
        url: `api/orderhistory/add`,
        data: {
          item: item,
        },
      }).then(
        (response) => {
          console.log(response.data);
        },
        (error) => {
          console.error(error);
        }
      );
    },
  },

  data() {
    return {
      orderStatus: "Finish", // save the current order status
      orderList: null,
      idItemUpdating: 1,
      isGettingDetail: false,
      basicDetail: null, // status, create_at, finish_at
      itemOrderedList: null,
    };
  },
};
</script>