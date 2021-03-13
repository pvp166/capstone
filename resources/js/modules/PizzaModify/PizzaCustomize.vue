<template>
  <div class="container">
    <!-- on change: to show a customize item
        @event {click}: click: show type of pizza that will be customer
        @event {object}: chose pizza
      -->
    <select class="form-control" v-model="chosenPizza" @change="presentPizza()">
      <option v-for="pizza in pizzaList" :value="pizza" :key="pizza.id">
        {{ pizza.name }}
      </option>
    </select>
    <div class="row" v-if="isChoosingKindOfPizza == false">
      <div class="col-lg-5" style="margin-top: 40px">
        <div class="card">
          <img
            class="card-img-top"
            :src="chosenPizza.item_image"
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
              <p>Quantity: {{ quantity }} pizzas</p>
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
                <div v-if="listOfChosenTopping[i].showQuantity == true">
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
                </div>
                <div v-if="listOfChosenTopping[i].showQuantity == false">
                  <button
                    class="btn btn-danger col-lg-5"
                    @click.prevent="deleteToping(i)"
                  >
                    Delete
                  </button>
                </div>

                <br />
              </div>

              <br />
              <!-- on click: to add topping of pizza
        @event {click}: click: add the special requirement
        @event {model}: show the special requirement
        
      -->
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

    <h2
      class="d-flex justify-content-center"
      v-if="isChoosingKindOfPizza == false"
    >
      Price: {{ total }}$
    </h2>
    <!-- on click: to order new pizza
        @event {click}: click: to add new pizza
      
      -->
    <div class="d-flex justify-content-center" style="margin-top: 15px">
      <button
        v-on:click.prevent="AddToCart()"
        class="btn btn-warning"
        style="margin-right: 10px; margin-left: 10px"
        v-if="isGotSize == true"
      >
        Order
      </button>
      <button v-on:click="backToHomepage()" class="btn btn-primary">
        Back to the homepage
      </button>
    </div>
  </div>
</template>
<script>
import Vue from "vue/dist/vue.js";
export default {
  name: "PizzaCustomize",
  created() {
    this.presentDefaultItem();
  },
  methods: {
    /**
     * This function responsible for respreting the multiple dropdown to choose the pizza that user want to customize
     * @param array result response from the server
     * @param string error error response
     * @event success close the form, let user to order new item
     * @event error log the error out to the console
     */

    presentDefaultItem() {
      // send the request to the server
      axios({ method: "GET", url: "api/customize" }).then(
        (response) => {
          //get all the pizza types, bases
          for (let i = 0; i < response.data.length; i++) {
            for (let k = 0; k < response.data[i].length; k++) {
              this.pizzaList.push(response.data[i][k]);
            }
          }
        },
        (error) => {
          console.error(error);
        }
      );
    },
    /**
     * This function responsible for respreting the the pizza end let the user to choose the size
     * @param array result response from the server
     * @param string error error response
     * @event success close the form, let user to order new item
     * @event error log the error out to the console
     */
    // Present
    presentPizza() {
      this.chosenSize = null;
      this.isGotSize = false;
      this.total = 0;
      //send the request to server
      axios({
        method: "GET",
        url: `api/customize/${this.chosenPizza.id}`,
      }).then(
        (response) => {
          // present them on the main screen
          this.listOfPizzaType = response.data;

          this.isChoosingKindOfPizza = false;
        },
        (error) => {
          console.error(error);
        }
      );
    },
    /**
     * This function responsible for adding the item to the shopping cart
     * @param array result response from the server
     * @param string error error response
     * @event success close the form, let user to order new item
     * @event error log the error out to the console
     */
    AddToCart() {
      
      this.listOfChosenTopping = this.listOfChosenTopping.filter((item) => {
        return item["showQuantity"] == true;
      });
      // send the array to server, update new items
      
      axios({
        method: "POST",
        url: `api/customize/add`,
        data: {
          chosenPizza: this.chosenPizza, // type of pizza
          chosenSize: this.chosenSize, // size of pizza
          listOfChosenTopping: this.listOfChosenTopping, // topping array
          specialRequirement: this.specialRequirement,
          quantity: this.quantity,
        },
      }).then(
        (response) => {
          
        },
        (error) => {
          console.error(error);
        }
      );
      // reset the form to the empty
      this.isChoosingKindOfPizza = true;
      this.isChoosingBase = true;

      this.chosenPizza = null;

      this.chosenSize = null;
      this.listOfTopping = [];
      this.listOfChosenTopping = [];
      this.specialRequirement = null;
      this.didChooseSize = false;
      this.total = 0;
      this.isGotSize = false;
    },
    /**
     * This function responsible for adding more toppings
     * @param array result response from the server
     * @param string error error response
     * @event success close the form, let user to order new item
     * @event error log the error out to the console
     */
    // more topping
    addToping() {
      if (this.chosenSize) {
        this.didChooseSize = true;
        if (this.listOfChosenTopping.length <= 0) {
          axios({
            method: "GET",
            url: `api/customize/size/${this.chosenSize.size}`,
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
        showQuantity: false,
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
      this.quantity += 1;
      this.getTotal();
    },
    decrease() {
      if (this.quantity > 1) {
        this.quantity -= 1;
      }
      this.getTotal();
    },
    /**
     * This function responsible for calculate the total

     */
    getTotal() {
      let total = 0; // reset the total to 0
      for (let i = 0; i < this.listOfChosenTopping.length; i++) {
        if (this.listOfChosenTopping[i].showQuantity == true) {
          total +=
            parseFloat(this.listOfChosenTopping[i]["item"]["price"]) *
            parseFloat(this.listOfChosenTopping[i]["quantity"]);
        }
      }
      total += parseFloat(this.chosenSize["price"]);
      total = total *this.quantity;
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
    /**
     * Redirect to the homepage
     */
    backToHomepage() {
      window.location.href = "./";
    },
    addQuantityToping(i) {
      
      this.listOfChosenTopping[i].quantity += 1;
      this.getTotal();
    },
    chooseATopping(i) {
      this.listOfChosenTopping[i].showQuantity = true;
      this.listOfChosenTopping[i].quantity = 1;
      this.getTotal();
    },
    deleteToping(i) {
      this.listOfChosenTopping.splice(i, 1);
    },
  },

  data: function () {
    return {
      isChoosingKindOfPizza: true, //The kind of pizza which is beign chosen now
      isChoosingBase: true, // The kind of base is choosen now
      pizzaList: [], // list of pizza in order
      chosenPizza: null, // the pizza which is chosen by the user
      listOfPizzaType: [], // the list of pizza type
      chosenSize: null, // the size of pizza that user want to choosen
      listOfTopping: [], // the list of topping
      listOfChosenTopping: [], //list of Topping the user want to choose
      specialRequirement: null, // list of special requirement from the user
      didChooseSize: false, // check if the user chose a size
      total: 0,
      isGotSize: false,
      quantity: 1,
    };
  },
};
</script>