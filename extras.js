$("#site_title").hover(function() {
  $('#site_title').addClass('animated pulse');
}, function() {
  $('#site_title').removeClass('animated pulse');
});

function calcAge(a) {
  var date = +new Date(a);
  var age = (Date.now() - date) / (31557600000);
  var rounded = age.toFixed(7);
  document.getElementById('calcAge').innerHTML=rounded.replace(".",",");
}
