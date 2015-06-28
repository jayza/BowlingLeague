/**
 * This file contains the templates that are going to be rendered
 * by Mustache.js.
 */

// Template directory from root folder.
var dir = 'src/Frontend/templates/';

function loadScoreboard() {
  var json;
  $.get('scoreboard.php', function(data) {
    json = data;
    $.get(dir + 'scoreboard.mst', function(template) {
      console.log(JSON.parse(json));
      var rendered = Mustache.render(template, {scoreboard: JSON.parse(json)});
      $('#target').html(rendered);
    });
  });
}