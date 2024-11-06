//import vue router
import { createRouter, createWebHistory } from "vue-router";

//define a routes
const routes = [
  {
    path: "/",
    name: "home",
    component: () => import(/* webpackChunkName: "home" */ "../views/home.vue"),
  },
  {
    path: "/members",
    name: "members.index",
    component: () => import(/* webpackChunkName: "index" */ "../views/members/index.vue"),
  },
  {
    path: "/create",
    name: "members.create",
    component: () => import(/* webpackChunkName: "create" */ "../views/members/create.vue"),
  },
  {
    path: "/edit/:id",
    name: "members.edit",
    component: () => import(/* webpackChunkName: "edit" */ "../views/members/edit.vue"),
  },
];

//create router
const router = createRouter({
  history: createWebHistory(),
  routes, // <-- routes,
});

export default router;
