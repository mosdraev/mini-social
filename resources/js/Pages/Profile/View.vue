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
                    <div v-if="!showUpdateForm"  class="p-6 bg-white border-b border-gray-200">
                        Here is your profile, {{ $page.props.profileData.firstname }}!
                    </div>

                    <div v-else class="p-6 bg-white border-b border-gray-200">
                        Update your profile here!
                    </div>

                    <div class="grid grid-cols-8 p-6">
                        <div class="col-span-2">
                            <img class="" src="https://via.placeholder.com/250" />
                        </div>
                        <div class="col-span-offset-2">
                            <Button
                                type="button"
                                @click="showUpdateForm = !showUpdateForm"
                                class="mb-2 inline-flex items-center px-4 py-2 bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:shadow-outline-blue transition ease-in-out duration-150"
                                >
                                Edit Profile
                            </Button>
                            <Button type="button">Change Photo</Button>
                        </div>

                        <template v-if="!showUpdateForm">
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
                        </template>
                        <template v-else>
                            <div class="col-span-offset-3 col-span-5">
                                <div class="ml-9">
                                    <form @submit.prevent="submit">
                                        <div>
                                            <Label for="firstname" value="Firstname" />
                                            <Input id="firstname" type="text" class="mt-1 block w-full" name="firstname" :modelValue="$page.props.profileData.firstname" v-model="form.firstname" required autofocus />
                                            <InputError class="mt-1" :message="$page.props.errors.firstname" />
                                        </div>
                                        <div class="mt-4">
                                            <Label for="lastname" value="Lastname" />
                                            <Input id="lastname" type="text" class="mt-1 block w-full" name="lastname" :modelValue="$page.props.profileData.lastname" v-model="form.lastname" required autofocus autocomplete="lastname" />
                                            <InputError class="mt-1" :message="$page.props.errors.lastname" />
                                        </div>
                                        <div class="mt-4">
                                            <Label for="email" value="Email" />
                                            <Input id="email" type="email" class="mt-1 block w-full" name="email" :modelValue="$page.props.auth.user.email" v-model="form.email" required autofocus autocomplete="email" />
                                            <InputError class="mt-1" :message="$page.props.errors.email" />
                                        </div>
                                        <div class="mt-4">
                                            <Label for="mobilenum" value="Mobile Number" />
                                            <Input id="mobilenum" type="text" class="mt-1 block w-full" name="mobile_number" :modelValue="$page.props.profileData.mobile_number" v-model="form.mobile_number" autofocus autocomplete="mobile_number" />
                                            <InputError class="mt-1" :message="$page.props.errors.mobile_number" />
                                        </div>
                                        <div class="mt-4 flex flex-row-reverse">
                                            <Button type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                                class="inline-flex items-center bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:shadow-outline-blue transition ease-in-out duration-150"
                                            >Save Profile
                                            </Button>
                                            <Button @click="showUpdateForm = !showUpdateForm" type="button" class="mr-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Cancel</Button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import Button from '@/Components/Button.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
import Label from '@/Components/Label.vue'
import Input from '@/Components/Input.vue'
import InputError from '@/Components/InputError.vue'

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Button,
        Link,
        Label,
        Input,
        InputError,
    },

    data() {
        return {
            showUpdateForm: false,
            form: this.$inertia.form({
                firstname: '',
                lastname: '',
                email: '',
                mobile_number: '',
            })
        }
    },

    methods: {
        submit(event) {
            let {
                firstname,
                lastname,
                email,
                mobile_number
            } = event.target.elements;

            this.form.firstname = firstname.value;
            this.form.lastname = lastname.value;
            this.form.email = email.value;
            this.form.mobile_number = mobile_number.value;

            this.form.put(this.route('update.profile', this.$page.props.auth.user.id), {
                onFinish: () => this.showUpdateForm = false,
            });
        }
    }
}
</script>