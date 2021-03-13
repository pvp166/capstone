<template>
  <div id="checkoutpage">
    <div v-if="showPage == false" class="container">
      <!-- If there is nothing in the shopping cart
          -->
      <h1>There is nothing in your shopping cart</h1>
      <h1>Would you like to go back the home page</h1>
      <a href="../" class="btn btn-large text-center">Back to home page</a>
      <a href="../customize" class="btn btn-large text-center"
        >Back to customize page</a
      >
    </div>
    <div class="container" v-if="showPage == true">
      <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your cart</span>
            <span class="badge badge-secondary badge-pill">{{
              orders.length
            }}</span>
          </h4>
          <!-- List of item in the shopping cart
          @property {string} - h6: order["name"]
          @property {string} - h6: special instruction
          @property {string} - dropdown list: list of toppings
          @property {string} - name: address
          -->
          <div v-for="(item, i) in itemList" v-bind:key="i">
            <li
              class="list-group-item d-flex justify-content-between lh-condensed"
            >
              <div>
                <h6 class="my-0">{{ item.item.name }}</h6>
                <div v-if="item.showTopping == true">
                  <div v-for="(topping, i) in item.topping" v-bind:key="i">
                    <small class="text-muted"
                      >{{ topping.name }} - {{ topping.price }}</small
                    >
                  </div>
                </div>
              </div>
              <span class="text-muted">{{ item.price }}</span>
            </li>
          </div>
          <li
            class="list-group-item d-flex justify-content-between lh-condensed"
          >
            <div>
              <h6 class="my-0">Total</h6>
              <small class="text-muted"></small>
            </div>
            <span class="text-muted">{{ amount }}</span>
          </li>
        </div>
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Billing address</h4>
          <form class="needs-validation" novalidate>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">Full name</label>
                <h4>{{ address["full_name"] }}</h4>
              </div>
            </div>

            <div class="mb-3">
              <label for="email"
                >Email <span class="text-muted">(Optional)</span></label
              >
              <h4>{{ user }}</h4>
            </div>

            <div class="mb-3">
              <label for="address">Address Line 1</label>
              <h4>{{ address["address_line_1"] }}</h4>
            </div>

            <div class="mb-3">
              <label for="address2"
                >Address 2 <span class="text-muted">(Optional)</span></label
              >
              <h4>{{ address["address_line_2"] }}</h4>
            </div>

            <div class="row">
              <div class="col-md-5 mb-3">
                <label for="city">City</label>
                <h4>{{ address["city"] }}</h4>
              </div>
              <div class="col-md-4 mb-3">
                <label for="Province">Province</label>
                <h4>{{ address["province"] }}</h4>
              </div>
              <div class="col-md-3 mb-3">
                <label for="postal_code">Postal code</label>
                <h4>{{ address["postal_code"] }}</h4>
              </div>
            </div>
            <hr class="mb-4" />
            <!-- trigered on click
            @event changeaddress change to another address
            -->
            <a class="btn btn-warning btn-lg btn-block" href="../address">
              Change the address
            </a>
            <hr class="mb-4" />
            <!-- trigered on click
            @event token create new token
            @event token loading
            @property amount: string
            -->
            <h4 class="mb-3">Payment</h4>

            <div class="row">
              <div class="col-md-6 mb-3">
                <div>
                  <div>
                    <div>
                      <stripe-elements
                        ref="elementsRef"
                        :pk="publishableKey"
                        :amount="amount"
                        @token="tokenCreated"
                        @loading="loading = $event"
                      >
                      </stripe-elements>
                      <button
                        @click="submit($event)"
                        class="btn btn-warning btn-lg btn-block"
                      >
                        Pay
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <hr class="mb-4" />
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
//this class manage the payment process
import Vue from "vue";
import { StripeElements } from "vue-stripe-checkout";
export default {
  components: {
    StripeElements,
  },
  name: "CheckoutPage",
  props: ["orders", "address", "user", "topping", "addressId"],

  data: function () {
    return {
      itemList: [],
      amount: 0, // the amount of money that an user have to pay
      loading: false, // show the form
      // key to connect stripe
      publishableKey:
        "pk_test_51Hdi2EENFBiXe6rcMetI71W7YCs0Wgu9c10DIr6rTUo9jxJdtuIfle0L3pRPHqmYGboOlOYVHTeFQ7Ol6exLhTRv005xJQJzdr",
      token: null, // the stripe token
      charge: null, // user money
      showPage: false,
    };
  },
  mounted: function () {},
  created() {
    if (this.orders === undefined || this.orders === null) {
      // do something
      this.showPage = false;
    } else {
      this.showPage = true;
    }
    let itemList = [];
    for (let i = 0; i < this.orders.length; i++) {
      itemList.push({
        item: this.orders[i],
        topping: [],
        price: 0,
        showTopping: false,
      });
      let price = 0;

      price += parseFloat(itemList[i].item.price);
      console.log(price);
      for (let k = 0; k < this.topping.length; k++) {
        let total_topping = 0;
        if (this.topping[k]["id"] == this.orders[i].id) {
          itemList[i].topping.push(this.topping[k]);
          itemList[i].showTopping = true;
          price += parseFloat(this.topping[k].price) * parseFloat(this.topping[k].quantity);
        }
      }
      price *= parseFloat(itemList[i].item.quantity);
      itemList[i].price = parseFloat(price.toFixed(2));
    }
    this.itemList = itemList;
    console.log(itemList);
    let total = 0;
    for (let i = 0; i < this.itemList.length; i++) {
      total += parseFloat(this.itemList[i].price);
    }
    this.amount = parseFloat(total.toFixed(2));
  },
  //Calculate the total money
  methods: {
    /**
     * This function responsilbe for calculating the total
     * @var float cartTotal the total money that a customer need to pay
     */

    /**
     * This function responsilbe for representing the address table to main screen
     * @param event when user click on the event
     */
    submit(event) {
      event.preventDefault();
      this.$refs.elementsRef.submit();
    },
    /**
     * This function responsilbe for creating the token to the user
     * @param token when user click on the event
     */
    tokenCreated(token) {
      this.token = token;
      // for additional charge objects go to https://stripe.com/docs/api/charges/object
      this.charge = {
        source: token.id,
        amount: this.amount, // the amount you want to charge the customer in cents. $100 is 1000 (it is strongly recommended you use a product id and quantity and get calculate this on the backend to avoid people manipulating the cost)
        description: this.description, // optional description that will show up on stripe when looking at payments
      };
      this.sendTokenToServer(this.charge);
    },
    /**
     * This function responsilbe for creating the token to the user
     * @param string token when user click on the event
     * @var float charge the number of money that an user have to pay
     */
    sendTokenToServer(charge) {
      // send the Token back to server
      axios({
        method: "POST",
        url: "../api/shoppingcart/checkout",
        data: {
          charge: charge,
        },
      }).then(
        (response) => {
          //redirect user to the response page
          window.location.href = "../";
          console.log(response.data);
        },
        (error) => {
          console.error(error);
        }
      );
      // Send to charge to your backend server to be processed
      // Documentation here: https://stripe.com/docs/api/charges/create
    },
  },
};
</script>
