/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});


// var Tabulator = require('tabulator-tables');


$(document).ready( function () {

    // DATATABLE LIBRARY
    $('#myTable').DataTable({
        scrollY:400,
        scrollX: true,
        scrollCollapse: true,
        // paging: false
    });

    // SHOW/DECRYPT PASSWORD ON CLICK
    $(document).on('click', '.show-password', function() {

        const id = $(this).parent().siblings('.td-id').text();

        const that = $(this);

        $.ajax({
            url: '/decrypt-password',
            method: 'GET',
            data: {
                id: id
            },
            success: function(response) {
                const password = response;
                $(that).parent().siblings('.td-password').children('.password').text(password);
                $(that).hide();
                $(that).siblings('.hide-password').show();
            },
            error: function() {
                console.log('Errore!');
            }
        });
    });

    // HIDE PASSWORD ON CLICK
    $(document).on('click', '.hide-password', function() {
        $(this).hide();
        $(this).siblings('.show-password').show();
        const hiddenPassword = '&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;';
        $(this).parent().siblings('.td-password').children('.password').html(hiddenPassword);
    });

    // PROJECT INPUT AUTOCOMPLETE
    $('#project-input').keyup( function() {
        let query = $(this).val();
        if (query != '') {

            const _token = $('meta[name=csrf-token]').attr('content');
            $.ajax({
                url: '/autocomplete/fetch_projects',
                method: 'POST',
                data: {
                    query: query,
                    _token: _token
                },
                success: function(projects) {
                    if (projects.length != 0) {
                        // $('#projectList').fadeIn();
                        $('#projectList').show();
                        $('#projectList').empty();
                        projects.forEach((project) => {
                            $('#projectList').append(`<div class="project-result-item">${project.name}</div>`);
                        });
                    }
                },
                error: function() {
                    console.log('Errore!');
                }
            });
        } else {
            // $('#projectList').fadeOut();
            $('#projectList').hide();
            // setTimeout(() => { $('#projectList').empty() }, 1000); // per essere sicuri

        }
    });

    // Al click su un risultato inseriscilo nell'input e chiudi la lista dei risultati
    $(document).on('click', '.project-result-item', function() {
        $('#project-input').val($(this).text());
        $('#projectList').hide();
    });

    // Chiudi la lista dei risultati quando si clicca all'esterno di essa
    const projectInputContainer = document.getElementById('project-input-container');
    const serviceInputContainer = document.getElementById('service-input-container');

    document.addEventListener('click', function(event) {
        let isClickInsideProject = projectInputContainer.contains(event.target);
        let isClickInsideService = serviceInputContainer.contains(event.target);

        if (!isClickInsideProject) {
        $('#projectList').hide();
        }
        if (!isClickInsideService) {
        $('#serviceList').hide();
        }

    });

    // Chiudi la lista dei risultati quando si preme il tasto Tab
    document.addEventListener('keydown', function(event) {
        if (event.keyCode == 9) {
        document.querySelector('#projectList').style.display = "none";
        document.querySelector('#serviceList').style.display = "none";
        }
    });

    // SERVICE INPUT AUTOCOMPLETE
    $('#service-input').keyup( function() {
        let query = $(this).val();
        if (query != '') {

            const _token = $('meta[name=csrf-token]').attr('content');

            (async () => {
                const rawResponse = await fetch('/autocomplete/fetch_services/', {
                    method: 'POST',
                    headers: {
                      'Accept': 'application/json',
                      'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        query: query,
                        _token: _token
                    })
                });
                const services = await rawResponse.json();

                if (services.length != 0) {
                    $('#serviceList').show();
                    $('#serviceList').empty();
                    services.forEach((service) => {
                        $('#serviceList').append(`<div class="service-result-item">${service.name}</div>`);
                    });
                }
            })();
        } else {
            // $('#projectList').fadeOut();
            $('#serviceList').hide();
            // setTimeout(() => { $('#serviceList').empty() }, 1000); // per essere sicuri

        }
    });

    $(document).on('click', '.service-result-item', function() {
        $('#service-input').val($(this).text());
        // $('#projectList').fadeOut();
        $('#serviceList').hide();
    });

    // SHOW-HIDDEN PASWORD INPUT
    $('.eye-span').on('click', function () {
        if ($('#password-input').prop('type') == 'password') {
            $('#password-input').prop('type', 'text');
        } else {
            $('#password-input').prop('type', 'password');
        }
        $('.svg-closed-eye').toggle();
        $('.svg-open-eye').toggle();
    });

}); // END $(document).ready()
