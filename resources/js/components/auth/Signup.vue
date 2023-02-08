<template>
    <div>
        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <div class="card-body">
                                        <form @submit.prevent="signup">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputName" type="text" placeholder="your full name" name='name' required v-model="form.name"/>
                                                <label for="inputName">Your name</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com" name="email" required v-model="form.email"/>
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPassword" type="password" placeholder="Create a password" name="password" required v-model="form.password"/>
                                                        <label for="inputPassword">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPasswordConfirm" type="password" placeholder="Confirm password" name="password_confirmation" required v-model="form.password_confirmation"/>
                                                        <label for="inputPasswordConfirm">Confirm Password</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                <button class="btn btn-primary btn-block" type="submit">Create Account</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small">
                                        <router-link to='/'>Already have an account</router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    </div>
</template>

<script>
export default {
    name: 'InventoryVueSignup',

    created(){
        if(User.loggedIn()){
            this.$router.push({name:'home'})
        }
    },
    data() {
        return {
            form:{
                name:null,
                email:null,
                password:null,
                password_confirmation:null,
            },
        errors:{},
        };
    },

    mounted() {
        
    },

    methods: {
        signup(){
            axios.post('/api/auth/signup',this.form)
            .then( res => {
                User.responseAfterLogin(res)
                Toast.fire({
                    type:'success',
                    title:'Registered successfully'
                })
                this.$router.push({name:'home'})
                })
            .catch(error => this.errors = error.response.data.errors)
        }
    },
};
</script>

<style scoped>

</style>