<template>
    <div class="container mt-4 add-container">
        <div class="col-md-6 col-10 mx-auto">
            <h2 class="reg-title">Додати рекламу</h2>
            <form class="mb-5" @submit.prevent="addAd" novalidate>
                <div v-if="regMessage" class="alert alert-success" role="alert">
                    Ви успішно додали товар!
                </div>

                <div class="form-group">
                    <label for="productId">Id Товару</label>

                    <input
                        @blur="$v.formReg.productId.$touch()"
                        :class="status($v.formReg.productId)"
                        v-model.trim="formReg.productId"
                        type="text"
                        class="form-control"
                        id="productId"
                        name="productId"
                    />

                    <div class="invalid-feedback" v-if="!$v.formReg.productId.required">
                        {{ reqText }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="image">Фотографія</label>

                    <input
                        @blur="$v.formReg.image.$touch()"
                        :class="status($v.formReg.image)"
                        v-model.trim="formReg.image"
                        type="text"
                        class="form-control"
                        id="image"
                        name="image"
                        @change="GetImage"
                    />

                    <div class="invalid-feedback" v-if="!$v.formReg.image.required">
                        {{ reqText }}
                    </div>

                    <div class="invalid-feedback" v-if="!$v.formReg.image.url">
                        {{ reqUrl }}
                    </div>
                    <br />
                    <div>
                        <div class="card card-image">
                            <img class="card-img-top" :src="formReg.image" />
                        </div>
                    </div>
                </div>

                <button
                    type="button"
                    class="button button-back mb-3 mr-2"
                    @click="$router.go(-1)"
                >
                    Назад
                </button>
                <button :disabled="disabledBtn" type="submit" class="button mb-3 ml-2">
                    Додати
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import { required, helpers, url } from "vuelidate/lib/validators";
const alpha = helpers.regex("alpha", /^[0-9]*$/);
import axios from "axios";
export default {
    data() {
        return {
            regMessage: false,
            reqText: "Поле обов'язкове для заповнення",
            alphaText: "Заборонені будь-які символи, крім цифр",
            reqUrl: "Вставте посилання",
            formReg: {
                productId: null,
                image: "",
            },
            avatar: null,
            specs: [],
        };
    },

    // async created() {
    //     try {
    //         const res = await axios.get(
    //             "/api/specs/" + this.$route.params.cat
    //         );
    //         this.specs = res.data;
    //     } catch (e) {
    //         console.error(e);
    //     }
    // },

    mounted() {
        if (localStorage.getItem("token") == null) {
            this.$router.back();
        }
    },

    computed: {
        disabledBtn() {
            return (
                this.$v.formReg.image.$invalid ||
                this.$v.formReg.productId.$invalid
            );
        },
    },

    methods: {
        GetImage(e) {
            let image = e.target.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(image);
            reader.onload = (e) => {
                this.avatar = e.target.result;
            };
        },
        status(validation) {
            return {
                "is-invalid": validation.$error,
                error: validation.$error,
            };
        },
        addAd() {
            axios.post("/api/admin/ads", {
                img: this.formReg.image,
                product_id: this.formReg.productId,
            }).then((res) =>
                this.$router.push({
                    name: "AdminAdsTable",
                })
            )
        },

        reset() {
            this.regMessage = true;
            setTimeout(() => {
                this.regMessage = false;
            }, 3000);
            for (let input in this.formReg) {
                this.formReg[input] = "";
            }
            this.$v.$reset();
        },
    },
    validations: {
        formReg: {
            productId: {
                required,
                //        alpha,
            },
            image: {
                required,
                url,
            },
        },
    },
};
</script>

<style scoped>
.add-container {
    min-height: 100vh;
}
.card-image {
    border: 0px;
}
.button-back {
    background-color: rgb(238, 238, 238);
    color: rgb(143, 143, 143);
}
.button-back:hover {
    background-color: rgb(228, 228, 228);
}
.button {
    margin: 0;
    display: unset;
    width: auto;
    padding: 8px 20px;
}
form {
    background-color: white;
    padding: 20px;
    border: 1px solid rgba(206, 206, 206, 0.678);
    box-shadow: 10px 10px 45px -31px rgba(0, 0, 0, 0.75);
}
.error {
    background-color: #fdd;
}
.reg-title {
    color: #5d5d5d;
    font-size: 24px;
    margin-bottom: 18px;
    padding-left: 20px;
}
.slide-fade-enter-active {
    transition: all 0.3s ease;
}
.slide-fade-enter {
    transform: translateX(10px);
    opacity: 0;
}

.img {
    width: 100px;
    height: 20px;
}
</style>
