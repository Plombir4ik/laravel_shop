<template>
    <div style="padding-bottom: 100px; margin-top: 0">
        <template>
            <div
                :style="{ width: '70%', marginLeft: 'auto', marginRight: 'auto', boxShadow: 'rgba(0, 0, 0, 0.35) 0px 5px 15px'}">
                <b-carousel
                    id="carousel-1"
                    v-model="slide"
                    :interval="4000"
                    controls
                    background="#ababab"
                    style="text-shadow: 1px 1px 2px #333;"
                    @sliding-start="onSlideStart"
                    @sliding-end="onSlideEnd"
                >
                    <router-link :to="'/products/' + adver.product.id" v-for="adver of advertisements" :key="adver.id">
                        <b-carousel-slide role="button" :img-src="adver.img"></b-carousel-slide>
                    </router-link>
                </b-carousel>
            </div>
        </template>
        <div class="search-block col-5 mt-5 mx-auto">
            <b-form-input
                class="form-control"
                @update="goSearch($event)"
                placeholder="Пошук товарів..."
                v-model="search"
                autofocus
            />
        </div>
        <div class="container">
            <div class="row mt-4 row-products">
                <span v-for="product in found_products" :key="product" class="all-products">
                  <column
                    class="col-lg-3 col-md-4 col-sm-6 col-6 product"
                    v-if="display"
                    >
                    <router-link class="text-dark text center" :to="'/products/' + product.id">
                        <img :src="product.img" class="image img-prod"/>
                        <p class="mt-2 products">
                            <b>{{ product.name }}</b>
                        </p>
                        <p class="mt-1 products">{{ product.price }} грн</p>
                    </router-link>
                  </column>
                </span>
            </div>
        </div>
        <div class="container" v-if="loading && found_products.length == 0">
            <div class="row mt-4 row-products">
                <span class="all-products">
                  <column
                      class="col-lg-3 col-md-4 col-sm-6 col-6 product"
                  >
                    <b-skeleton-img class="text-dark text center" height="260px" width="227px"></b-skeleton-img>
                  </column>
                </span>
            </div>
        </div>
        <div v-if="found_products.length == 0 && display == true" class="text-center mt-5">
            За вашим запитом товарів не знайдено
        </div>
        <div v-if="display == false">
            <div class="category-1 text-center" v-for="item of items" :key="item">
                <router-link :to="'/categories/' + item.category_id + '/' + item.id">
                    <h4
                        class="text-dark title"
                        v-if="item.products.length != 0"
                        style="display: inline-block"
                    >
                        <b>{{ item.name }}</b>
                    </h4>
                </router-link>
                <div class="container" v-if="item.products.length != 0">
                    <div class="row mt-4 row-products">
                        <column
                            class="col-lg-3 col-md-4 col-sm-6 col-6 product"
                            v-for="product of item.products"
                            :key="product"
                        >
                            <router-link class="text-dark" :to="'/products/' + product.id">
                                <img :src="product.img" class="image img-prod"/>
                                <p class="mt-2 products">
                                    <b>{{ product.name }}</b>
                                </p>
                                <p class="mt-1 products">{{ product.price }} грн</p>
                            </router-link>
                        </column>
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
            all_items: null,
            items: null,
            search: "",
            found_products: [],
            display: false,
            loading: false,
            advertisements : []
        };
    },
    mounted() {
        axios.get("/api/products").then((response) => {
            this.items = response.data;
        });
        axios.get("/api/ads").then((response) => {
            this.advertisements = response.data;
        });
    },
    methods: {
        goSearch(event) {
            this.display = event == '' ? false : true;
            this.loading = true;
            axios.get("/api/products/search/" + event).then((response) => {
                this.found_products = response.data;
                // this.found_products.length
            }).finally(() => this.loading = false);
        },
    },
    computed: {
        filterList() {
            //     axios.get("/api/products/search/ace").then((response) => {
            //         this.found_products = response.data;
            //     });
            return this.found_products
        },
    },
}
</script>

<style>
body {
    min-height: 100vh;
}

.wrapper {
    min-height: 100vh;
}

.back {
    width: 100%;
    position: relative;
}

.img-prod {
    margin: auto;
    object-fit: cover;
    width: 100%;
}

.products {
    font-size: medium;
    margin: 0;
}

.all-products {
    display: contents;
}

.row-products {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}

.product {
    height: 100%;
    margin-top: 20px;
    transition: transform 0.2s;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    min-height: 280px;
}

.product:hover {
    background: white;
    filter: brightness(90%);
    transform: scale(1.05);
}

b-row {
    align-items: center;
}

.main-page {
    width: 100%;
    display: flex;
    flex-direction: column;
}

.main-container {
    position: absolute;
    width: 100%;
}

.button {
    background-color: #4da9bdff;
    border: none;
    margin-left: 20%;
    margin-top: 12%;
    width: 35vh;
    border-radius: 50px;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: block;
    font-size: 16px;
}

.button:hover {
    background-color: rgb(46, 136, 156);
    color: white !important;
    text-decoration: none;
}

.category-1,
.category-2 {
    margin: auto;
    margin-top: 20px;
    width: 70%;
    position: relative;
}

.title {
    text-align: center;
    position: relative;
    line-height: 60px;
}

.title::after {
    content: "";
    background: #4da9bdff;
    padding: 5px 80px;
    border-radius: 5px;
    position: absolute;
    left: 50%;
    bottom: 0;
    transform: translateX(-50%);
}

@media (max-width: 768px) {
    .button {
        margin: 0 auto;
        width: 25vh;
        padding: 7px 20px;
    }

    .main-container {
        position: relative;
    }

    p {
        font-size: small;
    }
}
</style>
