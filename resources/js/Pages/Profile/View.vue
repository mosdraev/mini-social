<template>
    <Head title="Profile" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        Here is your profile! {{ $page.props.profileData.firstname }}
                    </div>

                    <div class="grid grid-cols-8 p-6">
                        <div class="col-span-2">
                            <img class="" src="https://via.placeholder.com/250" />
                        </div>
                        <div class="col-span-offset-2">
                            <Link
                                class="mb-2 inline-flex items-center px-4 py-2 bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:shadow-outline-blue transition ease-in-out duration-150"
                                :href="route('viewProfile', $page.props.auth.user.id)">Edit Profile</Link>
                            <Button :type="button">Change Photo</Button>
                        </div>
                        <div class="col-span-offset-3 col-span-5">
                            <div class="ml-9">
                                <p>
                                    <span class="font-bold">Name:</span>
                                    {{ $page.props.profileData.firstname +' '+ $page.props.profileData.lastname }}
                                </p>
                                <p>
                                    <span class="font-bold">Email:</span>
                                    {{ $page.props.auth.user.email }}
                                </p>
                                <p>
                                    <span class="font-bold">Mobile No.:</span>
                                    {{ $page.props.profileData.mobile_number ?? '---' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import Button from '@/Components/Button.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Button,
        Link,
    },
}
</script>