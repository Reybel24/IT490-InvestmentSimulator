import Profile from '@/components/Profile.vue';
import Invest from '@/components/Invest.vue';
import Login from '@/components/Login.vue';
import Register from '@/components/Register.vue';

const routes = [
    { path: '/profile', name: "profile", component: Profile },
    { path: '/invest',  name: "invest", component: Invest },
    { path: '/login',  name: "login", component: Login },
    { path: '/register',  name: "register", component: Register },


];

export default routes;