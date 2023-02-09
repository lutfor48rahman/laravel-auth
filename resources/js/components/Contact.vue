<template>
    <div>
        <h1>Contact page</h1>
    </div>
</template>

<script>
export default {
    name: 'InventoryVueContact',
    created(){
        if(!User.loggedIn()){
            this.$router.push({name:'/'})
        }
    },
    data() {
        return {
            
        };
    },

    mounted() {
        
    },

    methods: {
        
    },
};
</script>

<style scoped>

</style>