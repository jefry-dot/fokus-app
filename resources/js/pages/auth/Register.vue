<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{ }>();

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <AuthBase>
    <Head title="Register" />

    <!-- Fullscreen animated gradient background -->
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-950 via-gray-900 to-black p-4 animate-gradient">
      <!-- Glassmorphic form container -->
      <div class="w-full max-w-md bg-white/5 backdrop-blur-lg border border-white/10 rounded-2xl shadow-2xl p-8 animate-slide-fade relative overflow-hidden">
        <!-- Subtle SVG pattern overlay -->
        <div class="absolute inset-0 opacity-10 [mask-image:linear-gradient(transparent,#000,transparent)]">
          <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2ZmZiIvPjxwYXRoIGQ9Ik0xMDAgMEwwIDEwMEgxMDBWMHpNMjAwIDEwMEwxMDAgMjAwVjEwMEgyMDB6TTAgMTAwbDEwMCAxMDBWMTAwSDB6IiBmaWxsLW9wYWNpdHk9Ii4wNSIvPjwvc3ZnPg==')]"></div>
        </div>

        <div class="relative z-10">
          <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-300 text-center mb-3">
            Create Your Account
          </h2>
          <p class="text-sm text-gray-400 text-center mb-6">
            Enter your details below to get started
          </p>

          <form @submit.prevent="submit" class="space-y-6">
            <div class="space-y-5">
              <!-- Name -->
              <div class="group">
                <Label for="name" class="text-gray-300 text-sm font-medium mb-2 block">Full Name</Label>
                <Input
                  id="name"
                  type="text"
                  required
                  autofocus
                  v-model="form.name"
                  placeholder="Your full name"
                  class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg placeholder-gray-500 text-gray-200 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 shadow-sm"
                />
                <InputError :message="form.errors.name" class="mt-1" />
              </div>

              <!-- Email -->
              <div class="group">
                <Label for="email" class="text-gray-300 text-sm font-medium mb-2 block">Email Address</Label>
                <Input
                  id="email"
                  type="email"
                  required
                  v-model="form.email"
                  placeholder="you@example.com"
                  class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg placeholder-gray-500 text-gray-200 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 shadow-sm"
                />
                <InputError :message="form.errors.email" class="mt-1" />
              </div>

              <!-- Password -->
              <div class="group">
                <Label for="password" class="text-gray-300 text-sm font-medium mb-2 block">Password</Label>
                <Input
                  id="password"
                  type="password"
                  required
                  v-model="form.password"
                  placeholder="••••••••"
                  class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg placeholder-gray-500 text-gray-200 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 shadow-sm"
                />
                <InputError :message="form.errors.password" class="mt-1" />
              </div>

              <!-- Confirm Password -->
              <div class="group">
                <Label for="password_confirmation" class="text-gray-300 text-sm font-medium mb-2 block">Confirm Password</Label>
                <Input
                  id="password_confirmation"
                  type="password"
                  required
                  v-model="form.password_confirmation"
                  placeholder="••••••••"
                  class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg placeholder-gray-500 text-gray-200 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 shadow-sm"
                />
                <InputError :message="form.errors.password_confirmation" class="mt-1" />
              </div>
            </div>

            <!-- Submit -->
            <Button
              type="submit"
              class="w-full py-3.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 transition-all duration-300 text-lg font-semibold rounded-[10px] shadow-lg hover:shadow-indigo-500/20 relative overflow-hidden"
              :disabled="form.processing"
            >
              <div class="absolute inset-0 bg-white/10 opacity-0 hover:opacity-10 transition-opacity"></div>
              <LoaderCircle v-if="form.processing" class="h-5 w-5 animate-spin mr-2" />
              <span>{{ form.processing ? 'Creating...' : 'Create Account' }}</span>
            </Button>
          </form>

          <p class="mt-8 text-center text-sm text-gray-500">
            Already have an account?
            <TextLink :href="route('login')" class="text-indigo-400 hover:text-indigo-300 font-medium ml-1.5 transition-colors duration-200">
              Log in
            </TextLink>
          </p>
        </div>
      </div>
    </div>
  </AuthBase>
</template>

<style scoped>
@keyframes slide-fade {
  0% { opacity: 0; transform: translateY(20px); }
  100% { opacity: 1; transform: translateY(0); }
}

@keyframes gradient {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

.animate-slide-fade {
  animation: slide-fade 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
}

.animate-gradient {
  animation: gradient 10s ease infinite;
  background-size: 200% 200%;
}
</style>
