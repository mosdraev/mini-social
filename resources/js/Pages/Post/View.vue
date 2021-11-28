<template>
    <Head title="Profile" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My post
            </h2>
        </template>

        <div class="relative py-3 sm:max-w-4xl sm:mx-auto">
            <div class="relative px-16 pb-4 pt-4 bg-white shadow-lg rounded bg-clip-padding bg-opacity-60 border border-gray-200">
                <div class="pb-3 flex justify-between">
                    <div class="flex justify-content items-center">
                        <img src="https://via.placeholder.com/40" class="rounded-full" />
                        <div class="ml-3 text-sm">
                            <p class="mb-0">{{ $page.props.auth.user.firstname + ' ' + $page.props.auth.user.lastname }}</p>
                            <p class="mb-0">{{ $page.props.post.created_at }}</p>
                        </div>
                    </div>
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button type="button" class="mt-2">
                                <EllipsisIcon />
                            </button>
                        </template>

                        <template #content>
                            <DropdownLink >
                                Edit Post
                            </DropdownLink>
                            <DropdownLink :href="route('post.visibility', { post: $page.props.post.id, visibility: 'public' })" method="post" as="button" preserve-scroll>
                                Set to Public
                            </DropdownLink>
                            <DropdownLink :href="route('post.visibility', { post: $page.props.post.id, visibility: 'private' })" method="post" as="button" preserve-scroll>
                                Set to Private
                            </DropdownLink>
                            <DropdownLink >
                                Delete Post
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
                <div class="divide-y divide-gray-200">
                    <template v-if="$page.props.post.image_reference">
                        <Image :src="$page.props.post.image_reference" />
                    </template>
                    <div class="py-2 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                        {{ $page.props.post.content }}
                    </div>
                </div>
                <div class="flex flex-row flex flex-row gap-10 py-4">
                    <span>Likes</span>
                    <span>Comments</span>
                </div>
                <div class="bg-clip-padding border-t border-gray-200">

                    <div class="flex justify-between mt-3">
                        <div class="px-20">
                            <button type="button">Like</button>
                        </div>
                        <div class="px-20">
                            <button type="button">Comment</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
<script>
import MainLayout from '@/Layouts/Authenticated.vue'
import Button from '@/Components/Button.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
import InputError from '@/Components/InputError.vue'
import Input from '@/Components/Input.vue'
import Image from '@/Components/Image.vue'
import EllipsisIcon from '@/Components/EllipsisIcon.vue'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'

export default {
    components: {
        MainLayout,
        Dropdown,
        DropdownLink,
        Head,
        Link,
        Button,
        Input,
        InputError,
        Image,
        EllipsisIcon,
    },

    data() {
        return {}
    },

    methods: {

    }
}
</script>
