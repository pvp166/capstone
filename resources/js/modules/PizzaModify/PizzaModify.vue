<template>
  <div class="container">
    <div class="row">
      <div class="col-lg-5" style="margin-top: 40px">
        <div class="card">
          <img
            class="card-img-top"
            :src="'../' + chosenPizza.item_image"
            alt="Card image"
            height="400px"
          />
          <div class="card-body">
            <h4 class="card-title">{{ chosenPizza.name }}</h4>
            <p class="card-text">{{ chosenPizza.description }}</p>
          </div>
        </div>
      </div>
      <div class="col-lg-7 row">
        <div class="col-lg-4" style="margin-top: 80px"></div>
        <div
          class="d-flex justify-content-center col-lg-8"
          style="margin-top: 80px"
        >
          <!-- on change: to show a size of pizza
        @event {click}: click: show the size of pizza
        @event {object}: pizza size
      -->
          <form>
            <label class="col-lg-10">Size</label>
            <select
              class="custom-select col-lg-10"
              v-model="chosenSize"
              @change="chooseASize()"
            >
              <option
                v-for="size in listOfPizzaType"
                v-bind:key="size.id"
                :value="size"
              >
                {{ size.size }}
              </option>
            </select>
            <p class="text-danger" v-if="didChooseSize == false">
              Please choose a type
            </p>
            <!-- on click: to add topping of pizza
        @event {click}: click: add topping to pizza
        @event {object}: pizza topping
        @event {click}: remove a topping
      -->
            <div v-if="isGotSize == true">
              <p>Quantity: {{ chosenPizza.quantity }} pizzas</p>
              <button
                @click.prevent="increase()"
                class="btn btn-sm btn-outline-secondary"
              >
                Increase
              </button>
              <button
                @click.prevent="decrease()"
                class="btn btn-sm btn-outline-secondary"
              >
                Decrease
              </button>
              <br /><br />
              <button class="btn btn-warning" @click.prevent="addToping()">
                Add Topping
              </button>

              <br /><br />
              <label class="col-lg-10">Topping</label>
              <div v-for="(topping, i) in listOfChosenTopping" v-bind:key="i">
                <p v-if="listOfChosenTopping[i].showName == true">
                  Current Topping: {{ listOfChosenTopping[i].item.name }}
                </p>
                <select
                  class="custom-select col-lg-12"
                  v-model="listOfChosenTopping[i].item"
                  @change="chooseATopping(i)"
                >
                  <option
                    v-for="kindOfTopping in listOfTopping"
                    :value="kindOfTopping"
                    v-bind:key="kindOfTopping.id"
                  >
                    {{ kindOfTopping.name }}
                  </option>
                </select>
                <br />
                <br />

                <p>Quantity: {{ listOfChosenTopping[i].quantity }}</p>
                <button
                  class="btn btn-warning col-lg-5"
                  @click.prevent="addQuantityToping(i)"
                >
                  Increase
                </button>
                <button
                  class="btn btn-danger col-lg-5"
                  @click.prevent="removeToping(i)"
                >
                  Decrease
                </button>

                <br /><br />
              </div>
              <!-- on click: to add topping of pizza
        @event {click}: click: add the special requirement
        @event {model}: show the special requirement
        
      -->
              <br />

              <br />
              <div class="form-group">
                <label>Special Requirements</label>
                <textarea
                  class="form-control"
                  v-model="specialRequirement"
                  rows="4"
                ></textarea>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <br /><br />
    <!-- on click: to order new pizza
        @event {click}: click: to add new pizza
      
      -->
    <h2 class="d-flex justify-content-center">Price: {{ total }}$</h2>
    <div class="d-flex justify-content-center" style="margin-top: 15px">
      <button
        v-on:click.prevent="AddToCart()"
        class="btn btn-warning"
        style="margin-right: 10px; margin-left: 10px"
        v-if="isGotSize == true"
      >
        Order
      </button>
      <a href="../shoppingcart" class="btn btn-primary">
        Back to the Shopping Cart
      </a>
    </div>
  </div>
