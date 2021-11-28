<template>
    <div class="bg-gray-200">
        <!-- NAVIGATION BLOCK -->
        <div class="p-5 bg-gray-800">
            <div class="navigation">
                <div v-if="canLogin" class=" ">
                </div>
            </div>
        </div>

        <main>
            <div class="main-content">
                <slot />
            </div>
        </main>

        <!-- footer maybe -->
    </div>

</template>

<style>
    .auth-forms {
        width: 45%;
        margin: auto;
        padding: 2rem;
    }
</style>

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
