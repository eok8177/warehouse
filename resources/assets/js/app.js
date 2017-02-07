
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example', require('./components/Example.vue'));

// const app = new Vue({
//     el: '#app'
// });

$(function () {

  $('[data-toggle="tooltip"]').tooltip();
  $('[data-toggle="modal"]').tooltip();

  $('.ajax').on('click', function(e){
    var modal =  $($(this).data('target'));
    $.ajax({
      type: "GET",
      url: $(this).attr('href'),
      dataType: 'json',
      success: function(data)
      {
        modal.html(data.html);
      },
      error: function(data)
      {
        modal.html("<p>"+$.parseJSON(data.responseText).title[0]);
      }
    });
    e.preventDefault();
  });
});