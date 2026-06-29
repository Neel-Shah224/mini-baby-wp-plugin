jQuery(function ($) {

    console.log("Custom AJAX Shop Loaded");

    window.loadProducts = function(category = "") {

        $("#cas-product-grid").html(
            '<div class="cas-loading">Loading...</div>'
        );

        $.ajax({
            url: cas_ajax.ajax_url,
            type: "POST",
            data: {
                action: "cas_load_products",
                nonce: cas_ajax.nonce,
                category: category
            },
            success: function(response){
console.log("response1234:", response);
                if(response.success){
                    console.log("response", response.data.html);

                    $("#cas-product-grid").html(
                        response.data.html
                    );

                }

            }
        });

    }

    // Listen for category changes
    $(document).on("cas_category_changed", function(e, category){

        loadProducts(category);

    });

    // Initial load
    loadProducts("");

});