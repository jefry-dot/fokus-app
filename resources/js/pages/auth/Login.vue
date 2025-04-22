<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{ status?: string; canResetPassword: boolean }>();

const form = useForm({ email: '', password: '', remember: false });
const submit = () => {
  form.post(route('login'), { onFinish: () => form.reset('password') });
};
</script>

<template>
  <AuthBase>
    <Head title="Log in" />

    <!-- Background gradient + card container -->
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-900 via-gray-900 to-black p-4">
      <div class="w-full max-w-md bg-white/10 backdrop-blur-md rounded-2xl shadow-xl p-8 animate-slide-fade">
        <h2 class="text-2xl font-semibold text-white text-center mb-6">Log in to your account</h2>
        <p class="text-sm text-gray-300 text-center mb-6">Enter your email and password below to log in</p>

        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-400">
          {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-5">
          <div class="space-y-4">
            <div class="flex flex-col">
              <Label for="email" class="text-gray-200">Email Address</Label>
              <Input
                id="email"
                type="email"
                required
                autofocus
                v-model="form.email"
                placeholder="you@example.com"
                class="mt-1 bg-white/20 placeholder-gray-400 text-white focus:ring-indigo-500 focus:border-indigo-500"
              />
              <InputError :message="form.errors.email" class="mt-1" />
            </div>

            <div class="flex flex-col">
              <div class="flex justify-between items-center">
                <Label for="password" class="text-gray-200">Password</Label>
                <TextLink
                  v-if="canResetPassword"
                  :href="route('password.request')"
                  class="text-sm text-indigo-300 hover:text-indigo-100"
                >
                  Forgot password?
                </TextLink>
              </div>
              <Input
                id="password"
                type="password"
                required
                v-model="form.password"
                placeholder="********"
                class="mt-1 bg-white/20 placeholder-gray-400 text-white focus:ring-indigo-500 focus:border-indigo-500"
              />
              <InputError :message="form.errors.password" class="mt-1" />
            </div>

            <label class="flex items-center space-x-2 text-gray-200">
              <Checkbox v-model="form.remember" />
              <span>Remember me</span>
            </label>
          </div>

          <Button
            type="submit"
            class="w-full mt-2 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 transition-all duration-300 text-lg font-medium rounded-xl shadow-lg"
            :disabled="form.processing"
          >
            <LoaderCircle v-if="form.processing" class="h-5 w-5 animate-spin mr-2" />
            <span v-if="!form.processing">Log in</span>
            <span v-else>Processing...</span>
          </Button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-400">
          Don’t have an account?
          <TextLink :href="route('register')" class="text-indigo-300 hover:text-indigo-100 font-medium ml-1">Sign up</TextLink>
        </p>
      </div>
    </div>
  </AuthBase>
</template>

<style scoped>
@keyframes slide-fade {
  0% { opacity: 0; transform: translateY(20px); }
  100% { opacity: 1; transform: translateY(0); }
}
.animate-slide-fade {
  animation: slide-fade 0.6s ease-out forwards;
}
</style>
