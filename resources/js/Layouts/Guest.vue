<template>
    <!-- NAVIGATION BLOCK -->
    <div class="p-5 bg-gray-800">
        <div class="navigation">
            <div v-if="canLogin" class=" ">
                <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="bg-blue-600 p-2 text-sm">Dashboard</Link>

                <template v-else>
                    <Link :href="route('login')" class="bg-blue-600 p-2 text-sm text-white">Log in</Link>

                    <Link v-if="canRegister" :href="route('register')" class="bg-blue-600 p-2 ml-4 text-sm text-white">Register</Link>
                </template>
            </div>
        </div>
    </div>

    <main class="bg-gray-200">
        <div class="main-content">
            <slot />
        </div>
    </main>

    <!-- footer maybe -->

</template>

<style scoped>
    .navigation {
        display: flex;
        flex-direction: row-reverse;
        width: 65%;
        margin: auto;
        height: 1.5rem;
    }

    .main-content {
        width: 65%;
        margin: auto;
    }
</style>

<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue'
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeApplicationLogo,
        Link,
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
    },
}
</script>
