<script setup>
import { onMounted, ref } from 'vue';
import { initFlowbite } from 'flowbite';
import StarterKit from "@tiptap/starter-kit";
import { EditorContent, Editor } from "@tiptap/vue-3";
import { useForm } from "@inertiajs/vue3";
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    content: {
        type: Object,
        required: true,
    },
    courses: {
        type: Object,
        required: true,
    },
});

const states = ref(['Public', 'Privat']);
const showDropdown = ref(false);
const showEditorModal = ref(false);
const showDeleteModal = ref(false);

const form = useForm({
    id: '',
    title: '',
    content: '',
    visibility: '',
    course_id: '',
});

function openEditorModal(id) {
    showEditorModal.value = true;
    const resource = props.content.resources.find(resource => resource.id === id);
    if (resource) {
        form.id = resource.id;
        form.title = resource.title;
        form.content = resource.content;
        form.visibility = resource.visibility;
        form.course_id = resource.course_id;
        editor.commands.setContent(form.content);
    }
    console.log(resource)
}

function openDeleteModal(id) {
    showDeleteModal.value = true;
    const resource = props.content.resources.find(resource => resource.id === id);
    if (resource) {
        form.id = resource.id;
        form.title = resource.title;
        form.content = resource.content;
        form.visibility = resource.visibility;
        form.course_id = resource.course_id;
    }
}

const handleDropdownClick = () => {
    showDropdown.value = !showDropdown.value;
};

const closeModal = () => {
    showDeleteModal.value = false;
    showEditorModal.value = false;
    showDropdown.value = false;
};

const editor = new Editor({
    content: form.content,
    onUpdate: ({ editor }) => {
        form.content = editor.getHTML();
    },
    editorProps: {
        attributes: {
            class: "background",
        },
    },
    extensions: [
        StarterKit
    ],
});

const isBold = ref(false);
const setBold = () => {
    editor.chain().focus().toggleBold().run();
    isBold.value = !isBold.value;
};

const isItalic = ref(false);
const setItalic = () => {
    editor.chain().focus().toggleItalic().run();
    isItalic.value = !isItalic.value;
};

function deleteCourse() {
    showDeleteModal.value = false;
    showDropdown.value = false;
    form.post(route("content.destroy", form.id));
}

function updateCourse() {
    showEditorModal.value = false;
    showDropdown.value = false;
    form.post(route("content.update", form.id));
}

onMounted(() => {
    initFlowbite();
})
</script>

