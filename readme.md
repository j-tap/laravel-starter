# Laravel Vue SPA
Starter SPA made with Laravel, Vue-router, Vuex, Axios, Bootstrap, Pug
Based on [laravel-vue-spa](https://github.com/anindya-dhruba/laravel-vue-spa) Anindya Dhruba

## What's New
 * Add page users list
 * Add page 404
 * Modify auth
 * Add [Pug](https://pugjs.org) template engine
 
## What's included 
* [Laravel 5.6](https://laravel.com/docs/5.6)
* [Vue 2](https://vuejs.org)
* [Vue Router 3](http://router.vuejs.org)
* [Vuex 3](http://vuex.vuejs.org)
* [Axios](https://github.com/axios/axios)
* [Authentication with JWT Token](https://github.com/tymondesigns/jwt-auth)
* [Vue I18n](https://github.com/kazupon/vue-i18n)
* [Pug](https://pugjs.org)
* [bootstrap-vue](https://bootstrap-vue.js.org/)
* [vuelidate](https://github.com/vuelidate/vuelidate)

## Installation:
* Clone the repo
* Copy `.env.example` to `.env`
* Configure `.env`
* `cd` to the repo
* Run `composer update`
* Run `php artisan key:generate`
* Run `php artisan migrate --seed`. A user will be seeded so that you can login, where:
    * email is: `root@example.com`
    * password is: `root`
* Run `npm install`
* Run `npm run watch`
* View the site by 
    * Either running `php artisan serve` if you are not using vagrant homestead or laravel valet (in a new terminal/command prompt)
    * Otherwise go to your local dev url configured in vagrant
