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
                            <p class="mb-0">{{ $page.props.post.byProfileName }}</p>
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
                <div class="flex flex-row justify-between py-4">
                    <span v-if="$page.props.post.likes > 0" class="text-sm"><span>{{ $page.props.post.likes }}</span> Likes</span>
                    <span v-if="$page.props.post.comment.length > 0" class="text-sm"><span>{{ $page.props.post.comment.length }}</span> Comments</span>
                </div>
                <div class="bg-clip-padding border-t border-b border-gray-200">
                    <div class="flex justify-between my-3">
                        <div class="px-20">
                            <button
                                v-if="$page.props.post.likedByCurrentUser !== null && $page.props.post.likedByCurrentUser === $page.props.auth.user.id"
                                type="button"
                                class="text-blue-600"
                                @click="onLikePost($page.props.post.id)">Unlike</button>

                            <button v-else type="button" @click="onLikePost($page.props.post.id)">Like</button>
                        </div>
                        <div class="px-20">
                            <button type="button" @click="onDisplayCommentBox($page.props.post.id)">Comment</button>
                        </div>
                    </div>
                </div>
                <div v-if="displayCommentBox === $page.props.post.id" class="mt-2 mb-4">
                    <form @submit.prevent>
                        <Input
                            :id="`commentBox${$page.props.post.id}`"
                            type="text"
                            class="mt-1 block w-full"
                            name="content"
                            v-model="createCommentForm.content"
                            @keyup.enter="createComment($page.props.post.id)"
                            autofocus />
                        <InputError class="mt-1" :message="$page.props.errors.content" />
                    </form>
                </div>
                <div class="pb-4">
                    <div class="flex my-2" v-for="(comment) in $page.props.post.comment" :key="comment.id">
                        <div class="flex justify-content items-center">
                            <img src="https://via.placeholder.com/35" class="rounded-full rounded-full mb-auto mt-1" />
                            <div>
                                <div class="ml-3 text-sm py-2 px-4 rounded rounded-md bg-gray-100">
                                    <p class="mb-0">{{ comment.byProfileName }}</p>
                                    <p>{{ comment.content }}</p>
                                </div>
                                <p class="text-xs ml-4 py-2">{{ comment.created_at }}</p>
                            </div>
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
        return {
            displayCommentBox: false,
            createCommentForm: this.$inertia.form({
                content: ''
            })
        }
    },

    methods: {
        onDisplayCommentBox(data) {
            this.displayCommentBox = data
        },
        onLikePost(id) {
            this.$inertia.form().post(this.route('post.like.store', { post: id }), {
                preserveScroll: true
            })
        },
        createComment(id) {
            this.createCommentForm.post(this.route('post.comment.store', { post: id }), {
                preserveScroll: true,
                onFinish: () => {
                    this.displayCommentBox = false
                    this.createCommentForm.content = ''
                }
            })
        },
    }
}
</script>
