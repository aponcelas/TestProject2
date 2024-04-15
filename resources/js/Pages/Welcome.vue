<script setup>
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { initFlowbite } from 'flowbite';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    courses: {
        type: Object,
        required: true,
    }
});

const acceptedCookies = ref(false);

const acceptCookies = () => {
    acceptedCookies.value = true;
    localStorage.setItem('acceptedCookies', true);
}

onMounted(() => {
    initFlowbite();
})
</script>

<template>

    <Head title="Welcome" />

    <AuthenticatedLayout>
        <div class="bg-gray-200">
            <div class="relative flex flex-col items-center justify-center p-10">
                <div class="relative w-full">
                    <main>
                        <h1
                            class="mb-4 text-3xl font-bold text-center leading-none tracking-tight text-gray-800 md:text-3xl lg:text-4xl dark:text-white">
                            EducatiuCat</h1>
                        <p
                            class="mb-6 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400 text-center">
                            Benvingut a EducatiuCat, la plataforma educativa líder on trobaràs una àmplia gamma de
                            cursos per a tots els nivells i edats. Aprèn de manera interactiva i divertida. Comença avui
                            mateix el teu viatge educatiu amb nosaltres!</p>
                        <div id="default-carousel" class="relative w-full" data-carousel="slide">
                            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                    <img src="/images/imatge1.jpg"
                                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                        alt="...">
                                </div>
                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                    <img src="/images/imatge2.jpg"
                                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                        alt="...">
                                </div>
                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                    <img src="/images/imatge3.jpg"
                                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                        alt="...">
                                </div>
                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                    <img src="/images/imatge4.jpg"
                                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                        alt="...">
                                </div>
                            </div>
                            <div
                                class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                                <button type="button" class="w-3 h-3 rounded-full" aria-current="true"
                                    aria-label="Slide 1" data-carousel-slide-to="0"></button>
                                <button type="button" class="w-3 h-3 rounded-full" aria-current="false"
                                    aria-label="Slide 2" data-carousel-slide-to="1"></button>
                                <button type="button" class="w-3 h-3 rounded-full" aria-current="false"
                                    aria-label="Slide 3" data-carousel-slide-to="2"></button>
                                <button type="button" class="w-3 h-3 rounded-full" aria-current="false"
                                    aria-label="Slide 4" data-carousel-slide-to="3"></button>
                            </div>
                            <button type="button"
                                class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                                data-carousel-prev>
                                <span
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M5 1 1 5l4 4" />
                                    </svg>
                                    <span class="sr-only">Previous</span>
                                </span>
                            </button>
                            <button type="button"
                                class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                                data-carousel-next>
                                <span
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                    <span class="sr-only">Next</span>
                                </span>
                            </button>
                        </div>

                        <div v-if="$page.props.auth.user" class="mt-10">
                            <h1
                                class="mb-4 text-3xl font-bold text-center leading-none tracking-tight text-gray-800 md:text-3xl lg:text-4xl dark:text-white">
                                Cursos Publics</h1>
                            <Card v-for="course in courses" :key="course.id" :course="course" />
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <div v-if="!acceptedCookies" class="bottom-0 left-0 right-0 flex w-full -mt-4">
        <div class="bg-white p-6 w-full">
            <h2 class="text-xl font-semibold mb-4">Política de Cookies</h2>
            <p class="text-sm text-gray-600 w-full">
                Aquest lloc web utilitza cookies per garantir que obtinguis la millor experiència en el nostre lloc web.
                Per obtenir més informació sobre les cookies que utilitzem i com pots gestionar-les, consulta la nostra
                <a href="/politica-de-cookies" class="text-blue-500 hover:underline">política de cookies</a>.
            </p>
            <div class="mt-2 flex justify-end">
                <button @click="acceptCookies"
                    class="px-2 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Acceptar</button>
            </div>
        </div>
    </div>
</template>
