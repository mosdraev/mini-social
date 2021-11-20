<template>
    <Head title="Home" />

    <BreezeGuestLayout v-bind="$props">

        <div class="bg-gray-400 grid grid-cols-6">
            <div class="col-span-4">
                hello home page
            </div>
            <div class="">
                right menu
            </div>
        </div>

    </BreezeGuestLayout>
</template>

<style scoped>


</style>

<script>
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
      Head,
      Link,
      BreezeGuestLayout,
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
    }
}
</script>
