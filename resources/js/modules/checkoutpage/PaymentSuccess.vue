<template>
  <div id="paymentsuccess">
      <h1 class="text-center">Your order have been submitted. Please wait a moment!</h1>
      <h1 class="text-center">Thank you for using our services. Enjoy your food!</h1>
      <a class="center btn" href="./">Back to homepage</a>
  </div>
</template>

<script>
//this class manage the payment process
import Vue from "vue";
export default {
  name: "PaymentSuccess",
  
};
</script>
<style scoped>
.center{
  margin-left: 40%;
}
.btn {
  text-align: center;
  margin-top: 2.5%;
  background-color: #8BD3E6;
  width: 10%;
  height: 5%;
  border: 1px solid #8BD3E6;
}
</style>