<template>
    <div>
        <h2 class="mt-4 text-center">Категорії</h2>
        <div
            class="container mb-4"
            style="margin-left: 150px auto; max-width: 960px; min-height: 100vh"
        >
            <div class="d-flex">
                <button
                    type="button"
                    class="add-button"
                    @click="$router.push({ name: 'Adminaddcategory' })"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="18"
                        height="18"
                        fill="currentColor"
                        class="bi bi-plus-circle-fill"
                        viewBox="0 0 16 19"
                    >
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"
                        />
                    </svg>
                    Додати категорію
                </button>

                <button
                    type="button"
                    class="sold-button ml-2"
                    @click="$router.push({ name: 'AdminAdsTable' })"
                >
                    Карусель
                </button>

                <button
                    type="button"
                    class="sold-button ml-2"
                    @click="$router.push({ name: 'Adminsolditems' })"
                >
                    Замовлені товари
                </button>
            </div>
            <div class="row" v-for="category in categories" v-bind:key="category.id">
                <div class="col-md-6 col-12 mt-4">
                    <div class="category mx-3">
                        <img :src="category.img" class="image category-img" alt="category"/>
                        <div
                            class="category-name d-flex justify-content-center align-items-center"
                        >
                            <h5>{{ category.name }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12 mt-md-4 text-center">
                    <div v-for="subcategory in category.subcategories" v-bind:key="subcategory.id">
                        <div>
                            <div class="d-flex justify-content-center link">
                                <router-link
                                    :to="'/admin/categories/' + subcategory.id"
                                    class="mt-1 text-muted"
                                >
                                    {{ subcategory.name }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <router-link
                        :to="'/admin/addsubcategory/' + category.id"
                        type="button"
                        class="add-button mt-1"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="18"
                            fill="currentColor"
                            class="bi bi-plus-circle-fill"
                            viewBox="0 0 16 19"
                        >
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"
                            />
                        </svg>
                        Додати підкатегорію
                    </router-link>
                    <div class="d-flex justify-content-center link">
                        <button
                            @click="deleteCategory(category.id)"
                            class="add-button mt-1"
                            style="background: #dc3545"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="18"
                                height="18"
                                fill="currentColor"
                                class="bi bi-x-circle-fill"
                                viewBox="0 0 16 19"
                            >
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"
                                />
                            </svg>
                            Видалити категорію
                        </button>
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
            categories: [],
        };
    },
    async created() {
        try {
            const res = await axios.get("/api/admin/categories");
            this.categories = res.data;
        } catch (e) {
            console.error(e);
        }
    },

    mounted() {
        if (localStorage.getItem("token") == null) {
            this.$router.back();
        }
    },

    methods: {
        deleteCategory(cat_id) {
            axios.delete("/api/admin/categories/" + cat_id);
            axios.get("/api/categories").then((res) => this.categories = res.data);
            // this.category = res.data;
        },
    },
};
</script>

<style scoped>
.category {
    pointer-events: none;
}

.category-img {
    margin-bottom: -150px;
    height: 210px;
}

.add-button {
    background-color: #4da9bdff;
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

.add-button:hover {
    background-color: rgb(46, 136, 156);
    color: white !important;
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

@media (max-width: 767px) {
    .link {
        margin-top: 10px;
    }
}
</style>
