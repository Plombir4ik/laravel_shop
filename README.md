# Shop4you

Online shop designed for smooth browsing and precise
filtering of diverse products with further delivery tracking.

_The frontend part was inspired  by the [`js_shop`](https://github.com/icenfame/js_shop) repository_.

![alt text](https://live.staticflickr.com/65535/53662693051_7e177e1665_o.png)

### Installation

Make sure you have **PHP** and **Composer** installed for running **Laravel**, as well as **Node.js** and **npm** for installing and running JavaScript dependencies.

Before running the application, ensure to rename the **.env.example** file to **.env** and configure the **DB_** keys for database connection, as well as the **MIX_NOVA_POSHTA_KEY** for Nova Poshta API integration.

- Install php dependencies: `composer install`

- Install javascript dependencies: `npm install`

- Generate a new application key: `php artisan key:generate`

- Build project: `npm run dev`

- Start app: `php artisan serve`
