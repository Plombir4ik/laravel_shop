<template>
    <div
        class="container-fluid"
        style="min-height: 100vh"
    >
<!--        <div class="row align-items-center">-->
<!--            <div class="mx-auto col-4 d-flex">-->
<!--                <input-->
<!--                    class="form-control search-big my-auto"-->
<!--                    type="search"-->
<!--                    v-model="search"-->
<!--                    placeholder="Пошук..."-->
<!--                    autofocus-->
<!--                />-->
<!--                <a-->
<!--                    type="button"-->
<!--                    class="sold-button px-auto ml-2"-->
<!--                    @click="$router.push({ name: 'adminmain' })"-->
<!--                >-->
<!--                    Статистика-->
<!--                </a>-->
<!--            </div>-->
<!--        </div>-->
<!--        <br/>-->
<!--        <br/>-->
        <table class="table table-striped">
            <thead>
            <th scope="col">Покупець</th>
            <th scope="col text-right">Товари</th>

            <th scope="col text-right">Сума замовлення</th>
            <th scope="col">Статус</th>
            <th scope="col text-right">Область</th>
            <th scope="col text-right">Місто</th>
            <th scope="col text-right">Поштове відділеня</th>
            <th scope="col text-right">Дата</th>
            </thead>
            <tbody>
            <tr v-for="order in filterByTerm" :key="order.id">
                <td>
                    {{ order.user }}
                </td>
                <td>
                    <table class="table table-striped">
                        <thead>
                        <th scope="col">Назва</th>
                        <th scope="col">Бренд</th>
                        <th scope="col text-right">Ціна</th>
                        <th scope="col text-right">Кількість</th>
                        </thead>
                        <tbody>
                        <tr v-for="product in order.products" :key="product.id">
                            <td style="width: 200px">
                                {{ product.name }}
                            </td>
                            <td>
                                {{ product.brand }}
                            </td>
                            <td>
                                <img
                                    :src="product.img"
                                    class="image product-img"
                                    alt="img"
                                    width="75"
                                    height="100"
                                    style="object-fit: contain"
                                />
                            </td>
                            <td>
                                {{ product.price }}
                            </td>
                            <td>
                                {{ product.count }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
                <td>{{ order.total }}</td>
                <td>
                    <select
                        class="form-control"
                        v-if="order.status == 1"
                        @change="onChangeStatus($event, order.id)"
                        style="background: #ff9800; color: #fff"
                    >
                        <option value="1" selected>Замовлений</option>
                        <option value="2">Завершений</option>
                    </select>
                    <select
                        class="form-control"
                        v-else-if="order.status == 2"
                        @change="onChangeStatus($event, order.id)"
                        style="background: #4caf50; color: #fff"
                    >
                        <option value="1">Замовлений</option>
                        <option value="2" selected>Завершений</option>
                    </select>
                </td>
                <td>
                    {{ order.region }}
                </td>
                <td>
                    {{ order.city }}
                </td>

                <td>
                    {{ order.delivery_address }}
                </td>

                <td>
                    {{ order.date }}
                </td>
            </tr>
            </tbody>
            <tr>
                <br/>
                <td
                    colspan="5"
                    class="text-left"
                    style="color: black; font-size: 20px"
                >
                    Загальна сума
                </td>
                <td class="text-left" style="color: black; font-size: 20px">
                    {{ subtotal }} грн.
                </td>
            </tr>
        </table>
        <br/>
        <br/>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            product_subtotal: 0,
            products: [],
            search: "",
            income: null,
            count: null,
            date: null,
            incomeCat: null,
            orderCout: null,
            name1: null,
            orderCount: null,
        };
    },

    async created() {
        try {
            const res = await axios.get("/api/admin/solditems");
            this.products = res.data;
        } catch (e) {
            console.error(e);
        }
    },

    mounted() {
        if (localStorage.getItem("token") == null) {
            this.$router.back();
        }
    },

    computed: {
        filterByTerm() {
            return this.products.filter((product) => {
                return (
                    product.region.toLowerCase().includes(this.search.toLowerCase()) ||
                    product.city.toLowerCase().includes(this.search.toLowerCase()) ||
                    product.delivery_address
                        .toLowerCase()
                        .includes(this.search.toLowerCase()) ||
                    product.email.toLowerCase().includes(this.search.toLowerCase()) ||
                    product.name.toLowerCase().includes(this.search.toLowerCase())
                );
            });
        },

        subtotal: function () {
            return this.products.reduce((total, item) => {
                return total + item.total;
            }, 0);
        },
    },
    methods: {
        async onChangeStatus(event, order_id) {
            await axios.put("/api/admin/solditems/" + order_id, {
                status: event.target.value,
            });

            const res = await axios.get("/api/admin/solditems");
            this.products = res.data;
        },

    },
};
</script>

<style>
.search-big {
    width: 100% !important;
}

body {
    font-family: "Raleway", sans-serif;
    font-size: 16px;
    font-weight: 300;
}

.main-title {
    font-weight: 500;
}

.btn-success,
.panel-success {
    background-color: #27c24c !important;
    border-color: #27c24c !important;
    color: #fff !important;
}

.submit_btn {
    min-width: 150px;
    max-width: 250px;
    font-size: 1.2rem;
    height: 60px;
    margin-top: 20px;
    padding: 20px;
}

.submit_btn i {
    padding-right: 10px;
}

.sold-button {
    background-color: #00a0a0;
    color: white;
    border-radius: 50px;
    border: none;
    text-decoration: none;
    font-size: 16px;
    font-weight: 600;
    text-align: center;
    line-height: 2em;
    padding: 7px 20px;
    width: fit-content;
}

.sold-button:hover {
    background-color: #008585;
    color: white !important;
}

option {
    color: #000 !important;
    background: #fff;
}
</style>
