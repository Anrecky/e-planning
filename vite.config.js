import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import { hash } from './resources/js/fn.js';

export default defineConfig({
    plugins: [
        laravel({
            input: [

                /**
                 * ================================
                 *      Will Config images Files
                 * =================================
                 */
                'resources/js/app.js',

                /**
                 * =======================
                 *      Assets Files
                 * =======================
                 */

                // Loader
                'resources/scss/layouts/modern-light-menu/light/loader.scss',
                'resources/layouts/modern-light-menu/loader.js',
                'resources/layouts/modern-dark-menu/loader.js',
                'resources/layouts/collapsible-menu/loader.js',
                'resources/layouts/horizontal-light-menu/loader.js',
                'resources/layouts/horizontal-dark-menu/loader.js',

                // Structure

                // Modern Light Menu
                'resources/scss/layouts/modern-light-menu/light/structure.scss',
                'resources/scss/layouts/modern-light-menu/dark/structure.scss',

                // Modern Dark Menu
                'resources/scss/layouts/modern-dark-menu/light/structure.scss',
                'resources/scss/layouts/modern-dark-menu/dark/structure.scss',

                // Collapsible Menu
                'resources/scss/layouts/collapsible-menu/light/structure.scss',
                'resources/scss/layouts/collapsible-menu/dark/structure.scss',

                // Horizontal Light Menu
                'resources/scss/layouts/horizontal-light-menu/light/structure.scss',
                'resources/scss/layouts/horizontal-light-menu/dark/structure.scss',

                // Horizontal Dark Menu
                'resources/scss/layouts/horizontal-dark-menu/light/structure.scss',
                'resources/scss/layouts/horizontal-dark-menu/dark/structure.scss',



                // Main
                'resources/scss/light/assets/main.scss',
                'resources/scss/dark/assets/main.scss',

                // Secondary Files
                'resources/scss/light/assets/scrollspyNav.scss',
                'resources/scss/light/assets/custom.scss',

                'resources/scss/dark/assets/scrollspyNav.scss',
                'resources/scss/dark/assets/custom.scss',

                // Assets Files

                /**
                 * Light
                 */

                // --- Apps
                'resources/scss/light/assets/apps/blog-create.scss',
                'resources/scss/light/assets/apps/blog-post.scss',
                'resources/scss/light/assets/apps/chat.scss',
                'resources/scss/light/assets/apps/contacts.scss',
                'resources/scss/light/assets/apps/ecommerce-create.scss',
                'resources/scss/light/assets/apps/ecommerce-details.scss',
                'resources/scss/light/assets/apps/invoice-add.scss',
                'resources/scss/light/assets/apps/invoice-edit.scss',
                'resources/scss/light/assets/apps/invoice-list.scss',
                'resources/scss/light/assets/apps/invoice-preview.scss',
                'resources/scss/light/assets/apps/mailbox.scss',
                'resources/scss/light/assets/apps/notes.scss',
                'resources/scss/light/assets/apps/scrumboard.scss',
                'resources/scss/light/assets/apps/todolist.scss',

                // --- Authentication
                'resources/scss/light/assets/authentication/auth-boxed.scss',
                'resources/scss/light/assets/authentication/auth-cover.scss',


                // --- Componenets
                'resources/scss/light/assets/components/accordions.scss',
                'resources/scss/light/assets/components/carousel.scss',
                'resources/scss/light/assets/components/flags.scss',
                'resources/scss/light/assets/components/font-icons.scss',
                'resources/scss/light/assets/components/list-group.scss',
                'resources/scss/light/assets/components/media_object.scss',
                'resources/scss/light/assets/components/modal.scss',
                'resources/scss/light/assets/components/tabs.scss',
                'resources/scss/light/assets/components/timeline.scss',

                // --- Dashbaord
                'resources/scss/light/assets/dashboard/dash_1.scss',
                'resources/scss/light/assets/dashboard/dash_2.scss',

                // --- Elements
                'resources/scss/light/assets/elements/alert.scss',
                'resources/scss/light/assets/elements/color_library.scss',
                'resources/scss/light/assets/elements/custom-pagination.scss',
                'resources/scss/light/assets/elements/custom-tree_view.scss',
                'resources/scss/light/assets/elements/custom-typography.scss',
                'resources/scss/light/assets/elements/infobox.scss',
                'resources/scss/light/assets/elements/popover.scss',
                'resources/scss/light/assets/elements/search.scss',
                'resources/scss/light/assets/elements/tooltip.scss',


                // --- Forms
                'resources/scss/light/assets/forms/switches.scss',

                // --- Pages
                'resources/scss/light/assets/pages/contact_us.scss',
                'resources/scss/light/assets/pages/faq.scss',
                'resources/scss/light/assets/pages/knowledge_base.scss',
                'resources/scss/light/assets/pages/error/error.scss',
                'resources/scss/light/assets/pages/error/style-maintanence.scss',


                // --- Users
                'resources/scss/light/assets/users/account-setting.scss',
                'resources/scss/light/assets/users/user-profile.scss',


                // --- Widgets
                'resources/scss/light/assets/widgets/modules-widgets.scss',

                /**
                 * Dark
                 */

                // --- Apps
                'resources/scss/dark/assets/apps/blog-create.scss',
                'resources/scss/dark/assets/apps/blog-post.scss',
                'resources/scss/dark/assets/apps/chat.scss',
                'resources/scss/dark/assets/apps/contacts.scss',
                'resources/scss/dark/assets/apps/ecommerce-create.scss',
                'resources/scss/dark/assets/apps/ecommerce-details.scss',
                'resources/scss/dark/assets/apps/invoice-add.scss',
                'resources/scss/dark/assets/apps/invoice-edit.scss',
                'resources/scss/dark/assets/apps/invoice-list.scss',
                'resources/scss/dark/assets/apps/invoice-preview.scss',
                'resources/scss/dark/assets/apps/mailbox.scss',
                'resources/scss/dark/assets/apps/notes.scss',
                'resources/scss/dark/assets/apps/scrumboard.scss',
                'resources/scss/dark/assets/apps/todolist.scss',

                // --- Authentication
                'resources/scss/dark/assets/authentication/auth-boxed.scss',
                'resources/scss/dark/assets/authentication/auth-cover.scss',


                // --- Componenets
                'resources/scss/dark/assets/components/accordions.scss',
                'resources/scss/dark/assets/components/carousel.scss',
                'resources/scss/dark/assets/components/flags.scss',
                'resources/scss/dark/assets/components/font-icons.scss',
                'resources/scss/dark/assets/components/list-group.scss',
                'resources/scss/dark/assets/components/media_object.scss',
                'resources/scss/dark/assets/components/modal.scss',
                'resources/scss/dark/assets/components/tabs.scss',
                'resources/scss/dark/assets/components/timeline.scss',

                // --- Dashbaord
                'resources/scss/dark/assets/dashboard/dash_1.scss',
                'resources/scss/dark/assets/dashboard/dash_2.scss',

                // --- Elements
                'resources/scss/dark/assets/elements/alert.scss',
                'resources/scss/dark/assets/elements/color_library.scss',
                'resources/scss/dark/assets/elements/custom-pagination.scss',
                'resources/scss/dark/assets/elements/custom-tree_view.scss',
                'resources/scss/dark/assets/elements/custom-typography.scss',
                'resources/scss/dark/assets/elements/infobox.scss',
                'resources/scss/dark/assets/elements/popover.scss',
                'resources/scss/dark/assets/elements/search.scss',
                'resources/scss/dark/assets/elements/tooltip.scss',


                // --- Forms
                'resources/scss/dark/assets/forms/switches.scss',

                // --- Pages
                'resources/scss/dark/assets/pages/contact_us.scss',
                'resources/scss/dark/assets/pages/faq.scss',
                'resources/scss/dark/assets/pages/knowledge_base.scss',
                'resources/scss/dark/assets/pages/error/error.scss',
                'resources/scss/dark/assets/pages/error/style-maintanence.scss',


                // --- Users
                'resources/scss/dark/assets/users/account-setting.scss',
                'resources/scss/dark/assets/users/user-profile.scss',


                // --- Widgets
                'resources/scss/dark/assets/widgets/modules-widgets.scss',





                /**
                 * =======================
                 *      Assets JS Files
                 * =======================
                 */

                // Outer Files
                'resources/assets/js/custom.js',
                'resources/assets/js/scrollspyNav.js',

                // APPS
                'resources/assets/js/apps/blog-create.js',
                'resources/assets/js/apps/chat.js',
                'resources/assets/js/apps/contact.js',
                'resources/assets/js/apps/ecommerce-create.js',
                'resources/assets/js/apps/ecommerce-details.js',
                'resources/assets/js/apps/invoice-add.js',
                'resources/assets/js/apps/invoice-edit.js',
                'resources/assets/js/apps/invoice-list.js',
                'resources/assets/js/apps/invoice-preview.js',
                'resources/assets/js/apps/mailbox.js',
                'resources/assets/js/apps/notes.js',
                'resources/assets/js/apps/scrumboard.js',
                'resources/assets/js/apps/todoList.js',

                // Auth
                'resources/assets/js/authentication/auth-cover.js',
                'resources/assets/js/authentication/form-2.js',
                'resources/assets/js/authentication/2-Step-Verification.js',

                // Components
                'resources/assets/js/components/notification/custom-snackbar.js',
                'resources/assets/js/components/custom-carousel.js',

                // Dashboard
                'resources/assets/js/dashboard/dash_1.js',
                'resources/assets/js/dashboard/dash_2.js',


                // Elements
                'resources/assets/js/elements/popovers.js',
                'resources/assets/js/elements/custom-search.js',
                'resources/assets/js/elements/tooltip.js',

                // Forms
                'resources/assets/js/forms/bootstrap_validation/bs_validation_script.js',
                'resources/assets/js/forms/custom-clipboard.js',

                // Pages
                'resources/assets/js/pages/faq.js',
                'resources/assets/js/pages/knowledge-base.js',

                // Users
                'resources/assets/js/users/account-settings.js',

                // Widget
                'resources/assets/js/widgets/modules-widgets.js',

                'resources/assets/js/widgets/_wSix.js',
                'resources/assets/js/widgets/_wChartThree.js',
                'resources/assets/js/widgets/_wHybridOne.js',
                'resources/assets/js/widgets/_wActivityFive.js',

                'resources/assets/js/widgets/_wTwo.js',
                'resources/assets/js/widgets/_wOne.js',
                'resources/assets/js/widgets/_wChartOne.js',
                'resources/assets/js/widgets/_wChartTwo.js',
                'resources/assets/js/widgets/_wActivityFour.js',




                /**
                 * =======================
                 *      Plugins Files
                 * =======================
                 */

                // Importing All the Plugin Custom SCSS File ( plugins.min.scss contains all the custom SCSS/CSS. )
                // 'resources/scss/light/plugins/plugins.min.scss',

                /**
                 * Light
                 */

                'resources/scss/light/plugins/apex/custom-apexcharts.scss',
                'resources/scss/light/plugins/autocomplete/css/custom-autoComplete.scss',
                'resources/scss/light/plugins/bootstrap-range-Slider/bootstrap-slider.scss',
                'resources/scss/light/plugins/bootstrap-touchspin/custom-jquery.bootstrap-touchspin.min.scss',
                'resources/scss/light/plugins/clipboard/custom-clipboard.scss',
                'resources/scss/light/plugins/drag-and-drop/dragula/example.scss',
                'resources/scss/light/plugins/editors/markdown/simplemde.min.scss',
                'resources/scss/light/plugins/editors/quill/quill.snow.scss',
                'resources/scss/light/plugins/filepond/custom-filepond.scss',
                'resources/scss/light/plugins/flatpickr/custom-flatpickr.scss',
                'resources/scss/light/plugins/fullcalendar/custom-fullcalendar.scss',
                'resources/scss/light/plugins/loaders/custom-loader.scss',
                'resources/scss/light/plugins/notification/snackbar/custom-snackbar.scss',
                'resources/scss/light/plugins/noUiSlider/custom-nouiSlider.scss',
                'resources/scss/light/plugins/perfect-scrollbar/perfect-scrollbar.scss',
                'resources/scss/light/plugins/pricing-table/css/component.scss',
                'resources/scss/light/plugins/splide/custom-splide.min.scss',
                'resources/scss/light/plugins/stepper/custom-bsStepper.scss',
                'resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss',
                'resources/scss/light/plugins/table/datatable/dt-global_style.scss',
                'resources/scss/light/plugins/table/datatable/custom_dt_custom.scss',
                'resources/scss/light/plugins/table/datatable/custom_dt_miscellaneous.scss',
                'resources/scss/light/plugins/tagify/custom-tagify.scss',
                'resources/scss/light/plugins/tomSelect/custom-tomSelect.scss',

                /**
                 * Dark
                 */

                'resources/scss/dark/plugins/apex/custom-apexcharts.scss',
                'resources/scss/dark/plugins/autocomplete/css/custom-autoComplete.scss',
                'resources/scss/dark/plugins/bootstrap-range-Slider/bootstrap-slider.scss',
                'resources/scss/dark/plugins/bootstrap-touchspin/custom-jquery.bootstrap-touchspin.min.scss',
                'resources/scss/dark/plugins/clipboard/custom-clipboard.scss',
                'resources/scss/dark/plugins/drag-and-drop/dragula/example.scss',
                'resources/scss/dark/plugins/editors/markdown/simplemde.min.scss',
                'resources/scss/dark/plugins/editors/quill/quill.snow.scss',
                'resources/scss/dark/plugins/filepond/custom-filepond.scss',
                'resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss',
                'resources/scss/dark/plugins/fullcalendar/custom-fullcalendar.scss',
                'resources/scss/dark/plugins/loaders/custom-loader.scss',
                'resources/scss/dark/plugins/notification/snackbar/custom-snackbar.scss',
                'resources/scss/dark/plugins/noUiSlider/custom-nouiSlider.scss',
                'resources/scss/dark/plugins/perfect-scrollbar/perfect-scrollbar.scss',
                'resources/scss/dark/plugins/pricing-table/css/component.scss',
                'resources/scss/dark/plugins/splide/custom-splide.min.scss',
                'resources/scss/dark/plugins/stepper/custom-bsStepper.scss',
                'resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss',
                'resources/scss/dark/plugins/table/datatable/dt-global_style.scss',
                'resources/scss/dark/plugins/table/datatable/custom_dt_custom.scss',
                'resources/scss/dark/plugins/table/datatable/custom_dt_miscellaneous.scss',
                'resources/scss/dark/plugins/tagify/custom-tagify.scss',
                'resources/scss/dark/plugins/tomSelect/custom-tomSelect.scss',

                'resources/assets/js/scrollspyNav.js',

                'resources/layouts/modern-light-menu/app.js',
                'resources/layouts/modern-dark-menu/app.js',
                'resources/layouts/collapsible-menu/app.js',
                'resources/layouts/horizontal-light-menu/app.js',
                'resources/layouts/horizontal-dark-menu/app.js',


                /**
                 * =======================
                 *      Assets JS Files
                 * =======================
                 */


                /**
                 * =======================
                 *      Plugins Files
                 * =======================
                 */

                // Importing All the Plugin Custom SCSS File ( plugins.min.scss contains all the custom SCSS/CSS. )
                // 'resources/rtl/scss/light/plugins/plugins.min.scss',

            ],
            refresh: true,
        }),
    ],
    // build: {
    //     rollupOptions: {
    //       output: {
    //         assetFileNames: (assetInfo) => {
    //           let extType = assetInfo.name.split('.').at(1);
    //           if (/png|jpe?g|svg|gif|tiff|bmp|ico/i.test(extType)) {
    //             extType = 'img';
    //           }
    //           return `assets/${extType}/[name]-[hash][extname]`;
    //         },
    //         chunkFileNames: 'assets/js/[name]-[hash].js',
    //         entryFileNames: 'assets/js/[name]-[hash].js',
    //       },
    //     },
    //   },
    // build: {
    //     rollupOptions: {
    //         output: {
    //             entryFileNames: `[name]` + hash + `.js`,
    //             chunkFileNames: `[name]` + hash + `.js`,
    //             assetFileNames: `[name]` + hash + `.[ext]`
    //         }
    //     }
    // }

    // resolve: {
    //     alias: {
    //         // '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap')
    //         '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap/dist/css/bootstrap.min.css'),
    //         '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js')
    //     }
    // }
});
