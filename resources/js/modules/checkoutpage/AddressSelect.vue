
<template>
  <div id="address-select">
    <div class="row">
      <!-- trigered on click
    @event createAddress create new address
    @event updateAddress update new address
    @property {string} - fullname#
    @property {string} address_line_1 - address_line_1
    @property {string} address_line_2 - address_line_2
    @property {string} province - province
    @property {string} city - city
    @property {string} postalcode - postalcode
    @property {string} telephone number - telephone number
    @property {string} other_address - other_address
    @property {string} form validation - form validation
      -->
      <form class="col-lg-6" @submit.prevent="">
        <fieldset>
          <h2>Add a new address</h2>
          <div class="form-group">
            <label for="fullname">Full Name</label>
            <input
              type="text"
              v-model="full_name"
              class="form-control"
              placeholder="Please enter your full name"
              required
            />
            <small class="text-danger" v-if="nameValidate == true">
              Please enter your name
            </small>
          </div>
          <div class="form-group">
            <label for="streetaddress"> Address Line 1(or Company Name)</label>
            <input
              type="text"
              v-model="address_line_1"
              class="form-control"
              placeholder="Street address, P.O box, company name, c/o"
              required
            />
            <small v-if="addressLine1Validate == true" class="text-danger">
              Please enter address line 1
            </small>
          </div>
          <div class="form-group">
            <label for="streetaddress"> Address Line 2(optional)</label>
            <input
              type="text"
              v-model="address_line_2"
              class="form-control"
              placeholder="Apartment, suite, unit, building, floor, etc"
            />
          </div>
          <div class="form-group">
            <label for="city">City</label>
            <input type="text" class="form-control" v-model="city" required />
            <small class="text-danger" v-if="cityValidate == true">
              Please enter a city name
            </small>
          </div>

          <div class="form-group">
            <label for="province">Province/territory</label>
            <input
              type="text"
              class="form-control"
              v-model="province"
              required
            />
            <small class="text-danger" v-if="ProvinceValidate == true">
              Please enter a province name
            </small>
          </div>
          <div class="form-group">
            <label for="postalcode">Postal Code</label>
            <input
              type="text"
              class="form-control"
              v-model="postal_code"
              required
            />
            <small class="text-danger" v-if="Postalcodevalidate == true">
              Please enter a postal code
            </small>
          </div>
          <div class="form-group">
            <label for="telephone_number">Telephone Number</label>
            <input
              type="text"
              class="form-control"
              v-model="customer_phone"
              required
            />
            <small class="text-danger" v-if="telephonevalidate == true">
              Please enter a phone number
            </small>
          </div>
          <div class="form-group">
            <label for="other_address">Other Address</label>
            <input
              type="text"
              class="form-control"
              v-model="other_address"
              placeholder="special intructions to ship items to your house"
            />
          </div>

          <button
            type="submit"
            v-if="this.isEdit == false"
            v-on:click="createAddress()"
            class="btn btn-primary btn-block mt-3"
          >
            Create
          </button>
          <button
            v-else
            v-on:click="updateAddress()"
            type="button"
            class="btn btn-success btn-block mt-3"
          >
            Update
          </button>
        </fieldset>
      </form>
      <!-- Recently used address
    @event checkOut(address[i]) 
    @event editAddress(address['id'])
    @event deleteAddress(address['id'])
    @property {string} - name: address[fullname]
    @property {string} - name: address[address_line_1]
    @property {string} - name: address[city]
    @property {string} - name: address[postal_code]
      -->
      <div class="col-lg-6">
        <h2>Recently used address</h2>
        <ul
          class="list-group mb-3"
          v-for="(address, index) in addressList"
          v-bind:key="index"
        >
          <li class="list-group-item">
            <div>
              <h4 class="my-0">Name: {{ address["full_name"] }}</h4>
              <h4 class="my-0">Address: {{ address["address_line_1"] }}</h4>
              <h4 class="my-0">City: {{ address["city"] }}</h4>
              <h4 class="my-0">Postalcode: {{ address["postal_code"] }}</h4>
              <small class="text-muted"></small>
            </div>
            <br /><br />
            <button
              class="btn btn-primary col-lg-12"
              @click="checkOut(address['id'])"
            >
              Deliver to this address
            </button>
            <br /><br />

            <button
              class="btn btn-warning col-lg-12"
              v-on:click="editAddress(address['id'])"
            >
              Edit
            </button>
            <br /><br />
            <button
              class="btn btn-danger col-lg-12"
              v-on:click="deleteAddress(address['id'])"
            >
              Delete
            </button>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  /**
   * This component present the address select page.
   * @addressSelect Address Select
   */
  name: "AddressSelect",
  data: function () {
    return {
      addressList: null, // list of users' address
      full_name: null, // user's full name
      address_line_1: null,// address 1 from users which are street address, company name
      address_line_2: null, // address 2 from users: apartment suit, unit, building
      city: null, // present the city on the form
      province: null, // present the province on the form
      other_address: null, // room, suite, etc
      postal_code: null, // postal code
      customer_phone: null, //  the customer's phone number
      isEdit: false, // if true, present the edit form
      editId: "", // to indicate which user's address is being edited
      nameValidate: false, // to validate the user name
      addressLine1Validate: false, // to validate the user address line 2
      cityValidate: false, // validate the city where user live
      ProvinceValidate: false, // validate the province where user live
      Postalcodevalidate: false, // validate the postal code
      telephonevalidate: false, // validate the phone number
      allFormValidate: false, // check if all the input validate and send back the server
    };
  },
  created() {
    this.getAddress();
  },
  methods: {
    /**
     * This function responsilbe for representing the address table to main screen
     * @var array addressList save the list of address each user has
     * @param array response response from the database
     * @param error error response
     * @event success present the address to the screen
     * @event error log the error out to the console
     */
    getAddress() {
      axios({ method: "GET", url: "api/address" }).then(
        (response) => {
          this.addressList = response.data;
        },
        (error) => {
          console.error(error);
        }
      );
    },
    /**
     * This function responsible for letting users edit their addresses.
     * @param array response response from the database
     * @param string error error response
     * @event success update the the address, present to the screen
     * @event error log the error out to the console
     */
    editAddress(id) {
      // send request to the server, to get the data
      axios({ method: "GET", url: `api/address/${id}` }).then(
        (response) => {
          response = response.data;
          // update the new data
          this.full_name = response["full_name"];
          this.address_line_1 = response["address_line_1"];
          if (response["address_line_2"])
            this.address_line_2 = response["address_line_2"];
          this.city = response["city"];
          this.province = response["province"];
          this.other_address = response["other_address"];
          this.postal_code = response["postal_code"];
          this.customer_phone = response["customer_phone"];
          this.isEdit = true;
          this.editId = id;
        },
        (error) => {
          console.error(error);
        }
      );
    },
    /**
     * This function responsilbe for updating the new address.
     * @param array response response from the database
     * @param string error error response
     * @event success reset the form, ppresent new data
     * @event error log the error out to the console
     */
    updateAddress() {
      this.validForm();
      if (this.allFormValidate == true) {
        axios({
          // send request to the api
          method: "PUT",
          url: `api/address/${this.editId}`,
          data: {
            full_name: this.full_name,
            address_line_1: this.address_line_1,
            address_line_2: this.address_line_2,
            city: this.city,
            province: this.province,
            other_address: this.other_address,
            postal_code: this.postal_code,
            customer_phone: this.customer_phone,
          },
        }).then(
          (response) => {
            // reset the form back the create form, present new data
            this.full_name = "";
            this.address_line_1 = "";
            this.address_line_2 = "";
            this.city = "";
            this.province = "";
            this.other_address = "";
            this.postal_code = "";
            this.customer_phone = "";
            this.editId = "";
            this.isEdit = false;
            this.getAddress();
          },
          (error) => {
            console.error(error);
          }
        );
      }
    },
     /**
     * This function responsilbe for deleting the address which user select
     * @param array response response from the database
     * @param string error error response
     * @event success delete success
     * @event error log the error out to the console
     */
    deleteAddress(id) {
      axios({
        // send delete request
        method: "DELETE",
        url: `api/address/${id}`,
      }).then(
        (response) => {
          // update the new data
          this.getAddress();
        },
        (error) => {
          console.error(error);
        }
      );
    },
     /**
     * This function responsilbe for redirecting user to the check out page.
     * @event success redirect to the other page
     */
    checkOut(id) {
      window.open(`./checkout/${id}`, "_blank");
    },
     /**
     * This function responsilbe for validating the user input's form.
     * @var string numbers regex of number
     * @var string letter regex of letter
     */
    validForm() {
      
      if (this.address_line_1 === null) {
        this.addressLine1Validate = true;
      } else {
        this.addressLine1Validate = false;
      }

      if (this.city === null) {
        this.cityValidate = true;
      } else {
        this.cityValidate = false;
      }

      if (this.province === null) {
        this.ProvinceValidate = true;
      } else {
        this.ProvinceValidate = false;
      }

      if (this.postal_code === null) {
        this.Postalcodevalidate = true;
      } else {
        this.Postalcodevalidate = false;
      }
      var numbers = /^\d+$/;
      if (this.customer_phone === null) {
        this.telephonevalidate = true;
      } else {
        this.telephonevalidate = false;
      }

      var letters = /^[A-Za-z]+$/;
      if (this.full_name === null) {
        this.nameValidate = true;
      } else {
        this.nameValidate = false;
      }
      if (
        this.nameValidate == false &&
        this.telephonevalidate == false &&
        this.Postalcodevalidate == false &&
        this.ProvinceValidate == false &&
        this.cityValidate == false &&
        this.addressLine1Validate == false
      ) {
        this.allFormValidate = true;
      }
    },
    /**
     * This function responsilbe for creating the new address.
     * @var string numbers regex of number
     * @var string letter regex of letter
     * @event success update the new data to main screen
     */
    createAddress() {
      // validate the form first
      this.validForm();
      if (this.allFormValidate == true) {
        //send request to the api
        axios({
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          url: `api/address`,
          data: {
            full_name: this.full_name,
            address_line_1: this.address_line_1,
            address_line_2: this.address_line_2,
            city: this.city,
            province: this.province,
            other_address: this.other_address,
            postal_code: this.postal_code,
            customer_phone: this.customer_phone,
          },
        }).then((result) => {
          // present the new data to the main screen
          this.getAddress();
        });
      }
    },
  },
};
</script>