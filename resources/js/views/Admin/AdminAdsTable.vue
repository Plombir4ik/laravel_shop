<template>
    <div class="container" style="min-height: 100vh">
        <br/>
        <div class="row">
            <div class="col-10 mx-auto">
                <input
                    class="form-control search"
                    type="search"
                    v-model="search"
                    placeholder="Пошук..."
                    autofocus
                />
                <button
                    @click="$router.push({ name: 'AdminAddAd' })"
                    class="ml-4 add-button"
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
                    Додати
                </button>
            </div>
        </div>
        <br/>
        <br/>
        <div class="container">
            <table class="table table-striped">
                <thead>
                <th scope="col">id</th>
                <th scope="col">Товар</th>
                <th scope="col">Фотографія</th>
                </thead>
                <tbody>
                <tr v-for="ad in ads" :key="ad.id">
                    <td>
                        {{ ad.id }}
                    </td>

                    <td>
<!--                        {{ad.product.id}}-->
                        <table class="table table-striped">
                            <thead>
                            <th scope="col">Назва</th>
                            <th scope="col">Бренд</th>
                            <th scope="col text-right">Фото</th>
                            <th scope="col text-right">Ціна</th>
                            <th scope="col text-right">Кількість</th>
                            </thead>
                            <tbody>
                            <tr>
                                <td style="width: 200px">
                                    {{ ad.product.name }}
                                </td>
                                <td>
                                    {{ ad.product.brand }}
                                </td>
                                <td>
                                    <img
                                        :src="ad.product.img"
                                        class="image product-img"
                                        alt="img"
                                        width="75"
                                        height="100"
                                        style="object-fit: contain"
                                    />
                                </td>
                                <td>
                                    {{ ad.product.price }}
                                </td>
                                <td>
                                    {{ ad.product.count }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <br/>
                        <img
                            :src="ad.img"
                            class="image product-img"
                            alt="img"
                            width="387"
                            height="168"
                            style="object-fit: contain"
                        />
                    </td>
                    <td>
                        <router-link :to="'/admin/ads/edit/' + ad.id" class="btn btn-info">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="currentColor"
                                class="bi bi-pen-fill"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"
                                />
                            </svg>
                        </router-link>
                    </td>
                    <td>
                        <a
                            @click="deleteAd(ad.id)"
                            class="btn btn-danger"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="currentColor"
                                class="bi bi-trash-fill"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"
                                />
                            </svg>
                        </a>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            ads: [],
            search: "",
        };
    },

    async created() {
        try {
            const res = await axios.get(
                "/api/ads"
            );
            this.ads = res.data;
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
        deleteAd(ad_id) {
            axios.delete("/api/admin/ads/" + ad_id);
            axios.get(
                "/api/ads"
            ).then((res) => this.ads = res.data);
        }
    },

    // computed: {
    //     filterList() {
    //         return this.ads.filter((post) => {
    //             return (
    //                 post.name.toLowerCase().includes(this.search.toLowerCase()) ||
    //                 post.value.toLowerCase().includes(this.search.toLowerCase())
    //             );
    //         });
    //     },
    // },
};
</script>

<style>
.search {
    width: 70% !important;
}

body {
    font-family: "Raleway", sans-serif;
    font-size: 16px;
    font-weight: 300;
}

.main-title {
    font-weight: 500;
}

.trashIconContainer {
    vertical-align: middle !important;
    padding-top: 10px;
    text-align: center;
}

.trashIconContainer i {
    color: #e74c3c;
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
</style>
