import Profile from '@/components/Profile.vue';
import Invest from '@/components/Invest.vue';
import Login from '@/components/Login.vue';

const routes = [
    { path: '/profile', name: "profile", component: Profile },
    { path: '/invest',  name: "invest", component: Invest },
    { path: '/login',  name: "login", component: Login },


];

export default routes;