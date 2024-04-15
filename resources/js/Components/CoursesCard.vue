<script setup>
import { onMounted, ref } from 'vue';
import { initFlowbite } from 'flowbite';
import StarterKit from "@tiptap/starter-kit";
import { EditorContent, Editor } from "@tiptap/vue-3";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    course: {
        type: Object,
        required: true,
    },
});

const showDropdown = ref(false);
const showEditorModal = ref(false);
const showDeleteModal = ref(false);

const form = useForm({
    id: '',
    name: props.course.nombre,
    stage: props.course.etapa,
    description: props.course.descripcion,
    state: props.course.activo,
});

function openEditorModal(id) {
    showEditorModal.value = true;
    form.id = id;
}

function openDeleteModal(id) {
    showDeleteModal.value = true;
    form.id = id;
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

function deleteUser() {
    showDeleteModal.value = false;
    showDropdown.value = false;
    form.post(route("welcome.users.destroy", form.id));
}

function updateUser() {
    showEditorModal.value = false;
    showDropdown.value = false;
    form.post(route("welcome.users.update", form.id));
}

onMounted(() => {
    initFlowbite();
})
</script>

<template>
    <div class="relative flex flex-col justify-items-center items-center pb-4">
        <div class="bg-white border-gray-900 border rounded-md px-4 py-3 w-full relative">
            <div class="absolute top-0 right-0 sm:float-right p-2">
                <div class="relative">
                    <button :id="'dropdownMenuIconButton_' + course.id"
                        class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        type="button" aria-label="Opciones" @click="handleDropdownClick(course.id)">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 4 15">
                            <path
                                d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                        </svg>
                    </button>
                    <div :class="{ hidden: !showDropdown }"
                        class="absolute top-full right-0 mt-2 z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-36 sm:w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-2 text-xs sm:text-sm text-gray-700 dark:text-gray-200" :aria-labelledby="'dropdownMenuIconButton_' + course.id
                            ">
                            <li>
                                <button
                                    class="block px-3 sm:px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-left"
                                    type="button" @click="openEditorModal(course.id)">
                                    Editar
                                </button>
                            </li>
                            <li>
                                <button
                                    class="block px-3 sm:px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-left"
                                    type="button" @click="openDeleteModal(course.id)">
                                    Eliminar
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="flex items-center p-2">
                <div>
                    <span class="text-sm font-bold" v-html="course.nombre"></span>
                    <p class="cursor-default mt-1 text-sm">{{ course.descripcion }}</p>
                </div>
            </div>
        </div>
    </div>

    <Modal :show="showDeleteModal" @close="closeModal">
        <div class="p-6">
            <h2 class="text-sm font-bold text-gray-900 inline-block mb-2">
                Estàs segur que vols eliminar l'usuari:
                <p class="inline-block text-red" v-html="form.name"></p>
            </h2>
            <p class="mb-2 text-sm">
                <span class="font-bold text-sm">Nom d'usuari: </span>
            <div class="inline-block" v-html="form.name"></div>
            </p>
            <p class="mb-2 text-sm">
                <span class="font-bold text-sm">Correu electrònic: </span>
                {{ form.email }}
            </p>
            <div class="mt-6 flex justify-end">
                <button @click="closeModal" class="text-sm">Cancel·lar</button>
                <button class="ml-3 text-sm" @click="deleteUser">
                    Eliminar
                </button>
            </div>
        </div>
    </Modal>

    <Modal :show="showEditorModal" @close="closeModal">
        <div class="p-6">
            <h2 class="text-sm font-bold text-gray-900 mb-4 flex justify-center items-center">
                <span>Edició de curs:</span>
                <span class="text-red ml-1">{{ form.name }}</span>
            </h2>
            <div class="mb-4">
                <label class="block font-bold text-gray-900 text-sm">Nom d'usuari</label>
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
                    <editor-content :editor="editor" class="m-4 text-sm" v-model="form.name" />
                </div>
            </div>
            <div class="mb-4">
                <label class="block font-bold text-gray-900 text-sm">Correu electrònic</label>
                <input type="email" v-model="form.email" readonly
                    class="text-sm bg-gray-200 text-gray-600 opacity-50 mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red focus:border-red" />
            </div>
            <div class="mb-4">
                <label class="block font-bold text-gray-900 text-sm">Contrasenya</label>
                <input type="password" v-model="form.password"
                    class="text-sm mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red focus:border-red" />
            </div>
            <div class="mt-6 flex justify-end">
                <button @click="closeModal" class="text-sm">Cancel·lar</button>
                <button @click="updateUser" class="ml-3 bg-red hover:bg-red text-sm">Guardar</button>
            </div>
        </div>
    </Modal>


</template>
