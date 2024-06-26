<template>
    <div>
    <b-overlay :show="show" no-wrap>
    </b-overlay>
    <div class="wrapper mt-5">
        <div class="container">
            <div class="col-sm-4 mx-auto">

                <h2 class="reg-title">Реєстрація</h2>

                <form @submit.prevent="registerUser()">
                    <div v-if="regMessage" class="alert alert-success" role="alert">
                        Ви успішно зареєструвались!
                    </div>

                    <div class="form-group">
                        <label for="name">Ваше імя</label>

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
                        <div class="invalid-feedback" v-if="!$v.formReg.name.alpha">
                            {{ alphaText }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="surname">Ваше прізвище</label>

                        <input
                            @blur="$v.formReg.surname.$touch()"
                            :class="status($v.formReg.surname)"
                            v-model.trim="formReg.surname"
                            type="text"
                            class="form-control"
                            id="surname"
                            name="surname"
                        />

                        <div class="invalid-feedback" v-if="!$v.formReg.surname.required">
                            {{ reqText }}
                        </div>
                        <div class="invalid-feedback" v-if="!$v.formReg.surname.alpha">
                            {{ alphaText }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone">Телефон</label>

                        <the-mask
                            mask="+38(0##)###-##-##"
                            @blur="$v.formReg.phone.$touch()"
                            :class="status($v.formReg.phone)"
                            v-model.trim="formReg.phone"
                            type="text"
                            class="form-control"
                            id="phone"
                            masked="true"
                            name="phone"
                        >
                        </the-mask>

                        <div class="invalid-feedback" v-if="!$v.formReg.phone.required">
                            {{ reqText }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>

                        <input
                            @blur="$v.formReg.email.$touch()"
                            :class="status($v.formReg.email)"
                            v-model.trim="formReg.email"
                            type="text"
                            class="form-control"
                            id="email"
                            name="email"
                        />

                        <div class="invalid-feedback" v-if="!$v.formReg.email.required">
                            {{ reqText }}
                        </div>
                        <div class="invalid-feedback" v-if="!$v.formReg.email.email">
                            Будь ласка введіть ваш Email
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Пароль</label>

                        <input
                            @blur="$v.formReg.password.$touch()"
                            :class="status($v.formReg.password)"
                            v-model.trim="formReg.password"
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                        />

                        <div class="invalid-feedback" v-if="!$v.formReg.password.required">
                            {{ reqText }}
                        </div>
                        <div class="invalid-feedback" v-if="!$v.formReg.password.minLength">
                            {{ minLengthText }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="passwordConfirm">Підтвердження пароля</label>

                        <input
                            @blur="$v.formReg.passwordConfirm.$touch()"
                            :class="status($v.formReg.passwordConfirm)"
                            v-model.trim="formReg.passwordConfirm"
                            type="password"
                            class="form-control"
                            id="passwordConfirm"
                        />

                        <div
                            class="invalid-feedback"
                            v-if="!$v.formReg.passwordConfirm.sameAs"
                        >
                            {{ passwordConfirmText }}
                        </div>
                    </div>

                    <div class="invalid-feedback message mb-3">
                        {{ message }}
                    </div>

                    <button
                        type="button"
                        class="btn btn-light mr-2"
                        @click="$router.push({ name: 'Login' })"
                    >
                        Назад
                    </button>
                    <button :disabled="disabledBtn" type="submit" class="btn btn-primary">
                        Зареєструватись
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
import {TheMask} from "vue-the-mask";
import axios from "axios";
import {
    email,
    required,
    minLength,
    helpers,
    sameAs,
} from "vuelidate/lib/validators";

const alpha = helpers.regex("alpha", /^[a-zA-Zа-яёА-А-ЯҐЄІЇ-яґєії]*$/);

export default {
    data() {
        return {
            show: false,
            regMessage: false,
            reqText: "Поле обовязкове для заповнення",
            alphaText: "Заборонені пробіли а також інші символи",
            minLengthText: "Мінімальна довжина 8 символів!",
            passwordConfirmText: "Паролі не співпадають",
            formReg: {
                email: "",
                phone: "",
                name: "",
                surname: "",
                password: "",
                passwordConfirm: "",
            },
            message: null,
        };
    },

    components: {TheMask},

    mounted() {
        if (localStorage.getItem("token") != null) {
            this.$router.back();
        }
    },

    computed: {
        disabledBtn() {
            return (
                this.$v.formReg.name.$invalid ||
                this.$v.formReg.surname.$invalid ||
                this.$v.formReg.email.$invalid
            );
        },
    },

    methods: {
        status(validation) {
            return {
                "is-invalid": validation.$error,
                error: validation.$error,
            };
        },
        userRegister() {
            console.group();
            console.log("Ви зареєстурвались!");
            console.log("Ваше імя: " + this.formReg.name);
            console.log("Ваша прізвище: " + this.formReg.surname);
            console.log("Email: " + this.formReg.email);
            console.log("Телефон: " + this.formReg.phone);
            console.log("Пароль: " + this.formReg.password);
            console.groupEnd();
            this.reset();
        },

        registerUser() {
            this.show = true;
            var _this = this;
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post("/register", {
                        name: this.formReg.name,
                        surname: this.formReg.surname,
                        email: this.formReg.email,
                        phone: this.formReg.phone,
                        password: this.formReg.password,
                    })
                    .then((response) => {
                        if (response.status >= 200 && response.status < 300) {
                            localStorage.token = response.config.headers['X-XSRF-TOKEN'];
                            this.$router.push({name: "Main"}).then(() => {
                                window.location.reload();
                            });
                        }
                    })
                    .catch(function (error) {
                        if (error.response) {
                            _this.message = error.response.data.message;
                        }
                    }).finally(() => {this.show = false});
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
            email: {
                email,
                required,
            },
            phone: {
                required,
                minLength: minLength(13),
            },
            name: {
                required,
                alpha,
            },
            surname: {
                required,
                alpha,
            },
            password: {
                required,
                minLength: minLength(8),
            },
            passwordConfirm: {
                sameAs: sameAs("password"),
            },
        },
    },
};
</script>

<style scoped>
form {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 10px 10px 45px -31px rgba(0, 0, 0, 0.75);
}

.message {
    display: block !important;
}

.error {
    background-color: #fdd;
}

.reg-title {
    color: #5d5d5d;
    font-size: 24px;
    margin-bottom: 18px;
}

.slide-fade-enter-active {
    transition: all 0.3s ease;
}

.slide-fade-enter {
    transform: translateX(10px);
    opacity: 0;
}
</style>
