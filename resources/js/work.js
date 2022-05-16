import $ from 'jquery'
import axios from 'axios'
import Swal from 'sweetalert2'

const Toast = Swal.mixin({
    toast: true,
    position: 'bottom',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

$(document).ready(() => {

    const productCode = $("#productCode")
    const productName = $("#productName")
    const product = $("#product")
    const tailor = $("#tailor")
    const quantity = $("#quantity")
    const detail = $("#detail")

    const productCodeFeedback = $("#productCodeFeedback");
    const productNameFeedback = $("#productNameFeedback");
    const productFeedback = $("#productFeedback");
    const tailorFeedback = $("#tailorFeedback");
    const quantityFeedback = $("#quantityFeedback");
    const detailFeedback = $("#detailFeedback");

    $("#upload-work").on("click", function (e) {

        if (!productCode.val() || productCode.val().length <= 0) {
            productCode.addClass("is-invalid")
            productCodeFeedback.css('display', 'block')
        }

        if (!productName.val() || productName.val().length <= 0) {
            productName.addClass("is-invalid")
            productNameFeedback.css('display', 'block')
        }

        if (!product.val() || product.val().length <= 0) {
            product.addClass("is-invalid")
            productFeedback.css('display', 'block')
        }

        if ((product.find(':selected').attr('data-fix') === "no" && !tailor.val()) || (product.find(':selected').attr('data-fix') === "no" && tailor.val().length <= 0)) {
            tailor.addClass("is-invalid")
            tailorFeedback.css('display', 'block')
        }

        if (!quantity.val() || quantity.val().length <= 0 || quantity.val() < 1) {
            quantity.addClass("is-invalid")
            quantityFeedback.css('display', 'block')
        }

        if (!detail.val() || detail.val().length <= 0) {
            detail.addClass("is-invalid")
            detailFeedback.css('display', 'block')
        }


        if (productCode.val() && productCode.val().length > 0 && productName.val() && productName.val().length > 0 && product.val() && product.val().length > 0 && quantity.val() && quantity.val().length > 0 && quantity.val() > 0 && detail.val() && detail.val().length > 0) {


            if ((product.find(':selected').attr('data-fix') === "no" && !tailor.val()) || (product.find(':selected').attr('data-fix') === "no" && tailor.val().length <= 0) && parseFloat($(this).find(':selected').attr('data-tprice')) > 0.00) {
                return false;
            }

            const formData = new FormData();
            const file = document.querySelector('#upload');

            formData.append("file", file.files[0]);
            formData.append("product_code", $("#productCode").val());
            formData.append("product_name", $("#productName").val());
            formData.append("product", $("#product").val());
            formData.append("tailor", $("#tailor").val());
            formData.append("quantity", $("#quantity").val());
            formData.append("detail", $("#detail").val());

            axios({
                method: 'post',
                url: '/work/upload',
                data: formData,
                header: {
                    'Content-Type': 'multipart/form-data',
                },
            })
                .then(function (response) {
                    Swal.fire({
                        icon: response.data.status,
                        text: response.data.result,
                    }).then((e) => {
                        window.location.reload();
                    })
                })
                .catch(function (response) {
                    Toast.fire({
                        icon: 'error',
                        title: 'ไม่สามารถดำเนินการได้'
                    })
                });
        }
    })

    $(productCode).on('input', function (e) {
        if (productCode.val().length > 0) {
            productCode.removeClass("is-invalid")
            productCodeFeedback.css('display', 'none')
        }
    })

    $(productName).on('input', function (e) {
        if (productName.val().length > 0) {
            productName.removeClass("is-invalid")
            productNameFeedback.css('display', 'none')
        }
    })

    $(product).on('change', function (e) {
        if (product.val().length > 0) {
            product.removeClass("is-invalid")
            productFeedback.css('display', 'none')
        }
        if (product.find(':selected').attr('data-fix') === "no") {
            $("#tailor-selection").css('display', 'block');
        }
        if ($(this).find(':selected').attr('data-fix') === "yes") {
            $("#tailor-selection").css('display', 'none');
        }
        if (parseFloat($(this).find(':selected').attr('data-tprice')) === 0.00) {
            $("#tailor-selection").css('display', 'none');
        }
    })

    $(tailor).on('change', function (e) {
        if (tailor.val().length > 0) {
            tailor.removeClass("is-invalid")
            tailorFeedback.css('display', 'none')
        }
        
    })

    $(quantity).on('input', function (e) {
        if (quantity.val().length > 0) {
            quantity.removeClass("is-invalid")
            quantityFeedback.css('display', 'none')
        }
    })

    $(detail).on('input', function (e) {
        if (detail.val().length > 0) {
            detail.removeClass("is-invalid")
            detailFeedback.css('display', 'none')
        }
    })
})