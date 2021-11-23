<template>
    <Head title="Home" />

    <MainLayout v-bind="$props">

    </MainLayout>
</template>

<style scoped>


</style>

<script>
import MainLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
      Head,
      Link,
      MainLayout,
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
    }
}
</script>
