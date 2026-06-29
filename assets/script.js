jQuery(function ($) {
  console.log("Custom AJAX Shop Loaded");

  window.casState = {
    category: "",
    search: "",
    page: 1,
  };

  window.loadProducts = function (state) {
    $("#cas-product-grid").html('<div class="cas-loading">Loading...</div>');

    if (typeof state === "string") {
      casState.category = state;
    } else {
      casState = state;
    }

    $.ajax({
      url: cas_ajax.ajax_url,
      type: "POST",
      data: {
        action: "cas_load_products",
        nonce: cas_ajax.nonce,
        category: casState.category,
        search: casState.search,
        page: casState.page,
      },
      success: function (response) {
        if (response.success) {
          $("#cas-product-grid").html(response.data.html);

          $("#cas-pagination").html(response.data.pagination);
        }
      },
    });
  };

  // Listen for category changes
  $(document).on("cas_category_changed", function (e, category) {
    loadProducts(category);
  });

  // Initial load
  loadProducts("");

  $(document).on("click", ".cas-plus", function () {
    let i = $(this).siblings("input");
    i.val(parseInt(i.val() || 1) + 1);
  });
  $(document).on("click", ".cas-minus", function () {
    let i = $(this).siblings("input");
    let v = Math.max(1, parseInt(i.val() || 1) - 1);
    i.val(v);
  });

  $(document).on("click", ".cas-add-cart", function () {
    let btn = $(this);

    if (btn.hasClass("loading")) return;

    btn.addClass("loading").text("Adding...");

    let card = btn.closest(".cas-card");

    $.ajax({
      url: wc_add_to_cart_params.wc_ajax_url
        .toString()
        .replace("%%endpoint%%", "add_to_cart"),

      type: "POST",

      data: {
        product_id: card.data("product"),

        quantity: card.find(".cas-qty-input").val(),
      },

      success: function (response) {
        btn.removeClass("loading").addClass("added").text("✓ Added");

        /*
         * WooCommerce refreshes
         */

        $(document.body).trigger("added_to_cart", [
          response.fragments,

          response.cart_hash,

          btn,
        ]);

        setTimeout(function () {
          btn.removeClass("added").text("Add To Cart");
        }, 1200);
      },

      error: function () {
        btn.removeClass("loading").text("Add To Cart");

        alert("Unable to add product");
      },
    });
  });

  // -- search
  let searchTimer;

  $("#cas-search").on("input", function () {
    clearTimeout(searchTimer);

    searchTimer = setTimeout(function () {
      casState.search = $("#cas-search").val();

      casState.page = 1;

      loadProducts(casState);
    }, 300);
  });

  // pagination

  $(document).on("click", ".cas-page", function () {
    casState.page = $(this).data("page");

    loadProducts(casState);
  });
});
