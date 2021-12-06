<template>
    <Head title="Profile" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My posts
            </h2>
        </template>

        <div class="relative py-3 sm:max-w-4xl sm:mx-auto">
            <div class="relative p-2 bg-white shadow-lg rounded sm:p-10 bg-clip-padding bg-opacity-60 border border-gray-200">
                <form @submit.prevent>
                    <textarea class="form-textarea mt-1 block w-full rounded"
                        ref="postArea"
                        rows="3"
                        v-model="this.createPostForm.content"
                        placeholder="Lorem, ipsum dolor sit amet consectetur adipisicing elit."></textarea>
                    <InputError class="mt-1" :message="$page.props.errors.content" />
                    <InputError class="mt-1" :message="$page.props.errors.image" />

                    <Input v-show="false"
                        @change="onFileSelect"
                        ref="fileInput"
                        id="image" type="file" class="mt-1 block w-full" name="image" />
                    <div class="flex flex-row-reverse mt-2 gap-3">
                        <Button
                            @click="createPost"
                            type="button">
                            Post
                        </Button>
                        <Button type="button"
                            @click="$refs.fileInput.$refs.input.click()"
                            class="inline-flex items-center bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:shadow-outline-blue transition ease-in-out duration-150">
                            Attach Image
                        </Button>
                    </div>
                </form>
            </div>
        </div>
        <div v-for="(post) in userPosts.data" :key="post.id">
            <div class="relative py-3 sm:max-w-4xl sm:mx-auto">
                <div class="relative px-16 pt-4 bg-white shadow-lg rounded bg-clip-padding bg-opacity-60 border border-gray-200">
                    <div class="pb-3 flex justify-between">
                        <div class="flex justify-content items-center">
                            <img src="https://via.placeholder.com/40" class="rounded-full" />
                            <div class="ml-3 text-sm">
                                <p class="mb-0">{{ post.byProfileName }}</p>
                                <p class="mb-0">{{ post.created_at }}</p>
                            </div>
                        </div>
                        <Dropdown v-if="post.user_id === $page.props.auth.user.id" align="right" width="48">
                            <template #trigger>
                                <button type="button" class="mt-2">
                                    <EllipsisIcon />
                                </button>
                            </template>

                            <template #content>
                                <DropdownLink :href="route('post.visibility', { post: post.id, visibility: 'public' })" method="post" as="button" preserve-scroll>
                                    Set to Public
                                </DropdownLink>
                                <DropdownLink :href="route('post.visibility', { post: post.id, visibility: 'private' })" method="post" as="button" preserve-scroll>
                                    Set to Private
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                    <div class="divide-y divide-gray-200 cursor-pointer" @click="generateViewPage(post)">
                        <template v-if="post.image_reference">
                            <Image :src="post.image_reference" />
                        </template>
                        <div class="py-2 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                            {{ post.content }}
                        </div>
                    </div>
                    <div class="flex flex-row justify-between py-4">
                        <span v-if="post.likes > 0" class="text-sm"><span>{{ post.likes }}</span> Likes</span>
                        <span v-if="post.comment.length > 0" class="text-sm"><span>{{ post.comment.length }}</span> Comments</span>
                    </div>
                    <div class="bg-clip-padding border-t border-b border-gray-200">
                        <div class="flex justify-between my-3">
                            <div class="px-20">
                                <button
                                    v-if="post.likedByCurrentUser !== null && post.likedByCurrentUser === $page.props.auth.user.id"
                                    type="button"
                                    class="text-blue-600"
                                    @click="onLikePost(post.id)">Unlike</button>

                                <button v-else type="button" @click="onLikePost(post.id)">Like</button>
                            </div>
                            <div class="px-20">
                                <button type="button" @click="onDisplayCommentBox(post.id)">Comment</button>
                            </div>
                        </div>
                    </div>
                    <div v-if="displayCommentBox === post.id" class="mt-2 mb-4">
                        <form @submit.prevent>
                            <Input
                                :id="`commentBox${post.id}`"
                                type="text"
                                class="mt-1 block w-full"
                                name="content"
                                v-model="createCommentForm.content"
                                @keyup.enter="createComment(post.id)"
                                autofocus />
                            <InputError class="mt-1" :message="$page.props.errors.content" />
                        </form>
                    </div>
                    <div class="pb-4">
                        <div class="flex my-2" v-for="(comment) in post.comment" :key="comment.id">
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
import { debounce } from 'lodash/function'

export default {

    props: {
        posts: Object
    },

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
            userPosts: this.posts,
            displayCommentBox: false,
            createPostForm: this.$inertia.form({
                content: '',
                image: null
            }),
            createCommentForm: this.$inertia.form({
                content: ''
            })
        }
    },

    mounted() {
        window.addEventListener('scroll', debounce(this.loadMorePosts, 100));
    },

    destroyed() {
        window.removeEventListener("scroll", this.loadMorePosts);
    },

    methods: {
        loadMorePosts() {
            let offsetHeight = document.documentElement.offsetHeight,
                scrollTop = document.documentElement.scrollTop;

            let pixelsFromBottom = offsetHeight - scrollTop - window.innerHeight;

            if (pixelsFromBottom < 200)
            {
                if (this.userPosts.next_page_url !== null)
                {
                    axios.get(this.userPosts.next_page_url).then(response => {
                        this.userPosts = {
                            ...response.data,
                            data: [...this.userPosts.data, ...response.data.data]
                        }
                    });
                }
            }
        },
        onFileSelect() {
            this.createPostForm.image = this.$refs.fileInput.$refs.input.files[0]
        },
        createPost() {
            this.createPostForm.post(this.route('post.store'), {
                onFinish: () => {
                    this.createPostForm.content = ''
                    this.createPostForm.image = null
                }
            })
        },
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
        generateViewPage(data) {
            if (data.image_reference) {
                window.open(this.route('post.view', { post: data.id }), '_self');
            }
        }
    }
}
</script>
