function findLastItem(a) {
  var count = 0;
  var i;
  var j;

  for (i in a) {
      if (a.hasOwnProperty(i)) {
          j=i;
      }
  }
  return j;
}


function menu(name,currPage,animate) {
  var items = ["main","articles","projects"];

  if ($.inArray(name,items)>-1) {

    if (animate==true) {
      $('#main_navbar').addClass('animated fadeOut');
      $('#main_navbar').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {

        $.getJSON("menu.php", function(json) {
          var result = "";

          $.each(json[name], function(key,data) {
            var menuObject = json[name];

            if (key==currPage) {
              /* "+data+" */
              result+="<li><a href=\"#\" class=\"link active\" data-location=\""+key+"\">"+key+"</a></li>";
            }
            else if (key!=findLastItem(menuObject)) {
              result+="<li><a href=\""+data+"\" class=\"link\" data-location=\""+key+"\">"+key+"</a></li>";
            }
            else {
              var loc;
              if (key=='retour') { loc='main'; }
              else { loc=key; }
              result+="<li class=\"nav_lastitem\"><a href=\""+data+"\" class=\"link\" data-location=\""+loc+"\">"+key+"</a></li>";
            }

          });

        $('#main_navbar').html('<ul>'+result+'</ul>');
        $('#main_navbar').removeClass('animated fadeOut');//flipOutX
        $('#main_navbar').addClass('animated fadeIn');

        });
      });
      return true;
    }

    else {
      $.getJSON("menu.php", function(json) {
        var result = "";

        $.each(json[name], function(key,data) {
          var menuObject = json[name];

          if (key==currPage) {
            /* "+data+" */
            result+="<li><a href=\"#\" class=\"link active\" data-location=\""+key+"\">"+key+"</a></li>";
          }
          else if (key!=findLastItem(menuObject)) {
            result+="<li><a href=\""+data+"\" class=\"link\" data-location=\""+key+"\">"+key+"</a></li>";
          }
          else {
            var loc;
            if (key=='retour') { loc='main'; }
            else { loc=key; }
            result+="<li class=\"nav_lastitem\"><a href=\""+data+"\" class=\"link\" data-location=\""+loc+"\">"+key+"</a></li>";
          }

        });

      $('#main_navbar').html('<ul>'+result+'</ul>');

    });
      return true;
    }
  }
  else {
    return false
  }
}

$(document).ready(function() {
    $.ajaxSetup({ cache: false });
});
