<template>
    <li class="flex">
                    <button class="rounded-md focus:outline-none focus:shadow-outline-purple" @click="toggleTheme"
                        aria-label="Toggle color mode">
                        <template v-if="theme === 'dark'">
                          <Icon name="sun" class="h-5 w-5" />
                        </template>
                        <template v-if="theme === 'light'">    
                          <Icon name="moon" class="h-5 w-5" />
                        </template>
                    </button>
                </li>
</template>
<script setup>
    import { ref, onMounted } from 'vue'
    import Icon from '@/Shared/Icon.vue'

    const theme = ref('')

    onMounted(() => {
        const userPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
        const defaultTheme = userPrefersDark ? 'dark' : 'light'
        theme.value = localStorage.getItem('theme') || defaultTheme
        setTheme(theme.value)
    })

    const toggleTheme = () => {
        const newTheme = theme.value === 'light' ? 'dark' : 'light'
        setTheme(newTheme)
    }
    
    const setTheme = (newTheme) => {
        theme.value = newTheme
        if (theme.value === 'dark') {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
        localStorage.setItem('theme', newTheme)
    }
</script>