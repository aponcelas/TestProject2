<script setup>
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { initFlowbite } from 'flowbite';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CoursesCard from '@/Components/CoursesCard.vue';
import { useForm } from "@inertiajs/vue3";
import Modal from '@/Components/Modal.vue';
import StarterKit from "@tiptap/starter-kit";
import { EditorContent, Editor } from "@tiptap/vue-3";

const props = defineProps({
    courses: {
        type: Object,
        required: true,
    },
});

const stages = ref(['ESO', 'BTX', 'CF']);
const states = ref(['Public', 'Privat']);
const showEditorModal = ref(false);

const form = useForm({
    id: '',
    name: '',
    stage: '',
    description: '',
    state: '',
});

const editor = new Editor({
    content: form.description,
    onUpdate: ({ editor }) => {
        form.description = editor.getHTML();
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

function openEditorModal() {
    showEditorModal.value = true;
}

const closeModal = () => {
    showEditorModal.value = false;
};

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

function addCourse() {
    showEditorModal.value = false;
    form.post(route("courses.add", form));
}

function downloadJSON() {
    form.get(route("courses.generateJson"));
}

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
                    <h1
                        class="mb-4 text-3xl font-bold text-center leading-none tracking-tight text-gray-800 md:text-3xl lg:text-4xl dark:text-white">
                        EducatiuCat: Cursos</h1>
                    <p
                        class="mb-6 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400 text-center">
                        Benvingut a l'àrea de cursos d'EducatiuCat, on pots gestionar els teus cursos de manera eficient
                        i senzilla.
                        Aquí trobaràs totes les eines necessàries per crear, editar i eliminar cursos, així com per
                        mantenir actualitzada la teva oferta educativa.
                        Comença a explorar i potenciar els teus cursos avui mateix!</p>
                    <CoursesCard v-for="course in courses" :key="course.id" :course="course" />
                    <button @click="openEditorModal()" type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Afegir
                        curs</button>
                    <button @click="downloadJSON()" type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Cursos
                        en format JSON</button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <Modal :show="showEditorModal" @close="closeModal">
        <div class="p-6">
            <h2 class="text-sm font-bold text-gray-900 mb-4 flex justify-center items-center">
                <span>Edició de curs:</span>
                <span class="text-red ml-1">{{ form.name }}</span>
            </h2>
            <div class="mb-4">
                <label class="block font-bold text-gray-900 text-sm">Nom del curs:</label>
                <input type="text" v-model="form.name"
                    class="text-sm mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red focus:border-red" />
            </div>
            <div class="mb-4">
                <label class="block font-bold text-gray-900 text-sm">Etapa: </label>
                <select v-model="form.stage"
                    class="text-sm mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red focus:border-red">
                    <option v-for="stage in stages" :value="stage">{{ stage }}</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block font-bold text-gray-900 text-sm">Descripció: </label>
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
                <label class="block font-bold text-gray-900 text-sm">Visibilitat: </label>
                <select v-model="form.state"
                    class="text-sm mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red focus:border-red">
                    <option v-for="state in states" :value="state">{{ state }}</option>
                </select>
            </div>
            <div class="mt-6 flex justify-end">
                <button @click="closeModal" class="text-sm">Cancel·lar</button>
                <button @click="addCourse" class="ml-3 bg-red hover:bg-red text-sm">Guardar</button>
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