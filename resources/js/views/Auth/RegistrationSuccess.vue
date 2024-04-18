<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center success">
                <img class="image success-img mt-5" src="../../assets/logo.svg"/>
                <h4 class="mt-2">Ви успішно зареєструвались!</h4>
                <h5 class="mt-2">
                    <router-link class="text-muted" to="/login">Увійти</router-link>
                </h5>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    mounted() {
        //const token = this.$route.params.token;
        const id = this.$route.params.id
        const hash = this.$route.params.hash
        axios.get(`/email/verify/${id}/${hash}`)
            .then((response) => {
                // localStorage.token = response.config.headers['X-XSRF-TOKEN'];
                this.$router.push({name: "Main"});
            })
            .catch(error => {

            });
    }
}
</script>

<style scoped>

.row {
    margin-left: 10px;
    margin-right: 10px;
}

.container {
    min-height: 100vh;
    max-width: 660px;
}

.success {
    padding: 0 0 40px;
    margin-top: 10vh;
    border-radius: 50px;
    border: 1px solid rgba(206, 206, 206, 0.678);
    box-shadow: 5px 5px 10px 0px #e0e0e0;
}

.success-img {
    width: 140px;
}
</style>
