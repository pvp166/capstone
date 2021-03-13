<template>
  <div id="homepage">
    <main role="main">
      <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading">VanRestaurant</h1>
        </div>
      </section>
      <!-- trigered on click
        @event showFilterForm show the filter form
        @event removeSort reversed to normal state
        @event submit submit the form to sort the item
        @property {string} min price: input for min price
        @property {string} max price: input for max price
        @property {string} name: input for name
        @property {string} item type: input for the item type
      -->
      <div class="album py-5 bg-light">
        <div class="container">
          <button class="btn btn-warning" @click="showFilterForm()">
            Sorted Form
          </button>
          <br /><br />
          <button class="btn btn-primary" @click="removeSort()">
            Remove Sorting
          </button>
          <br /><br />
          <form v-if="showForm == true">
            <p>Price Range</p>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Min Price</label>
              <div class="col-sm-10">
                <input class="form-control col-lg-4" v-model="rangeMin" />
                <small class="text-danger" v-if="showValidateMin == true">
                  Please enter a number
                </small>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Max Price</label>
              <div class="col-sm-10">
                <input class="form-control col-lg-4" v-model="rangeMax" />
                <small class="text-danger" v-if="showValidateMax == true">
                  Please enter a number
                </small>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                <input class="form-control col-lg-4" v-model="name" />
                <small class="text-danger" v-if="showValidateLetter == true">
                  Please enter only characters
                </small>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Item Type</label>
              <div class="col-sm-10">
                <select class="custom-select col-lg-4" v-model="chosenType">
                  <option value="-1">All</option>
                  <option
                    v-for="type in itemTypeList"
                    v-bind:key="type.id"
                    :value="type.id"
                  >
                    {{ type.type }}
                  </option>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-10">
                <button
                  type="submit"
                  class="btn btn-primary"
                  @click.prevent="findNewItem()"
                >
                  Submit
                </button>
              </div>
            </div>
          </form>
          <br />
          <!-- trigered on click
        @event showFilterForm show the filter form
        @event removeSort reversed to normal state
        @event change change the form to sort the item
          -->
          <div class="form-group row">
            <label class="col-sm-2 col-form-label"
              >Please choose a Item Type (Pizza, Sides, Salad, ...)
            </label>
            <div class="col-sm-10">
              <select
                class="custom-select col-lg-4"
                v-model="showingItemType"
                @change="showMainScreen()"
              >
                <option
                  v-for="type in typeList"
                  v-bind:key="type.id"
                  :value="type.id"
                >
                  {{ type.type }}
                </option>
              </select>
            </div>
          </div>
          <a
            href="./customize"
            class="btn btn-primary"
          >
            Create your own 
          </a>
          <!-- trigered on click
        @event chooseIt choose the pizza
        @event addNew add new item to shopping cart
        @event customize customize the pizza
        @property {string} item.name
        @property {string} item.description
        @property {string} item.size
        @property {string} item.price
          -->
          <br /><br /><br />
          <div class="row">
            <div
              class="col-md-4"
              v-for="(item, key) in presentData"
              v-bind:key="key"
            >
              <div class="card mb-4 box-shadow">
                <img
                  class="card-img-top"
                  :src="item.item_image"
                  alt="Card image cap"
                />
                <div class="card-body">
                  <p class="card-text">
                    {{ item.name }}
                  </p>
                  <p class="card-text">
                    {{ item.description }}
                  </p>
                  <br />
                  <p>{{ item.size }} - {{ item.price }}$</p>
                  <p></p>
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <div class="btn-group">
                      <button
                        @click="addNew(item.id)"
                        class="btn btn-sm btn-outline-secondary"
                        v-if="
                          item['item_type_id'] == 1 ||
                          item['item_type_id'] == 2 ||
                          item['item_type_id'] == 7
                        "
                      >
                        Customize Pizza
                      </button>

                      <button
                        @click="ChooseIt(item.id)"
                        class="btn btn-sm btn-outline-secondary"
                        v-if="
                          item['item_type_id'] != 1 &&
                          item['item_type_id'] != 2 &&
                          item['item_type_id'] != 7
                        "
                      >
                        Choose It
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- trigger when changed
        @event change the size pizza
        
          -->
          <div v-if="showOrderForm == true">
            <p>Chosen Item: {{ formChosenType.name }}</p>
            <select class="custom-select col-lg-10" v-model="formChosenItem">
              <option v-for="type in formType" v-bind:key="type.id">
                {{ type.size }}
              </option>
            </select>
            <p>Quantity: {{ quantity }}</p>
            <button
              @click="increase()"
              class="btn btn-sm btn-outline-secondary"
            >
              Increase
            </button>
            <button
              @click="decrease()"
              class="btn btn-sm btn-outline-secondary"
            >
              Decrease
            </button>
            <br /><br />
            <button
              @click="orderNew()"
              class="btn btn-sm btn-outline-secondary"
            >
              Choose It
            </button>
          </div>
          <br /><br />
          <!-- trigger on click
        @event click prevPage change to another page
        @event click nextPage change to another page
          -->
          <div class="row">
            <button @click="prevPage()" class="btn btn-warning">
              Previous
            </button>
            <button @click="nextPage()" class="btn btn-primary">Next</button>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>
