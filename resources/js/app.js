import './bootstrap';
import { createApp, h } from 'vue'
import { app, plugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

const el = document.getElementById('app');
el.classList.add("h-full");

InertiaProgress.init({
  // The delay after which the progress bar will
  // appear during navigation, in milliseconds.
  delay: 250,

  // The color of the progress bar.
  color: '#29d',

  // Whether to include the default NProgress styles.
  includeCSS: true,

  // Whether the NProgress spinner will be shown.
  showSpinner: false,
});

const App = createApp({
    render: () => h(app , {
        initialPage: JSON.parse(el.dataset.page),
        resolveComponent: (name) =>
                import(`@/Pages/${name}`).then((module) => module.default),
    }),
})

App.use(plugin)

App.mixin({ methods: { route } })

const vm = App.mount(el);
