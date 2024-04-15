<script setup>
import { onMounted } from 'vue';
import { initFlowbite } from 'flowbite';

const props = defineProps({
    course: {
        type: Object,
        required: true,
    },
});

onMounted(() => {
    initFlowbite();
    console.log(props.course);
})
</script>

<template>
    <div class="relative flex flex-col justify-items-center items-center pb-4">
        <div class="bg-white border-gray-900 border rounded-md px-4 py-3 w-full relative">
            <div class="flex items-center p-2">
                <div>
                    <span class="text-sm font-bold">{{ course.name }}</span>
                    <p class="cursor-default mt-1 text-sm" v-html="course.description"></p>
                </div>
            </div>
        </div>
    </div>
</template>
