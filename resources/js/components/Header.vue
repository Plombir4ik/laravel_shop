<template>
    <header class="p-3" style="margin-bottom: 40px">
        <b-navbar collapseOnSelect expand="lg" toggleable="lg" bg="white">
            <b-container>
                <router-link to="/">
                    <b-navbar-brand>
                        <img src="../assets/logo.svg" width="30" class="d-inline-block align-top" alt="logo"/>
                        SHOP4YOU
                    </b-navbar-brand>
                </router-link>
                <b-navbar-toggle target="navbar-toggle-collapse" bg="white"/>
                <b-collapse id="navbar-toggle-collapse" is-nav>
                    <b-navbar-nav class="ml-auto">
                        <router-link class="mx-3 text-muted" to="/categories">
                            Каталог
                        </router-link>
                        <router-link class="mx-3 text-muted" to="/contacts">
                            Контакти
                        </router-link>
                        <router-link v-if="admin" class="mx-3 text-muted" to="/admin/categories">
                            Адмін-панель
                        </router-link>
                        <router-link v-if="!displayLogin" to="/user-orders" class="mx-3 text-muted">
                            Мої замовлення
                        </router-link>
                        <div>
                            <router-link v-if="displayLogin == false" class="mx-3 text-muted" to="/cart">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cart icon" viewBox="0 0 18 21">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                </svg>
                                <span class="badge">
                                    {{ count }}
                                </span>
                            </router-link>
                        </div>
                        <div v-if="!displayLogin">
                            <span class="profile-button ml-1" :style="{color: verified ? 'rgb(143, 143, 143)' : 'red'}" id="popover-target-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                </svg>
                                <span :class="{'ml-2':true, 'underline-text:': verified}" >
                                    {{ user.name + ' ' + user.surname }}
                                </span>
                            </span>
                            <b-popover v-if="!this.verified" show target="popover-target-1" triggers="hover" variant="danger" placement="bottom">
                                <template #title>Підтвердіть email!</template>
                                Для <b>здійснення покупок</b> необхідно підтвердити <b>електронну адресу</b>,<br/> на яку вам було відправлено листа з <b>підтвердженням</b>.
                            </b-popover>
                            <button class="auth-button button-exit ml-2" @click="removeLocalStorage()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                </svg>
                            </button>
                        </div>
                        <router-link v-if="displayLogin" class="ml-3 auth-button" to="/login">
                            Вхід
                        </router-link>
                    </b-navbar-nav>
                </b-collapse>
            </b-container>
        </b-navbar>
    </header>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            tokens: [],
            displayLogin: true,
            user: null,
            admin: false,
            verified: false,
            count: 0,
        };
    },
    mounted() {
        axios
        .get("/api/orders/cart")
        .then((response) => {
            this.count = response.data.length;
        });
    },
    async created() {
        axios
        .get("/api/user")
        .then((response) => {
            this.displayLogin = false;
            this.user = response.data;
            if (response.data.role == 1) {
                this.admin = true;
            }
            if (response.data.email_verified_at != null) {
                this.verified = true;
            }
        })
        .catch((err) => {
            localStorage.removeItem("token");
            axios.post("/logout");
            this.displayLogin = true;
        });
    },
    methods: {
        removeLocalStorage() {
            localStorage.removeItem("token");
            axios.post("/logout");
            this.displayLogin = true;
            location.href = "/login";
        },
    },
};
</script>

<style>
@media (max-width: 992px) {
    a {
        margin-top: 10px;
    }

    .auth-button,
    .profile-button {
        margin-left: 0 !important;
        align-self: center;
    }

    .navbar {
        text-align: center;
    }
}

.badge {
    font-size: 9px;
    vertical-align: top;
    margin: 0;
    position: relative;
    margin-left: 18px;
    background-color: #4da9bdff;
    color: white;
}

header {
    background: #fff;
    box-shadow: 0px 0px 20px 0px #ccc;
}

.icon {
    position: absolute;
}

.button-exit {
    width: 30px !important;
}

.underline-text {
    position: relative;
    cursor: pointer;
}

.underline-text::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -3px;
    width: 100%;
    height: 1px;
    background-color: transparent;
    transition: background-color 0.3s ease;
}

.underline-text:hover::after {
    background-color: red;
}

.profile-button {
    background-color: rgb(238, 238, 238);
    //color: rgb(143, 143, 143);
    border: none;
    border-radius: 50px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 400;
    text-align: center;
    line-height: 2em;
    padding: 8px;
    width: fit-content;
    cursor: default;
}

/* .profile-button:hover {
background-color: rgb(228, 228, 228);
} */

.auth-button {
    background-color: #4da9bdff;
    border: none;
    border-radius: 50px;
    color: white;
    text-decoration: none;
    font-size: 14px;
    font-weight: 400;
    height: 30px;
    width: 100px;
    text-align: center;
    line-height: 2em;
}

.auth-button:hover {
    background-color: rgb(46, 136, 156);
    color: white !important;
}

.navbar {
    font-weight: 600;
}

.navbar-brand {
    font-weight: 600;
}

.navbar-nav {
    font-weight: 600;
    line-height: 2em;
}

.navbar-nav a:hover {
    color: black !important;
    text-decoration: none;
}
</style>