<script>
export default {
  name: "Homepage",
  created() {
    this.getMenuItems();
    this.getItemType();
  },
  data() {
    return {
      reservedSortedList: [], // the list contains sorted item, reserved the original items
      typeList: [], // type list to cotain all type of items
      showingItemType: 0, // current showing item type
      showValidateLetter: false, // validate the name field if it is all characters
      showValidateMin: false, // validate the min field if it is all number
      showValidateMax: false, // validate the max field if it is all number
      name: "", // name of the item
      rangeMin: "", // min price
      rangeMax: "", // max price
      chosenType: -1, // type of item that users want to sort
      currentPage: 0, // present the page
      dataItem: [], // list of items which response from the array
      sortedData: [], // list of items after sorting
      presentData: [], // list of items that present on the screen
      showForm: false, // show the form for users to sort new items
      itemTypeList: [], // list of items type which are available in the menu
      formChosenItem: null, // items that is chosen by users
      formType: null, // list of item type for the form below
      formChosenType: null, // type for item below
      showOrderForm: false, // the form to customize items(which are not pizzas)
      currentId: null, // current Id of the item
      quantity: 1,
    };
  },
  methods: {
    /**
     * This function responsilbe for finding the items based on min, max, name and type
     * @var letters the letters regex which help users to validate the form
     * @var float min: min price
     * @var float max: max price
     */
    findNewItem() {
      //Validate the Min form
      if (this.rangeMin.length > 0) {
        // check if the min input contains only numbers
        if (!isNaN(this.rangeMin) && !isNaN(parseFloat(this.rangeMin))) {
          this.showValidateMin = false;
        } else {
          this.showValidateMin = true;
        }
      } else {
        this.showValidateMin = false;
      }

      //check if the max input contains only numbers
      if (this.rangeMax.length > 0) {
        if (!isNaN(this.rangeMax) && !isNaN(parseFloat(this.rangeMax))) {
          this.showValidateMax = false;
        } else {
          this.showValidateMax = true;
        }
      } else {
        this.showValidateMax = false;
      }

      var letters = /^[A-Za-z]+$/;
      // check if the name input contains letters
      if (this.name.length > 0) {
        if (this.name.match(letters)) {
          this.showValidateLetter = false;
        } else {
          this.showValidateLetter = true;
        }
      } else {
        this.showValidateLetter = false;
      }

      // if all inputs are correct, send them to the server.
      if (
        this.showValidateMin == false &&
        this.showValidateMax == false &&
        this.showValidateLetter == false
      ) {
        let min = 0;
        let max = 0;
        // Check if min is null. If null set it to 0
        if (this.rangeMin === "") {
          min = 0;
        } else {
          min = this.rangeMin;
        }
        //Check if max is null. If null, set it to 100
        if (this.rangeMax == "") {
          max = 999;
        } else {
          max = this.rangeMax;
        }
        // search by the min price and max price
        let filteredRecords = this.dataItem.filter((item) => {
          return (
            item["price"] >= min &&
            item["price"] <= max &&
            item["item_type_id"] != 8
          );
        });

        let type = 0;
        // search by chosen type, first check if the chosen type is not all the type
        // then search
        if (this.chosenType >= 0) {
          type = this.itemTypeList.filter((item) => {
            return item["id"] == this.chosenType;
          });

          // search for type
          filteredRecords = filteredRecords.filter((item) => {
            return item["type"] == type[0]["type"];
          });
        }
        // check if name field empty and search for name
        if (this.name.length > 0 || this.name !== null) {
          filteredRecords = filteredRecords.filter((item) => {
            return (
              item["name"].toLowerCase().search(this.name.toLowerCase()) > -1
            );
          });
        }

        this.sortedData = filteredRecords;
        this.presentData = [];
        if (this.sortedData.length > 0)
          this.presentData.push(this.sortedData[0]);
        if (this.sortedData.length > 1)
          this.presentData.push(this.sortedData[1]);
        if (this.sortedData.length > 2)
          this.presentData.push(this.sortedData[2]);
        this.name = "";
        this.rangeMin = "";
        this.rangeMax = "";
      }
    },
    /**
     * This function responsilbe for open and close the validation form
     */
    showFilterForm() {
      if (this.showForm == false) {
        this.showForm = true;
      } else this.showForm = false;
    },

    /**
     * This function responsilbe for open and close the validation form
     */
    removeSort() {
      this.sortedData = this.reservedSortedList;
    },
    /**
     * This function responsilbe for showing all the data type
     * @param array response response from the server
     * @param string error error response
     * @event success show all the data type
     * @event error log the error out to the console
     */
    getItemType() {
      // get items from the database to present on the main screen
      axios({ method: "GET", url: `api/itemtypes/` }).then(
        (response) => {
          this.itemTypeList = response.data;
          for (let i = 0; i < response.data.length; i++) {
            if (response.data[i]["id"] != 8 && response.data[i]["id"] != 7) {
              this.typeList.push(response.data[i]);
            }
          }
        },
        (error) => {
          console.error(error);
        }
      );
    },
    /**
     * This function responsilbe for getting all the menu items from the database to the mainscreen
     * @param array response response from the server
     * @param string error error response
     * @event success show all the items from the menu to the mainscreen and divide them into pages
     * @event error log the error out to the console
     */
    getMenuItems() {
      axios({ method: "GET", url: `api/menuitems/` }).then(
        (response) => {
          this.dataItem = response.data;
          for (let i = 0; i < response.data.length; i++) {
            if (
              // check if these items are not pizza base or topping
              response.data[i]["item_type_id"] != 8 &&
              response.data[i]["item_type_id"] != 7
            ) {
              if (
                // only show the medium size
                response.data[i]["size"] == "Medium" ||
                response.data[i]["size"] == "10 Wings" ||
                response.data[i]["size"] == "1 Medium" ||
                response.data[i]["size"] == "1 Pop Can" ||
                response.data[i]["size"] == "1 Medium Bow" ||
                response.data[i]["size"] == "1 Small Dip"
              ) {
                this.sortedData.push(response.data[i]);
              }
            }
          }
          this.reservedSortedList = this.sortedData;
          // present them to the screen
          this.presentData.push(this.sortedData[0]);
          if (this.sortedData.length > 1)
            this.presentData.push(this.sortedData[1]);
          if (this.sortedData.length > 2)
            this.presentData.push(this.sortedData[2]);
        },
        (error) => {
          console.error(error);
        }
      );
    },
    /**
     * This function responsilbe for getting all the menu items from the database to the mainscreen
     * @param array response response from the server
     * @param string error error response
     * @event success show all the items from the menu to the mainscreen and divide them into pages
     * @event error log the error out to the console
     */
    showMainScreen() {
      if (this.sortedData != 0) {
        this.sortedData = [];

        for (let i = 0; i < this.dataItem.length; i++) {
          {
            if (this.dataItem[i]["item_type_id"] == this.showingItemType)
              this.sortedData.push(this.dataItem[i]);
          }
        }
      }

      this.presentData = [];
      // present them to the screen
      this.presentData.push(this.sortedData[0]);
      if (this.sortedData.length > 1) this.presentData.push(this.sortedData[1]);
      if (this.sortedData.length > 2) this.presentData.push(this.sortedData[2]);
    },
    /**
     * This function responsilbe for present the previous page
     */
    prevPage() {
      // decrease the page number
      if (this.currentPage == 0) {
        this.currentPage = 0;
      } else {
        this.currentPage -= 1;
      }
      this.presentData = [];
      // load new data
      this.presentData.push(this.sortedData[this.currentPage * 3 + 0]);
      if (this.sortedData.length > 1)
        this.presentData.push(this.sortedData[this.currentPage * 3 + 1]);
      if (this.sortedData.length > 2)
        this.presentData.push(this.sortedData[this.currentPage * 3 + 2]);
    },
    /**
     * This function responsilbe for present the next page
     */
    nextPage() {
      // increase the page number
      if ((this.currentPage + 1) * 3 < this.sortedData.length) {
        this.currentPage += 1;
      }
      this.presentData = [];
      // load new data
      this.presentData.push(this.sortedData[this.currentPage * 3 + 0]);
      if (this.sortedData[this.currentPage * 3 + 2])
        this.presentData.push(this.sortedData[this.currentPage * 3 + 1]);
      if (this.sortedData[this.currentPage * 3 + 2])
        this.presentData.push(this.sortedData[this.currentPage * 3 + 2]);
    },
    /**
     * This function responsilbe for adding all the new item to the main screen
     * @param int id user id
     * @param array response response from the server
     * @param string error error response
     * @event success show all the items from the menu to the mainscreen and divide them into pages
     * @event error log the error out to the console
     */
    addNew(id) {
      axios({
        method: "POST",
        url: `api/menuitems/homepage/createNew/${id}`,
      }).then(
        (response) => {
          console.log(response.data);
          if (response.data[0].signin == false)
            window.location.href = "./login";
          else {
            let item_id = response.data[3]["order_item"].id;

            window.location.href = `./modify/${item_id}`;
          }
        },
        (error) => {
          console.error(error);
        }
      );
    },
    /**
     * This function responsilbe for choosing an item from the order form
     * @param int id user id
     * @var array list of item sizes
     */
    ChooseIt(id) {
      //show the form to add item
      if (this.showOrderForm == false) {
        this.showOrderForm = true;
      } else this.showOrderForm = false;

      for (let i = 0; i < this.dataItem.length; i++) {
        if (id == this.dataItem[i]["id"]) {
          this.formChosenItem = this.dataItem[i];
        }
      }
      //present the item size into a list
      let size = [];
      for (let i = 0; i < this.dataItem.length; i++) {
        if (this.formChosenItem["name"] == this.dataItem[i]["name"]) {
          size.push(this.dataItem[i]);
        }
      }
      this.formChosenType = this.formChosenItem;

      this.formType = size;
      this.currentId = this.formChosenType["menu_item_id"];
    },
    /**
     * This function responsilbe for ordering a new item which are not pizzas
     * @param int id user id
     * @param array response response from the server
     * @param string error error response
     * @event success close the form, let user to order new item
     * @event error log the error out to the console
     */
    orderNew() {
      // send request to the server
      axios({
        method: "POST",
        url: `api/menuitems/newItem/orderNew`,
        data: {
          id: this.currentId, // id of the item
          size: this.formChosenItem, //  size of the item
          quantity: this.quantity,
        },
      }).then(
        (response) => {
          // close the form
          this.formChosenType = null;
          this.formChosenItem = null;
          this.showOrderForm = false;
          this.formType = [];
          this.currentId = null;
        },
        (error) => {
          console.error(error);
        }
      );
    },
    /**
     * This function responsilbe for increasing the quantity
     */
    increase() {
      this.quantity += 1;
    },
    /**
     * This function responsilbe for decreasing the quantity
     */
    decrease() {
      if (this.quantity > 1) {
        this.quantity -= 1;
      }
    },
    createYourOwn(){

    }
  },
};
</script>
