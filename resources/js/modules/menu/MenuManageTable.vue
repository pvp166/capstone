<template>
  <div class="container">
    <div class="row">
      <div class="col-md-10 mx-auto">
        <h1 class="text-center">Menu Manage</h1>
        <!--This section is responsilbe for updating the table information
        It includes name, description, and item type
        When hit submit button it will send the form to server by method addNewItems
        -->
        <!-- trigger on click
        @event click addNewItem add new Item to table
        @property {string} item name the item name input
        @property {string} the description input
        @property {string} nextPage change to another page
          -->
        <form v-on:submit.prevent="addNewItem">
          <label for="itemnameinput">Item Name</label>
          <input
            type="text"
            v-model="itemname"
            id="itemnameinput"
            class="form-control"
            placeholder="Please Enter Item Name"
          />
          <label for="descriptioninput">Description</label>
          <input
            type="text"
            v-model="description"
            id="descriptioninput"
            class="form-control"
            placeholder="Please Enter Item Name"
          />
          <!-- add new price
        @event  addNewPrice add new item price to the form
        @property {string} item size
        @property {string} item price
          -->
          <br /><br />
          <div v-if="isEdit == true">
            <div class="row" v-for="(item, k) in SizeAndPrice" v-bind:key="k">
              <div class="col-lg-2">
                <label for="descriptioninput">Item Size</label>
              </div>

              <div class="col-lg-4">
                <input type="text" class="form-control" v-model="item.size" />
              </div>
              <div class="col-lg-2">
                <label for="descriptioninput">Item Price</label>
              </div>

              <div class="col-lg-4">
                <input type="text" class="form-control" v-model="item.price" />
              </div>
            </div>
            <div class="col-lg-4">
              <button
                v-on:click="addNewPriceItem()"
                type="button"
                class="btn btn-warning btn-block mt-3"
              >
                Add Item Price
              </button>
            </div>
          </div>
          <!-- This will appear for the create form -->
          <div v-if="isEdit == false">
            <div class="row" v-for="(item, k) in SizeAndPrice" v-bind:key="k">
              <div class="col-lg-2">
                <label for="descriptioninput">Item Size</label>
              </div>

              <div class="col-lg-4">
                <input type="text" class="form-control" v-model="item.size" />
              </div>
              <div class="col-lg-2">
                <label for="descriptioninput">Item Price</label>
              </div>

              <div class="col-lg-4">
                <input type="text" class="form-control" v-model="item.price" />
              </div>
            </div>
            <div class="col-lg-4">
              <button
                v-on:click="addNewPriceItem()"
                type="button"
                class="btn btn-warning btn-block mt-3"
              >
                Add Item Price
              </button>
            </div>
          </div>

          
          <br /><br />
          <label for="itemtypeinput">Item Type</label>
          <select v-model="item_type_id">
            <option
              v-for="itemType in itemTypes"
              v-bind:key="itemType.id"
              v-bind:value="itemType.id"
            >
              {{ itemType.type }}
            </option>
          </select>
          <button
            v-if="this.isEdit == false"
            type="submit"
            class="btn btn-success btn-block mt-3"
          >
            Create
          </button>
          <button
            v-else
            v-on:click="updateMenuItem()"
            type="button"
            class="btn btn-success btn-block mt-3"
          >
            Update
          </button>
        </form>
        <br /><br />
        <!-- add sorting form: on change
        @event change column sort: to change the sort field
        @property {dropdown} change the column
        @event direction column sort: to change the direction 
        @property {dropdown} change the direction
          -->
        <form>
          <h4>Sorting form</h4>
          <br />
          <div class="dropdown row">
            <label>Columns:</label>
            <select v-model="column" class="col-lg-3" @change="columnSort()">
              <option
                v-for="(column, key) in columns"
                v-bind:key="key"
                v-bind:value="column"
              >
                {{ column }}
              </option>
            </select>
          </div>
          <br />
          <div class="dropdown row">
            <label>Direction:</label>
            <select v-model="direction" class="col-lg-3" @change="columnSort()">
              <option
                v-for="(direction, key) in directions"
                v-bind:key="key"
                v-bind:value="direction"
              >
                {{ direction }}
              </option>
            </select>
          </div>
        </form>
        <br />
        <!-- add sorting form: on change
        @event {keydown}: name filter to filter name
        @property {dropdown} Name filter
        @event {keydown}: item type filte 
        @property {dropdown} item type filter
        @event {keydown}: description filter 
        @property {dropdown} change the description 
          -->
        <form>
          <h4>Filtering form</h4>
          <br />
          <div class="col">
            <label for="">Name Filter</label>
            <input
              type="text"
              class="form-control"
              placeholder=""
              v-model="filterItemName"
              @keyup="filter()"
            />
          </div>
          <br />

          <div class="col">
            <label for="">Item Type Filter</label>
            <input
              type="text"
              class="form-control"
              placeholder=""
              v-model="filterItemType"
              @keyup="filter()"
            />
          </div>
          <br />
          <div class="col">
            <label for="">Description Filter</label>
            <input
              type="text"
              class="form-control"
              placeholder=""
              v-model="filterItemDescription"
              @keyup="filter()"
            />
          </div>
        </form>

        <br />
        <!-- table
        present the menu item
          -->

        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Description</th>
              <th>Item Type</th>
              <th>Food Image</th>
              <th>Item size</th>
              <th>Item price</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(menuItem, index) in menuItems"
              v-bind:key="index"
              v-bind:title="menuItem.name"
            >
              <td>{{ index + 1 }}</td>
              <td>{{ menuItem.name }}</td>
              <td>{{ menuItem.description }}</td>
              <td>{{ menuItem.type }}</td>
              <td><img :src="menuItem.item_image" /></td>
              <td>{{ menuItem.size }}</td>
              <td>{{ menuItem.price }}</td>
              <td>
                <button
                  v-on:click="deleteMenuItem(menuItem['menu_item_id'])"
                  class="btn btn-danger"
                >
                  Delete
                </button>
              </td>
              <td>
                <button
                  v-on:click="onEditMenuItem(menuItem['menu_item_id'])"
                  class="btn btn-primary"
                >
                  Update
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue/dist/vue.js";
export default {
  name: "MenuManageTable",
  created() {
    this.getMenuItems();
    this.getItemTypes();
  },
  methods: {
    /**
     * This function responsilbe for sorting the table by name
     */
    columnSort() {
      //['ID','Type', 'Name', 'Price']
      //directions: ['Ascending', 'Descending']
      if (this.column == "ID") {
        if (this.direction == "Ascending")
          this.menuItems.sort(function (a, b) {
            return a["id"] - b["id"];
          });
        else
          this.menuItems.sort(function (a, b) {
            return b["id"] - a["id"];
          });
      }
      if (this.column == "Type") {
        if (this.direction == "Ascending")
          this.menuItems.sort(function (a, b) {
            return a["item_type_id"] - b["item_type_id"];
          });
        else
          this.menuItems.sort(function (a, b) {
            return b["item_type_id"] - a["item_type_id"];
          });
      }
      if (this.column == "Name") {
        if (this.direction == "Ascending")
          this.menuItems.sort(function (a, b) {
            return a["name"] - b["name"];
          });
        else
          this.menuItems.sort(function (a, b) {
            return b["Name"] - a["Name"];
          });
      }
      if (this.column == "Price") {
        if (this.direction == "Ascending")
          this.menuItems.sort(function (a, b) {
            return a["price"] - b["price"];
          });
        else
          this.menuItems.sort(function (a, b) {
            return b["price"] - a["price"];
          });
      }
      this.reservedMenuItems = this.menuItems;
    },
    // filterItemName: '', // name to filter
    //   filterItemType: '', // item type to filter
    //   filterItemDescription: '', // description to filter
    filter() {
      this.menuItems = this.reservedMenuItems;
      if (this.filterItemName.length > 0) {
            let filteredRecords = this.menuItems.filter(menuItem => {
              return menuItem['name'].toLowerCase().search(this.filterItemName.toLowerCase()) > -1;
            });

            this.menuItems = filteredRecords;
          }
      if (this.filterItemType.length > 0) {
            let filteredRecords = this.menuItems.filter(menuItem => {
              return menuItem['type'].toLowerCase().search(this.filterItemType.toLowerCase()) > -1;
            });

            this.menuItems = filteredRecords;
          }
       if (this.filterItemDescription.length > 0) {
            let filteredRecords = this.menuItems.filter(menuItem => {
              return menuItem['description'].toLowerCase().search(this.filterItemDescription.toLowerCase()) > -1;
            });

            this.menuItems = filteredRecords;
          }
    },
    
    
    /**
     * This function responsilbe for showing all item from the menu
     * @param array response response from the server
     * @param string error error response
     * @event success close the form, let user to order new item
     * @event error log the error out to the console
     */
    getMenuItems() {
      // send request to server
      axios({ method: "GET", url: "api/menuitems" }).then(
        (response) => {
          console.log(response.data);
          // update the menu items
          let menuItems = response.data;
          // sort them by the item type
          

          // present on the main screen
          this.menuItems = menuItems;
          this.reservedMenuItems = menuItems;
        },
        (error) => {
          console.error(error);
        }
      );
    },

    /**
     * This function responsilbe for representing one item to the main screen
     * @param int id the id of item
     * @param array response response from the server
     * @param string error error response
     * @event success close the form, let user to order new item
     * @event error log the error out to the console
     */
    getAMenuItem(id) {
      axios({ method: "GET", url: `api/menuitems/${id}` }).then(
        (response) => {
          this.itemname = response.data[0].name;
          this.description = response.data[0].description;
          this.item_type_id = response.data[0].item_type_id;
          for (let i = 0; i < response.data.length; i++) {
            this.SizeAndPrice.push({
              id: response.data[i]["id"],
              size: response.data[i]["size"],
              price: response.data[i]["price"],
            });
          }
        },
        (error) => {
          console.error(error);
        }
      );
    },
    /**
     * This function responsilbe for ordering new item types.
     * @param int id user id
     * @param array response response from the server
     * @param string error error response
     * @event success close the form, let user to order new item
     * @event error log the error out to the console
     */
    getItemTypes() {
      // send request to the server
      axios({ method: "GET", url: "api/itemtypes" }).then(
        (response) => {
          //present the list of item type to the screen
          this.itemTypes = response.data;
        },
        (error) => {
          console.error(error);
        }
      );
    },
    /**
     * This function responsilbe for deleting the item from menu
     * @param int menu item id
     * @param response response response from the server
     * @param string error error response
     * @event success close the form, let user to order new item
     * @event error log the error out to the console
     */
    deleteMenuItem(id) {
      //send the delete request to the server
      axios({ method: "DELETE", url: `api/menuitems/${id}` }).then(
        (response) => {
          // present new list item to the mainscreen
          this.getMenuItems();
        },
        (error) => {
          console.error(error);
        }
      );
    },
    /**
     * This function responsilbe for presenting the edit form.
     * @param int id the id that user want to edit
     */
    onEditMenuItem(id) {
      this.SizeAndPrice = []; // reset the arrya
      this.getAMenuItem(id); // get new item
      this.isEdit = true; // show the form
      this.onEditId = id; // change the id
    },

    /**
     * This function responsible for updating item in the menu
     * @param int onEditId user id
     * @param array result response from the server
     * @param string error error response
     * @event success close the form, let user to order new item
     * @event error log the error out to the console
     */
    updateMenuItem() {
      // send the response to the request
      axios({
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
        },
        url: `api/menuitems/${this.onEditId}`,
        data: {
          name: this.itemname,
          description: this.description,
          item_type_id: this.item_type_id,
          itemSizeList: this.SizeAndPrice,
        },
      }).then((result) => {
        // reset the form
        this.SizeAndPrice = [];
        this.itemname = "";
        this.description = "";
        this.item_type_id = 0;
        this.onEditId = 0;
        this.isEdit = false;
        this.getMenuItems();
      });
    },
    /**
     * This function responsible for adding a new item to the database
     * @param int id user id
     * @param array result response from the server
     * @param string error error response
     * @event success close the form, let user to order new item
     * @event error log the error out to the console
     */
    addNewItem() {
      // send a post request to the server
      axios({
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        url: `api/menuitems`,
        data: {
          name: this.itemname,
          description: this.description,
          item_type_id: this.item_type_id,
          itemSizeList: this.SizeAndPrice,
        },
      }).then((result) => {
        // reset the form to default
        this.itemname = "";
        this.description = "";
        this.item_type_id = 0;
        this.onEditId = 0;
        this.isEdit = false;
        this.getMenuItems();
      });
    },
    /**
     * This function responsilbe for ordering a new item which are not pizzas
     * @param int id user id
     * @param array response response from the server
     * @param string error error response
     * @event success close the form, let user to order new item
     * @event error log the error out to the console
     */
    addNewPriceItem() {
      this.SizeAndPrice.push({
        id: -1,
        size: "Small",
        price: 0.0,
      });
    },
  },

  data() {
    return {
      menuItems: null, // all items in the menu
      itemTypes: null, // all the item types
      onEditId: 0, // the item which is currently being edited
      itemname: "", // name of the item showing on the form
      description: "", // descprtion of the item showing on the form
      item_type_id: 0, // item id showing on the form
      isEdit: false, // let user edit the form
      SizeAndPrice: [], // list of size and price for this item
      reservedMenuItems: null, // reserved the first state of the menu
      columns: ["ID", "Type", "Name", "Price"], // list of Columns to sort
      directions: ["Ascending", "Descending"], // directions to sort
      column: "Type", // column to sort
      direction: "Descending", // direction to sort
      filterItemName: '', // name to filter
      filterItemType: '', // item type to filter
      filterItemDescription: '', // description to filter
    };
  },
};
</script>