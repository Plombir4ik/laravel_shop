<template>
    <div class="container mt-4 add-container mb-5">
        <div class="col-md-6 col-10 mx-auto">
            <h2 class="reg-title">Редагувати товар</h2>
            <form @submit.prevent="editItem()">
                <div v-if="regMessage" class="alert alert-success" role="alert">
                    Ви успішно додали товар!
                </div>

                <div class="form-group">
                    <label for="name">Назва товару</label>

                    <input
                        @blur="$v.formReg.name.$touch()"
                        :class="status($v.formReg.name)"
                        v-model.trim="formReg.name"
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                    />

                    <div class="invalid-feedback" v-if="!$v.formReg.name.required">
                        {{ reqText }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="brand">Бренд</label>

                    <input
                        @blur="$v.formReg.brand.$touch()"
                        :class="status($v.formReg.brand)"
                        v-model.trim="formReg.brand"
                        type="text"
                        class="form-control"
                        id="brand"
                        name="brand"
                    />

                    <div class="invalid-feedback" v-if="!$v.formReg.brand.required">
                        {{ reqText }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="desc">Опис</label>

                    <textarea
                        @blur="$v.formReg.desc.$touch()"
                        :class="status($v.formReg.desc)"
                        v-model.trim="formReg.desc"
                        type="text"
                        class="form-control"
                        id="desc"
                        name="description"
                    />

                    <div class="invalid-feedback" v-if="!$v.formReg.desc.required">
                        {{ reqText }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="surname">Ціна</label>

                    <input
                        @blur="$v.formReg.surname.$touch()"
                        :class="status($v.formReg.surname)"
                        v-model.trim="formReg.surname"
                        type="text"
                        class="form-control"
                        id="surname"
                        name="price"
                    />

                    <div class="invalid-feedback" v-if="!$v.formReg.surname.required">
                        {{ reqText }}
                    </div>
                    <div class="invalid-feedback" v-if="!$v.formReg.surname.alpha">
                        {{ alphaText }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="count">Кількість</label>

                    <input
                        @blur="$v.formReg.count.$touch()"
                        :class="status($v.formReg.count)"
                        v-model.trim="formReg.count"
                        type="text"
                        class="form-control"
                        id="count"
                        name="count"
                    />

                    <div class="invalid-feedback" v-if="!$v.formReg.count.required">
                        {{ reqText }}
                    </div>
                    <div class="invalid-feedback" v-if="!$v.formReg.count.alpha">
                        {{ alphaText }}
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
                    <div>
                        <div class="card card-image">
                            <img class="card-img-top" :src="formReg.image"/>
                        </div>
                    </div>
                </div>
                <br/>
                <h5>Специфікації</h5>
                <hr/>
                <div v-for="spec in oldSpecs" :key="spec.id">
                    <div class="form-group">
                        <label>{{ spec.name }}</label>

                        <b-form-input @update="updateSpec(spec.id, $event)" :value="currentSpecValue(spec.name)" type="text" class="form-control"/>
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
                    Підтвердити
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import {required, helpers, url} from "vuelidate/lib/validators";
import axios from "axios";

const alpha = helpers.regex("alpha", /^[0-9]*$/);

export default {
    data() {
        return {
            regMessage: false,
            reqText: "Поле обовязкове для заповнення",
            alphaText: "Заборонені любі символи крім цифр",
            reqUrl: "Потрібна силка",
            formReg: {
                name: null,
                brand: null,
                image: null,
                count: null,
                surname: null,
                desc: null,
            },
            productSpecs: [],
            oldSpecs: [],
            newSpecs: [],
        };
    },

    computed: {
        disabledBtn() {
            return (
                this.$v.formReg.image.$invalid ||
                this.$v.formReg.name.$invalid ||
                this.$v.formReg.surname.$invalid ||
                this.$v.formReg.count.$invalid ||
                this.$v.formReg.desc.$invalid ||
                this.$v.formReg.brand.$invalid
            );
        },
    },
    mounted() {
        if (localStorage.getItem("token") == null) {
            this.$router.back();
        }

        axios
            .get("/api/products/" + this.$route.params.product_id)
            .then((response) => {
                // this.categoryId = response.data.subcategory_id;
                this.productSpecs = response.data.specs;
                this.formReg.name = response.data.name;
                this.formReg.brand = response.data.brand;
                this.formReg.surname = response.data.price;
                this.formReg.count = response.data.count;
                this.formReg.desc = response.data.description;
                this.formReg.image = response.data.img;
                axios
                    .get("/api/specs/" + response.data.subcategory_id).then(
                    (res) => {
                        this.oldSpecs = res.data;
                        res.data.forEach((spec) =>
                            this.newSpecs.push({id: spec.id, value: this.currentSpecValue(spec.name)})
                        )}
                );
            })



    },
    methods: {
        currentSpecValue(name) {
            const foundItem = this.productSpecs.find(item => item.name === name);
            return foundItem ? foundItem.value : null;
        },
        updateSpec(id,value) {
            const currentSpec = this.newSpecs.find(spec => spec.id == id);
            currentSpec.value = value;
        },
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

        async editItem() {
            await axios.put("/api/products/" + this.$route.params.product_id, {
                image: this.formReg.image,
                price: this.formReg.surname,
                name: this.formReg.name,
                brand: this.formReg.brand,
                count: this.formReg.count,
                description: this.formReg.desc,
                specs: this.newSpecs
            });

            axios
                .get("/api/products/" + this.$route.params.product_id)
                .then((response) => {
                    this.$router.push({
                        path: `/admin/categories/` + response.data.subcategory_id,
                    });
                });
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
            name: {
                required,
                //        alpha,
            },
            surname: {
                required,
                alpha,
            },
            brand: {
                required,
                //alpha,
            },
            count: {
                required,
                alpha,
            },
            desc: {
                required,
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
