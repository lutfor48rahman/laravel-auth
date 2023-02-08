<template>
  <div></div>
</template>

<script>
export default {
  name: "InventoryVueLogout",

  created() {
    User.logout();
    Toast.fire({
      type: "success",
      title: "successfully logout!!",
    });
    this.$router.push({name:'/'})
  },
};
</script>

<style scoped>
</style>