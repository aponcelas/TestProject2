<script setup>
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { initFlowbite } from 'flowbite';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CoursesCard from '@/Components/CoursesCard.vue';

const props = defineProps({
    courses: {
        type: Object,
        required: true,
    },
});

onMounted(() => {
    initFlowbite();
    console.log(props.courses);
})
</script>

<template>

    <Head title="Welcome" />

    <AuthenticatedLayout>
        <div class="bg-gray-200">
            <div class="relative flex flex-col items-center justify-center p-10">
                <div class="relative w-full">
                    <CoursesCard v-for="course in courses" :key="course.id" :course="course" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
