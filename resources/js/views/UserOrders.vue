<template>
    <div class="user-orders">
        <div class="container">
            <div v-if="displayOrders == 1"></div>
            <div class="text-center empty" v-if="displayOrders == 2">
                <h2>У вас ще немає замовлень</h2>
                <img class="mt-2 empty-order mr-4" src="../assets/empty-cart.svg"/>
                <router-link to="/categories" class="mt-3 button start"
                >Почати покупки
                </router-link
                >
            </div>
        </div>
        <div class="container mb-5" v-if="displayOrders == 3">
            <h3 class="mt-5 text-center">Мої замовлення</h3>
            <div class="row">
                <div class="col-12">
                    <div
                        class="card product-card my-3 p-5"
                        v-for="order of orders"
                        :key="order.id"
                    >
                        <div class="row">
                            <div class="col my-auto col-md-3 col-6 text-center">
                                <p class="parameter">Замовлення</p>
                                <p class="value">№{{ order.id }}</p>
                            </div>
                            <div class="col my-auto col-md-3 col-6 text-center">
                                <p class="parameter">Дата</p>
                                <p class="value">{{ order.date }}</p>
                            </div>
                            <div class="col my-auto col-md-3 col-6 text-center">
                                <p class="parameter">Сума замовлення</p>
                                <p class="value">{{ order.total }} грн</p>
                            </div>
                            <div class="col my-auto col-md-3 col-6 text-center">
                                <p class="parameter">Статус замовлення</p>
                                <p
                                    class="value"
                                    style="color: rgb(226, 155, 0)"
                                    v-if="order.status == 1"
                                >
                                    В обробці
                                </p>
                                <p class="value text-success" v-else>Завершено</p>
                            </div>
                        </div>
                        <div v-for="product of order.products">
                            <hr/>
                            <div class="row mt-3">
                                <div class="col my-auto col-md-4 col-7 text-center">
                                    <img class="image img-prod" :src="product.img" alt="product"/>
                                </div>
                                <div class="col my-auto col-md-3 col-5 text-left">
                                    <router-link
                                        :to="'products/' + product.id"
                                        class="text-dark"
                                    >
                                        <p class="name">{{ product.name }}</p>
                                    </router-link>
                                </div>
                                <div class="col my-auto col-md-2 col-7 text-center">
                                    <p class="parameter">Кількість</p>
                                    <p class="value">{{ product.user_count }}</p>
                                </div>
                                <div class="col my-auto col-md-3 col-5 text-center">
                                    <p class="parameter">Ціна</p>
                                    <p class="value">{{ product.price }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            orders: [],
            displayOrders: 1,
        };
    },
    mounted() {
        if (localStorage.getItem("token") == null) {
            this.$router.back();
        }

        axios
            .get("/api/orders/handled")
            .then((response) => {
                this.orders = response.data;
                if (this.orders.length != 0) {
                    this.displayOrders = 3;
                } else {
                    this.displayOrders = 2;
                }
            });
    },
};
</script>

<style scoped>
.img-prod {
    object-fit: contain;
    height: 130px;
    width: auto;
}

.start {
    width: 30% !important;
}

.empty {
    margin-top: 20vh;
}

.empty-order {
    max-height: 20vh;
}

p {
    margin: 0;
}

.user-orders {
    min-height: 100vh;
}

.name {
    font-size: 18px;
}

.value {
    font-size: 18px;
}

.card {
    border-radius: 10px;
}

.parameter {
    font-size: 75%;
}

.product-card {
    margin-inline: 10px;
    padding: 20px 40px;
    box-shadow: 5px 5px 10px 0px #e0e0e0;
}

.button {
    width: 70%;
    margin: auto;
}

@media (max-width: 768px) {
    .name {
        font-size: 14px;
    }

    .value {
        font-size: 15px;
    }
}
</style>
