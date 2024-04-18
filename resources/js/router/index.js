import Vue from "vue";
import VueRouter from "vue-router";
import Main from "../views/Main.vue";
import Catalog from "../views/Catalog.vue";
import Contacts from "../views/Contacts.vue";
import Products from "../views/Products.vue";
import UserOrders from "../views/UserOrders.vue";
import Success from "../views/Success.vue";
import LoginForm from "../views/Auth/LoginForm.vue";
import Registration from "../views/Auth/RegistrationForm.vue";
import EmailSent from "../views/Auth/EmailSent.vue";
import RegistrationSuccess from "../views/Auth/RegistrationSuccess.vue";
import ProductDetails from "../views/ProductDetails.vue";
import ShoppingCart from "../views/ShoppingCart";
import Subcategories from "../views/Subcategories";
import ForgetPassword from "../views/Auth/ForgetPassword.vue";
import ResetPassword from "../views/Auth/ResetPassword.vue";
import ResetPasswordComplete from "../views/Auth/ResetPasswordComplete.vue";
import AdminTable from "../views/Admin/AdminTable.vue";
import AdminEditItem from "../views/Admin/AdminEditItem.vue";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Main",
    component: Main,
  },
    {
        path: "/contacts",
        name: "Contacts",
        component: Contacts,
    },
    {
        path: "/categories",
        name: "categories",
        component: Catalog,
    },
    {
        path: "/categories/:category_id",
        name: "subcategories",
        component: Subcategories,
    },

    {
        path: "/categories/:category_id/:subcategory_id",
        name: "Subcategories",
        component: Products,
    },
    {
        path: "/products/:product_id",
        name: "ProductDetails",
        component: ProductDetails,
    },
    {
        path: "/cart",
        name: "Cart",
        component: ShoppingCart,
    },
    {
        path: "/user-orders",
        name: "UserOrders",
        component: UserOrders,
    },
    {
        path: "/success",
        name: "Success",
        component: Success,
    },
    {
        path: "/login",
        name: "Login",
        component: LoginForm,
    },
    {
        path: "/registration",
        name: "Registration",
        component: Registration,
    },
    {
        path: "/email-sent",
        name: "EmailSent",
        component: EmailSent,
    },
    {
        path: "/email/verify/:id/:hash",
        name: "RegistrationSuccess",
        component: RegistrationSuccess,
    },
    {
        path: "/resetPassword",
        name: "ResetPassword",
        component: ResetPassword,
    },
    {
        path: "/resetPassword/:token",
        name: "ResetPassword",
        component: ResetPassword,
    },
    {
        path: "/reset-password-complete",
        name: "ResetPasswordComplete",
        component: ResetPasswordComplete,
    },
    {
        path: "/forgetPassword",
        name: "ForgetPassword",
        component: ForgetPassword,
    },
    {
        path: "/admin",
        name: "adminmain",
        component: require("../views/Admin/AdminMain.vue").default,
    },
    {
        path: "/admin/categories",
        name: "Admincategory",
        component: require("../views/Admin/AdminCategory.vue").default,
    },
    {
        path: "/admin/categories/:cat",
        name: "AdminTableOfSubCategory",
        component: AdminTable,
    },
    {
        path: "/admin/additem/:cat",
        name: "Adminadditem",
        component: require("../views/Admin/AdminAddItem.vue").default,
    },
    {
        path: "/admin/addcategory",
        name: "Adminaddcategory",
        component: require("../views/Admin/AdminAddCategory.vue").default,
    },
    {
        path: "/admin/addsubcategory/:cat",
        name: "Adminaddsubcategory",
        component: require("../views/Admin/AdminAddSubCategory.vue").default,
    },
    {
        path: "/admin/delete/:product_id",
        name: "AdminDelProd",
        component: AdminTable,
    },
    {
        path: "/admin/edit/:product_id",
        name: "AdminEditProd",
        component: AdminEditItem,
    },
    {
        path: "/admin/specs/add/:subcategory_id",
        name: "Adminaddspecs",
        component: require("../views/Admin/AdminAddSpec.vue").default,
    },
    {
        path: "/admin/specs/edit/:spec_id",
        name: "AdminEditSpec.vue",
        component: require("../views/Admin/AdminEditSpec.vue").default,
    },
    {
        path: "/admin/ads/add/",
        name: "AdminAddAd",
        component: require("../views/Admin/AdminAddAd.vue").default,
    },
    {
        path: "/admin/ads/edit/:ad_id",
        name: "AdminEditAd.vue",
        component: require("../views/Admin/AdminEditAd.vue").default,
    },
    {
        path: "/admin/soldItems",
        name: "Adminsolditems",
        component: require("../views/Admin/AdminSoldItems.vue").default,
    },
    {
        path: "/admin/specs/:subcategory_id",
        name: "AdminSpecsTable",
        component: require("../views/Admin/AdminSpecsTable.vue").default,
    },
    {
        path: "/admin/ads",
        name: "AdminAdsTable",
        component: require("../views/Admin/AdminAdsTable.vue").default,
    },
    {
        path: "/admin/specs/delete/:product_id",
        name: "AdminDeleteSpec",
        component: require("../views/Admin/AdminSpecsTable.vue").default,
    },
];

const router = new VueRouter({
  mode: "history",
  routes,
  scrollBehavior() {
    window.scrollTo(0, 0);
  },
});

export default router;
