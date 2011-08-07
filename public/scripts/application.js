$(document).ready(function() {
  // height of map window
  $('#layout #map').height($(window).height()-100);
  $('#layout #tweets').height($(window).height()-100);

  var myOptions = {
    zoom: 8,
    center: createGLatLng($('#map-center').val()),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  var map = new google.maps.Map(document.getElementById("map"), myOptions);

  $('#tweets li input:hidden').each(function(){
      position = createGLatLng($(this).val());
      title = $(this).parent().find('label').html()
      content = '<h1>' + title + '</h1>' + $(this).parent().find('p').html();
      var marker = new google.maps.Marker({
        map: map,
        position: position,
        title: title
      });

      var infowindow = new google.maps.InfoWindow({
        content: content
      });
      google.maps.event.addListener(marker, 'click', function() {
        infowindow.open(map, marker);
      });
  });

});


function createGLatLng(location)
{
    LatLong = location.split(/x/)
    lat = LatLong[0];
    long = LatLong[1];
    return new google.maps.LatLng(lat, long);
}

