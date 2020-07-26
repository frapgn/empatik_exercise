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


// DECRYPT PASSWORD ON CLICK
$(document).on('click', '.decrypt-password', function() {

    const id = $(this).parent().siblings('.id').text();

    const that = $(this);

    $.ajax({
        url: '/decrypt-password',
        method: 'GET',
        data: {
            id: id
        },
        success: function(response) {
            const password = response;
            $(that).siblings('.password').text(password);

        },
        error: function() {
            console.log('Errore!');
        }
    });
});

// AUTOCOMPLETE
$('#project-input').keyup( function() {
    let query = $(this).val();
    if (query != '') {

        const _token = $('meta[name=csrf-token]').attr('content');
        $.ajax({
            url: '/autocomplete/fetch',
            method: 'POST',
            data: {
                query: query,
                _token: _token
            },
            success: function(projects) {
                $('#projectList').fadeIn();
                $('#projectList').empty();
                projects.forEach((project) => {
                    $('#projectList').append(`<div class="result-item">${project.name}</div>`);
                });


            },
            error: function() {
                console.log('Errore!');
            }
        });
    } else {
        $('#projectList').fadeOut();
        setTimeout(() => { $('#projectList').empty() }, 2000);

    }
});

// al click su un risultato inseriscilo nell'input e chiudi la lista dei risultati
$(document).on('click', '.result-item', function() {
    $('#project-input').val($(this).text());
    $('#projectList').fadeOut();
});

// chiudi la lista dei risultati quando si clicca all'esterno di essa
var specifiedElement = document.getElementById('projectList');

document.addEventListener('click', function(event) {
  var isClickInside = specifiedElement.contains(event.target);

  if (!isClickInside) {
    $('#projectList').fadeOut();
  }
});