</template>
<script>
import Vue from "vue/dist/vue.js";
export default {
  name: "PizzaModify",

  created() {
    console.log(this.topping);
    this.chosenPizza = this.item[0];
    console.log(this.item[0]);
    this.chosenSize = {
      id: this.item[0]["item_price_id"],
      menu_item_id: this.item[0]["menu_item_id"],
      price: this.item[0]["price"],
      size: this.item[0]["size"],
    };
    this.addToping();
    let listOfChosenTopping = [];
    
    for (let i = 0; i < this.topping.length; i++) {
      console.log(this.topping[i]);
      listOfChosenTopping.push({
        item: this.topping[i],
        quantity: this.topping[i].quantity,
        showName: true,
      });
    }

    this.listOfChosenTopping = listOfChosenTopping;
    this.listOfPizzaType = this.itemprice;
    this.isGotSize = true;

    this.getTotal();
  },
  methods: {
    // Present the multiple dropdown to choose the pizza that user want to customize

    // Present the pizza end let the user to choose the size
    /**
     * This function responsible for presenting the pizza
     * @param array result response from the server
     * @param string error error response
     * @event success pop the toppings, recalculate the total
     * @event error log the error out to the console
     */
    presentPizza() {
      this.chosenSize = null;
      this.isGotSize = false;
      this.total = 0;
      //send request to the server
      axios({
        method: "GET",
        url: `api/customize/${this.chosenPizza.id}`,
      }).then(
        (response) => {
          // update the data to the main screen
          this.listOfPizzaType = response.data;
          // present the form to let user choose the type.
          this.isChoosingKindOfPizza = false;
        },
        (error) => {
          console.error(error);
        }
      );
    },
    /**
     * This function responsible for adding new items to cart
     * @param array result response from the server
     * @param string error error response
     * @event success first send the request to the database, then
     * send the request to database, then direct to homepage
     * @event error log the error out to the console
     */
    AddToCart() {
      console.log(this.chosenSize);
      console.log(this.listOfChosenTopping);
      //resprent the data
      axios({
        method: "PUT",
        url: `../api/modify/${this.id}`,
        data: {
          chosenPizza: this.chosenPizza,
          chosenSize: this.chosenSize,
          listOfChosenTopping: this.listOfChosenTopping,
          specialRequirement: this.specialRequirement,
        },
      }).then(
        (response) => {
          console.log(response.data);
          //direct user to homepage
          window.location.href = `../`;
          this.isChoosingKindOfPizza = true;
          this.isChoosingBase = true;
          this.pizzaList = [];
          this.chosenPizza = null;
          this.listOfPizzaType = [];
          this.chosenSize = null;
          this.listOfTopping = [];
          this.listOfChosenTopping = [];
          this.specialRequirement = null;
          this.didChooseSize = false;
          this.total = 0;
          this.isGotSize = false;
        },
        (error) => {
          console.error(error);
        }
      );
    },
    /**
     * This function responsible for adding new toppings to the pizza
     * @event success first send the request to the database, then
     * send the request to database, then direct to homepage
     * @event error log the error out to the console
     */
    addToping() {
      if (this.chosenSize) {
        this.didChooseSize = true;
        if (this.listOfChosenTopping.length <= 0) {
          axios({
            method: "GET",
            url: `../api/customize/size/${this.chosenSize.size}`,
          }).then(
            (response) => {
              this.listOfTopping = response.data;
            },
            (error) => {
              console.error(error);
            }
          );
        }
      }

      this.listOfChosenTopping.push({
        item: null,
        quantity: 0,
        showName: false,
      });
    },
    /**
     * This function responsible for deleting toppings
     * @param array result response from the server
     * @param string error error response
     * @event success pop the toppings, recalculate the total
     * @event error log the error out to the console
     */
    //delete topping
    removeToping(i) {
      if (this.listOfChosenTopping[i].quantity > 1) {
        this.listOfChosenTopping[i].quantity -= 1;
      } else {
        this.listOfChosenTopping.splice(i, 1);
      }

      this.getTotal();
    },
    increase() {
      this.chosenPizza.quantity += 1;
      this.getTotal();
    },
    decrease() {
      if (this.chosenPizza.quantity > 1) {
        this.chosenPizza.quantity -= 1;
      }
      this.getTotal();
    },
    /**
     * This function is responsible for calculating the total
     * @event success recalculate the total
     * @event error log the error out to the console
     */
    getTotal() {
      let total = 0; // reset the total to 0

      for (let i = 0; i < this.listOfChosenTopping.length; i++) {
        if (this.listOfChosenTopping[i].showName == true) {
          total +=
            parseFloat(this.listOfChosenTopping[i]["item"]["price"]) *
            parseFloat(this.listOfChosenTopping[i]["quantity"]);
        }
      }

      total += parseFloat(this.chosenSize["price"]);

      total = total * this.chosenPizza.quantity;
      this.total = total.toFixed(2);
    },
    /**
     * This function responsible for choosing a topping size
     * First get a size
     * Then reset the topping list
     * Recalculate the total again
     */
    chooseASize() {
      this.isGotSize = true;
      this.listOfChosenTopping = [];
      this.getTotal();
    },
    addQuantityToping(i) {
      console.log(this.listOfChosenTopping[i]["quantity"]);
      this.listOfChosenTopping[i].quantity += 1;
      this.getTotal();
    },
    chooseATopping(i) {
      this.listOfChosenTopping[i].showQuantity = true;
      this.listOfChosenTopping[i].quantity = 1;
      this.listOfChosenTopping[i].showName = true;
      this.getTotal();
    },
    deleteToping(i) {
      this.listOfChosenTopping.splice(i, 1);
    },
  },
  data: function () {
    return {
      isChoosingKindOfPizza: true,
      isChoosingBase: true,
      pizzaList: [],
      chosenPizza: null,
      listOfPizzaType: [],
      chosenSize: null,
      listOfTopping: [],
      listOfChosenTopping: [],
      specialRequirement: null,
      didChooseSize: false,
      total: 0,
      isGotSize: false,
    };
  },
  props: ["item", "itemprice", "id", "topping"],
};
</script>