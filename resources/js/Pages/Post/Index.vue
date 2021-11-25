<template>
    <Head title="Profile" />

    <BreezeAuthenticatedLayout>
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
        <div v-for="(post) in $page.props.posts" :key="post.id">
            <div class="relative py-3 sm:max-w-4xl sm:mx-auto">
                <div class="relative pb-10 px-16 pt-4 bg-white shadow-lg rounded bg-clip-padding bg-opacity-60 border border-gray-200">
                    <div class="pb-3 flex justify-between">
                        <div class="flex justify-content items-center">
                            <img src="https://via.placeholder.com/40" class="rounded-full" />
                            <div class="ml-3 text-sm">
                                <p class="mb-0">{{ $page.props.auth.profile.firstname + ' ' + $page.props.auth.profile.lastname }}</p>
                                <p class="mb-0">{{ post.created_at }}</p>
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
                                    Set to Public
                                </DropdownLink>
                                <DropdownLink >
                                    Set to Private
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <template v-if="post.image_reference">
                            <Image :src="post.image_reference" />
                        </template>
                        <div class="py-2 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                            {{ post.content }}
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
import { Head, Link } from '@inertiajs/inertia-vue3'
import InputError from '@/Components/InputError.vue'
import Input from '@/Components/Input.vue'
import Image from '@/Components/Image.vue'
import EllipsisIcon from '@/Components/EllipsisIcon.vue'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'

export default {
    components: {
        BreezeAuthenticatedLayout,
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
            createPostForm: this.$inertia.form({
                content: '',
                image: null
            })
        }
    },

    methods: {
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
        }
    }
}
</script>
