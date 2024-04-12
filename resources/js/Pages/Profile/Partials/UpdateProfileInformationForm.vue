<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import StarterKit from "@tiptap/starter-kit";
import { EditorContent, Editor } from "@tiptap/vue-3";
import { ref } from "vue";


defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});

const editor = new Editor({
    content: form.name,
    onUpdate: ({ editor }) => {
        form.name = editor.getHTML();
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


const isUnderline = ref(false);
const setUnderline = () => {
    editor.chain().focus().toggleUnderline().run();
    isUnderline.value = !isUnderline.value;
};


const isItalic = ref(false);
const setItalic = () => {
    editor.chain().focus().toggleItalic().run();
    isItalic.value = !isItalic.value;
};


function setLink() {
    const previousUrl = editor.getAttributes("link").href;
    const url = window.prompt("Entra l'enllaç", previousUrl);

    if (url === null) return;

    if (url === "") {
        editor.chain().focus().extendMarkRange("link").unsetLink().run();
        return;
    }

    editor
        .chain()
        .focus()
        .extendMarkRange("link")
        .setLink({ href: url })
        .run();
}

const isLinked = ref(false);
function setLink2() {
    editor.chain().focus().unsetLink().run()
    isLinked.value = !isLinked.value;
}
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Name" />

                <div class="border-container bg-white">
                    <div class="border-container-bottom mb-2 h-10 flex flex-row items-centers">
                        <button :class="[isBold ? 'toolbar-btn-selected-bold' : 'toolbar-btn-bold']" type="button"
                            @click="setBold">
                            B
                        </button>
                        <button :class="[isItalic ? 'toolbar-btn-selected italic' : 'toolbar-btn italic']" type="button"
                            @click="setItalic">
                            K
                        </button>
                        <button :class="[isUnderline ? 'toolbar-btn-selected' : 'toolbar-btn']" type="button"
                            @click="setUnderline" aria-label="Subratllar">
                            U
                        </button>
                        <button class="toolbar-btn" type="button" @click="setLink" aria-label="Afegir enllaç">
                            <svg class="w-4 h-4 block m-auto" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button :class="[isLinked ? 'toolbar-btn-selected' : 'toolbar-btn']" type="button"
                            @click="setLink2">
                            <svg class="w-4 h-4 block m-auto" fill="currentColor" viewBox="0 0 54.971 54.971"
                                xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                <path
                                    d="M51.173,3.801c-5.068-5.068-13.315-5.066-18.384,0l-9.192,9.192c-0.781,0.781-0.781,2.047,0,2.828s2.047,0.781,2.828,0 l9.192-9.192c1.691-1.69,3.951-2.622,6.363-2.622c2.413,0,4.673,0.932,6.364,2.623s2.623,3.951,2.623,6.364 c0,2.412-0.932,4.672-2.623,6.363L36.325,31.379c-3.51,3.508-9.219,3.508-12.729,0c-0.781-0.781-2.047-0.781-2.828,0 s-0.781,2.048,0,2.828c2.534,2.534,5.863,3.801,9.192,3.801s6.658-1.267,9.192-3.801l12.021-12.021 c2.447-2.446,3.795-5.711,3.795-9.192C54.968,9.512,53.62,6.248,51.173,3.801z">
                                </path>
                                <path
                                    d="M27.132,40.57l-7.778,7.778c-1.691,1.691-3.951,2.623-6.364,2.623c-2.412,0-4.673-0.932-6.364-2.623 c-3.509-3.509-3.509-9.219,0-12.728L17.94,24.306c1.691-1.69,3.951-2.622,6.364-2.622c2.412,0,4.672,0.932,6.363,2.622 c0.781,0.781,2.047,0.781,2.828,0s0.781-2.047,0-2.828c-5.067-5.067-13.314-5.068-18.384,0L3.797,32.793 c-2.446,2.446-3.794,5.711-3.794,9.192c0,3.48,1.348,6.745,3.795,9.191c2.446,2.447,5.711,3.795,9.191,3.795 c3.481,0,6.746-1.348,9.192-3.795l7.778-7.778c0.781-0.781,0.781-2.047,0-2.828S27.913,39.789,27.132,40.57z">
                                </path>
                                <path
                                    d="M34.003,44.007c-1.104,0-2,0.896-2,2v6c0,1.104,0.896,2,2,2s2-0.896,2-2v-6C36.003,44.902,35.108,44.007,34.003,44.007z">
                                </path>
                                <path
                                    d="M41.175,42.593c-0.781-0.781-2.047-0.781-2.828,0s-0.781,2.047,0,2.828l4.242,4.242c0.391,0.391,0.902,0.586,1.414,0.586 s1.023-0.195,1.414-0.586c0.781-0.781,0.781-2.047,0-2.828L41.175,42.593z">
                                </path>
                                <path
                                    d="M45.968,36.007h-6c-1.104,0-2,0.896-2,2s0.896,2,2,2h6c1.104,0,2-0.896,2-2S47.073,36.007,45.968,36.007z">
                                </path>
                                <path
                                    d="M18.003,13.007c1.104,0,2-0.896,2-2v-6c0-1.104-0.896-2-2-2s-2,0.896-2,2v6C16.003,12.111,16.899,13.007,18.003,13.007z">
                                </path>
                                <path
                                    d="M10.589,14.421c0.391,0.391,0.902,0.586,1.414,0.586s1.023-0.195,1.414-0.586c0.781-0.781,0.781-2.047,0-2.828L9.175,7.35 c-0.781-0.781-2.047-0.781-2.828,0s-0.781,2.047,0,2.828L10.589,14.421z">
                                </path>
                                <path
                                    d="M5.968,21.007h6c1.104,0,2-0.896,2-2s-0.896-2-2-2h-6c-1.104,0-2,0.896-2,2S4.864,21.007,5.968,21.007z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <editor-content :editor="editor" class="m-4 text-sm" v-model="form.name" />
                </div>

            </div>

            <div>
                <InputLabel for="email" value="Email" />

                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                    autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800">
                    Your email address is unverified.
                    <Link :href="route('verification.send')" method="post" as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Click here to re-send the verification email.
                    </Link>
                </p>

                <div v-show="status === 'verification-link-sent'" class="mt-2 font-medium text-sm text-green-600">
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>


<style lang="postcss">
.toolbar-btn {
    @apply duration-100 ease-in-out hover:bg-red-500 hover:text-white active:bg-red-500 active:text-white w-10 h-10 mr-1;
}

.toolbar-btn-selected {
    @apply duration-100 ease-in-out bg-red-500 text-white w-10 h-10 mr-1;
}

.toolbar-btn-bold {
    @apply duration-100 ease-in-out hover:bg-red-500 hover:text-white active:bg-red-500 active:text-white w-10 h-10 mr-1 rounded-tl-md;
}

.toolbar-btn-selected-bold {
    @apply duration-100 ease-in-out bg-red-500 text-white w-10 h-10 mr-1 rounded-tl-md;
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
    min-height: 300px;
    max-height: 500px;
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