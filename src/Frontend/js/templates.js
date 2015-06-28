var dir = 'src/Frontend/templates/';

function loadScoreboard() {
  $.get(dir + 'scoreboard.mst', function(template) {
    var rendered = Mustache.render(template, {test: ''});
    $('#target').html(rendered);
  });
}