<template>
    <div class="relative flex flex-col justify-items-center items-center pb-4">
        <div class="bg-white border-gray-900 border rounded-md px-4 py-3 w-full relative">
            <div class="flex items-center p-2">
                <div>
                    <span class="text-sm font-bold">{{ content.name }} / {{ content.stage }}</span>
                    <p class="cursor-default mt-1 text-sm" v-html="content.description"></p>
                    <p class="cursor-default mt-1 text-sm">{{ content.state }}</p>
                </div>
            </div>
            <div v-for="(resource, index) in content.resources" :key="index">
                <div class="w-full p-4">
                    <div :id="'accordion-collapse-' + index" data-accordion="collapse">
                        <h2 :id="'accordion-collapse-heading-' + index">
                            <button type="button"
                                class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border border-gray-900 rounded-t-xl dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                                :data-accordion-target="'#accordion-collapse-body-' + index" :aria-expanded="false"
                                :aria-controls="'accordion-collapse-body-' + index">
                                <span>{{ resource.title }}</span>
                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 5 5 1 1 5" />
                                </svg>
                            </button>
                        </h2>
                        <div :id="'accordion-collapse-body-' + index" class="hidden"
                            :aria-labelledby="'accordion-collapse-heading-' + index">
                            <div class="p-5 border border border-gray-900 dark:border-gray-700 dark:bg-gray-900">
                                <div class="top-0 right-0 sm:float-right p-2">
                                    <div class="relative">
                                        <button :id="'dropdownMenuIconButton_' + resource.id"
                                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                            type="button" aria-label="Opciones"
                                            @click="handleDropdownClick(resource.id)">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="currentColor" viewBox="0 0 4 15">
                                                <path
                                                    d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                            </svg>
                                        </button>
                                        <div :class="{ hidden: !showDropdown }"
                                            class="absolute top-full right-0 mt-2 z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-36 sm:w-44 dark:bg-gray-700 dark:divide-gray-600">
                                            <ul class="py-2 text-xs sm:text-sm text-gray-700 dark:text-gray-200"
                                                :aria-labelledby="'dropdownMenuIconButton_' + resource.id
                                                    ">
                                                <li>
                                                    <button
                                                        class="block px-3 sm:px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-left"
                                                        type="button" @click="openEditorModal(resource.id)">
                                                        Editar
                                                    </button>
                                                </li>
                                                <li>
                                                    <button
                                                        class="block px-3 sm:px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-left"
                                                        type="button" @click="openDeleteModal(resource.id)">
                                                        Eliminar
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-2 text-gray-500 dark:text-gray-400" v-html="resource.content"></p>
                                <p class="text-gray-500 dark:text-gray-400">Visibilitat: {{ resource.visibility }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Modal :show="showDeleteModal" @close="closeModal">
        <div class="p-6">
            <h2 class="text-sm font-bold text-gray-900 inline-block mb-2">
                Estàs segur que vols eliminar aquest curs:
                <p class="inline-block text-red">{{ form.title }}</p>
            </h2>
            <p class="mb-2 text-sm">
                <span class="font-bold text-sm">Nom del curs</span>
            <div class="inline-block">{{ form.title }}</div>
            </p>
            <p class="mb-2 text-sm">
                <span class="font-bold text-sm">Etapa: </span>
                {{ form.visibility }}
            </p>
            <p class="mb-2 text-sm">
                <span class="font-bold text-sm">Descripció: </span>
                <span v-html="form.content"></span>
            </p>
            <div class="mt-6 flex justify-end">
                <button @click="closeModal" class="text-sm">Cancel·lar</button>
                <button class="ml-3 text-sm" @click="deleteCourse">
                    Eliminar
                </button>
            </div>
        </div>
    </Modal>

    <Modal :show="showEditorModal" @close="closeModal">
        <div class="p-6">
            <h2 class="text-sm font-bold text-gray-900 mb-4 flex justify-center items-center">
                <span>Edició de curs:</span>
                <span class="text-red ml-1">{{ form.title }}</span>
            </h2>
            <div class="mb-4">
                <label class="block font-bold text-gray-900 text-sm">Nom del curs:</label>
                <input type="text" v-model="form.title"
                    class="text-sm mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red focus:border-red" />
            </div>
            <div class="mb-4">
                <label class="block font-bold text-gray-900 text-sm">Descripció</label>
                <div class="border-container bg-white mt-2">
                    <div class="border-container-bottom mb-2 h-10 flex flex-row items-centers">
                        <button :class="[isBold ? 'toolbar-btn-selected-bold' : 'toolbar-btn-bold']" type="button"
                            @click="setBold">
                            B
                        </button>
                        <button :class="[isItalic ? 'toolbar-btn-selected italic' : 'toolbar-btn italic']" type="button"
                            @click="setItalic">
                            K
                        </button>
                    </div>
                    <editor-content :editor="editor" class="m-4 text-sm" v-model="form.description" />
                </div>
            </div>
            <div class="mb-4">
                <label class="block font-bold text-gray-900 text-sm">Etapa</label>
                <select v-model="form.state"
                    class="text-sm mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red focus:border-red">
                    <option v-for="state in states" :value="state">{{ state }}</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block font-bold text-gray-900 text-sm">Curs al que pertany: </label>
                <select v-model="form.course_id"
                    class="text-sm mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red focus:border-red">
                    <option v-for="course in courses" :value="course.id">{{ course.name }}</option>
                </select>
            </div>
            <div class="mt-6 flex justify-end">
                <button @click="closeModal" class="text-sm">Cancel·lar</button>
                <button @click="updateCourse" class="ml-3 bg-red hover:bg-red text-sm">Guardar</button>
            </div>
        </div>
    </Modal>
</template>

<style lang="postcss">
.toolbar-btn {
    @apply duration-100 ease-in-out hover:bg-gray-900 hover:text-white active:bg-gray-900 active:text-white w-10 h-10;
}

.toolbar-btn-selected {
    @apply duration-100 ease-in-out bg-gray-900 text-white w-10 h-10;
}

.toolbar-btn-bold {
    @apply duration-100 ease-in-out hover:bg-gray-900 hover:text-white active:bg-gray-900 active:text-white w-10 h-10 rounded-tl-md;
}

.toolbar-btn-selected-bold {
    @apply duration-100 ease-in-out bg-gray-900 text-white w-10 h-10 rounded-tl-md;
}

textarea {
    @apply rounded-md border-transparent focus:border-transparent focus:ring-0;
    width: 100%;
    height: 100%;
    resize: none;
}

textarea:focus {
    outline: none;
}

.ProseMirror {
    min-height: 100px;
    max-height: 300px;
    overflow: auto;
}

.ProseMirror a {
    @apply text-blue-500 underline cursor-pointer;
}

.ProseMirror:focus {
    outline: none;
}

.border-container {
    @apply border border-gray-600 rounded-md;
}

.border-container-bottom {
    @apply border border-gray-600 border-x-0 border-t-0;
}

*:disabled {
    background-color: dimgray;
    opacity: 0.15;
    cursor: not-allowed;
}
</style>