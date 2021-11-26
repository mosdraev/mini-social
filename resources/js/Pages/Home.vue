<template>
    <Head title="Home" />

    <BreezeAuthenticatedLayout v-bind="$props">

    </BreezeAuthenticatedLayout>
</template>

<style scoped>


</style>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
      Head,
      Link,
      BreezeAuthenticatedLayout,
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
    }
}
</script>
