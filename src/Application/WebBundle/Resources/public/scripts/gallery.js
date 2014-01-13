var Gallery = function () {


    return {
        //main function to initiate the module
        init: function (selected) {
            $('.mix-grid').mixitup();

            if (selected) {
                Gallery.openImage(selected)
            }
        },

        /**
         * Open image
         *
         * @param int selected
         */
        openImage : function (selected) {
            $('a[data-id="'+selected+'"]').click();
        }
    };

}();