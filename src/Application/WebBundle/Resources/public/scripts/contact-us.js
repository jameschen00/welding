var ContactUs = function () {

    return {
        //main function to initiate the module
        init: function (title,content) {
            var map;
            $(document).ready(function () {
                map = new GMaps({
                    div: '#map',
                    lat: 50.082551,
                    lng: 29.930149
                });

                var marker = map.addMarker({
                    lat: 50.082551,
                    lng: 29.930149,
                    title: title,
                    infoWindow: {
                        content: content
                    }
                });

                marker.infoWindow.open(map, marker);
            });
        }
    };

}();