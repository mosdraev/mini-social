<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <Link :href="route('post.index')">
                                    <BreezeApplicationLogo class="block h-9 w-auto" />
                                </Link>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <template v-if="$page.props.auth.user">
                                <BreezeDropdown align="right" width="96">
                                    <template #trigger>
                                        <div v-if="this.notificationCount > 0" class="cursor-pointer z-50 flex" @click="showNotifications">
                                            <span class="bg-red-600 rounded text-white text-xs z-10 ml-3 mt-2">{{ this.notificationCount }}</span>
                                            <div class="absolute mt-1">
                                                <BellIcon />
                                            </div>
                                        </div>

                                        <div v-else class="cursor-pointer" @click="showNotifications">
                                            <div class="mt-1">
                                                <BellIcon />
                                            </div>
                                        </div>
                                    </template>

                                    <template #content>
                                        <div class="overflow-y-scroll pt-3 max-h-96 h-auto">
                                            <div v-if="this.notificationData.length === 0" class="pl-2 pr-1">I am loading notifications...</div>
                                            <div class="pb-2 px-3" v-else v-for="notification in this.notificationData" :key="notification.id">
                                                <Link :href="this.route('post.view', { post: notification.data.reference_id })">
                                                    <p class="cursor-pointer hover:bg-gray-300">
                                                        {{ notification.data.message }}
                                                    </p>
                                                </Link>
                                            </div>
                                        </div>
                                    </template>
                                </BreezeDropdown>
                            </template>
                            <div class="ml-3 relative">
                                <BreezeDropdown v-if="$page.props.auth.user" align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.firstname + ' ' + $page.props.auth.user.lastname }}
                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <BreezeDropdownLink :href="route('view.profile', $page.props.auth.user.id)">
                                            Profile
                                        </BreezeDropdownLink>
                                        <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </BreezeDropdownLink>
                                    </template>
                                </BreezeDropdown>

                                <template v-else>
                                    <div class="flex flex-row gap-3">
                                        <BreezeNavLink :href="route('login')">Log in</BreezeNavLink>
                                        <BreezeNavLink :href="route('register')">Register</BreezeNavLink>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <template v-if="$page.props.auth.user">
                            <div class="px-4">
                                <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.firstname + ' ' + $page.props.auth.user.lastname }}</div>
                                <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <BreezeResponsiveNavLink :href="route('view.profile', $page.props.auth.user.id)">
                                    Profile
                                </BreezeResponsiveNavLink>
                                <BreezeResponsiveNavLink :href="route('logout')" method="post" as="button">
                                    Log Out
                                </BreezeResponsiveNavLink>
                            </div>
                        </template>

                        <template v-else>
                            <div class="flex flex-row gap-3">
                                <BreezeNavLink :href="route('login')">Log in</BreezeNavLink>
                                <BreezeNavLink :href="route('register')">Register</BreezeNavLink>
                            </div>
                        </template>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<style>
    .auth-forms {
        width: 45%;
        margin: auto;
        padding: 2rem;
    }
</style>

<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue'
import BellIcon from '@/Components/BellIcon.vue'
import BreezeDropdown from '@/Components/Dropdown.vue'
import BreezeDropdownLink from '@/Components/DropdownLink.vue'
import BreezeNavLink from '@/Components/NavLink.vue'
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeApplicationLogo,
        BreezeDropdown,
        BreezeDropdownLink,
        BreezeNavLink,
        BreezeResponsiveNavLink,
        Link,
        BellIcon,
    },

    data() {
        return {
            showingNavigationDropdown: false,
            notificationCount: 0,
            notificationData: {}
        }
    },

    methods: {
        showNotifications() {
            axios.post(this.route('post.notification', { user: this.$page.props.auth.user.id })).then((response) => {
                this.notificationData = response.data
            })
        }
    },

    mounted() {
        if (this.$page.props.auth.user) {
            this.$echo.private('App.Models.User.' + this.$page.props.auth.user.id)
                .notification((notification) => {
                    this.notificationCount += 1;
                    this.$toast.show(notification.message, {
                        type: 'default',
                        position: 'top'
                    });
                    console.log(notification.message);
                });
        }

        this.notificationCount = this.$page.props.notifications

        // Close all opened toast after 3000ms
        setTimeout(this.$toast.clear, 3000)
    },

    props: {
        canLogin: Boolean,
        canRegister: Boolean,
    },
}
</script>
