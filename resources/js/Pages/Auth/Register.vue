<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <jet-label for="name" value="Name" />
                <jet-input
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
            </div>

            <div class="mt-4">
                <jet-label for="email" value="Email" />
                <jet-input
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                />
            </div>

            <div class="mt-4">
                <jet-label for="password" value="Password" />
                <jet-input
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />
            </div>

            <div class="mt-4">
                <jet-label
                    for="password_confirmation"
                    value="Confirm Password"
                />
                <jet-input
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />
            </div>

            <div
                class="mt-4"
                v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature"
            >
                <jet-label for="terms">
                    <div class="flex items-center">
                        <jet-checkbox
                            name="terms"
                            id="terms"
                            v-model="form.terms"
                        />

                        <div class="ml-2">
                            I agree to the
                            <a
                                target="_blank"
                                :href="route('terms.show')"
                                class="underline text-sm text-gray-600 hover:text-gray-900"
                                >Terms of Service</a
                            >
                            and
                            <a
                                target="_blank"
                                :href="route('policy.show')"
                                class="underline text-sm text-gray-600 hover:text-gray-900"
                                >Privacy Policy</a
                            >
                        </div>
                    </div>
                </jet-label>
            </div>

            <input
                type="hidden"
                name="recaptcha_token"
                id="recaptcha_token"
                :value="form.recaptcha_token"
            />

            <div class="flex items-center justify-end mt-4">
                <inertia-link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900"
                >
                    Already registered?
                </inertia-link>

                <jet-button
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </jet-button>
            </div>
        </form>
        <template #footer>
            <div class="text-xs">
                This site is protected by reCAPTCHA and the Google
                <a href="https://policies.google.com/privacy">Privacy Policy</a>
                and
                <a href="https://policies.google.com/terms">Terms of Service</a>
                apply.
            </div>
        </template>
    </jet-authentication-card>
</template>

<script>
import JetAuthenticationCard from "@/Jetstream/AuthenticationCard";
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo";
import JetButton from "@/Jetstream/Button";
import JetInput from "@/Jetstream/Input";
import JetCheckbox from "@/Jetstream/Checkbox";
import JetLabel from "@/Jetstream/Label";
import JetValidationErrors from "@/Jetstream/ValidationErrors";
import { useForm } from "@inertiajs/inertia-vue3";
import { load } from "recaptcha-v3";

export default {
    components: {
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        JetButton,
        JetInput,
        JetCheckbox,
        JetLabel,
        JetValidationErrors,
    },
    setup() {
        const form = useForm({
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            recaptcha_token: "",
            terms: false,
        });

        return { form };
    },
    created() {
        this.loadCaptcha();
    },
    methods: {
        submit(e) {
            this.form.post(this.route("register"), {
                onFinish: () => {
                    this.form.reset("password", "password_confirmation"),
                        this.loadCaptcha();
                },
            });
        },
        loadCaptcha() {
            const _self = this;
            load(process.env.MIX_GOOGLE_RECAPTCHA_SITE_KEY).then(
                (recaptcha) => {
                    recaptcha
                        .execute(() => {})
                        .then((token) => {
                            _self.form.recaptcha_token = token;
                        });
                }
            );
        },
    },
};
</script>

<style>
.grecaptcha-badge {
    visibility: hidden;
}
</style>
