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

    const productName = $("#product_name")
    const priceTailor = $("#price_tailor")
    const priceSeamstress = $("#price_seamstress")
    const isFix = $("#is_fix")

    const productNameFeedback = $("#productNameFeedback");
    const priceTailorFeedback = $("#priceTailorFeedback");
    const priceSeamstressFeedback = $("#priceSeamstressFeedback");

    $("#add-product").on("click", function(e) {


        if (!productName.val() || productName.val().length <= 0) {
            productName.addClass("is-invalid")
            productNameFeedback.css('display', 'block')
        }

        if (!priceTailor.val() || priceTailor.val().length <= 0) {
            priceTailor.addClass("is-invalid")
            priceTailorFeedback.css('display', 'block')
        }

        if (!priceSeamstress.val() || priceSeamstress.val().length <= 0 || priceSeamstress.val() <= 0) {
            priceSeamstress.addClass("is-invalid")
            priceSeamstressFeedback.css('display', 'block')
        }

        
        if (productName.val() && productName.val().length > 0 && priceTailor.val() && priceTailor.val().length > 0 && priceSeamstress.val() && priceSeamstress.val().length > 0 && priceSeamstress.val() > 0) {
            axios.post('/products/add', {
                product_name: productName.val(),
                price_tailor: priceTailor.val(),
                price_seamstress: priceSeamstress.val(),
                is_fix: isFix.is(":checked")
            }).then((resp) => {
                Toast.fire({
                    icon: resp.data.status,
                    title: resp.data.result
                })
                window.location.reload();
            }).catch((err) => {
                Toast.fire({
                    icon: 'error',
                    title: 'ไม่สามารถดำเนินการได้'
                })
            })
        }


    })

    $(productName).on('input', function (e) {
        if (productName.val().length > 0) {
            productName.removeClass("is-invalid")
            productNameFeedback.css('display', 'none')
        }
    })

    $(priceTailor).on('input', function (e) {
        if (priceTailor.val().length > 0) {
            priceTailor.removeClass("is-invalid")
            priceTailorFeedback.css('display', 'none')
        }
    })

    $(priceSeamstress).on('input', function (e) {
        if (priceSeamstress.val().length > 0) {
            priceSeamstress.removeClass("is-invalid")
            priceSeamstressFeedback.css('display', 'none')
        }
    })

    $(".remove").on("click", function (e) {
        e.preventDefault();

        axios.post("/products/remove", {
            product_id: $(this).attr("data-id"),
        }).then((response) => {
            Swal.fire({
                icon: response.data.status,
                text: response.data.result,
            }).then((e) => {
                window.location.reload();
            })
        }).catch((err) => {
            Toast.fire({
                icon: 'error',
                title: 'ไม่สามารถดำเนินการได้'
            })
        })

    })

    $(".update-product").on("click", function (e) {

        e.preventDefault();
        const id = $(this).attr("data-id")

        if (!$("#edit-name-" + id).val() || $("#edit-name-" + id).val().length <= 0) {
            $("#edit-name-" + id).addClass("is-invalid")
            $("#edit-nameFeedback-" + id).css('display', 'block')
        }

        if (!$("#edit-tprice-" + id).val() || $("#edit-tprice-" + id).val().length <= 0 || $("#edit-tprice-" + id).val() < 0) {
            $("#edit-tpriceFeedback-" + id).html("โปรดระบุชื่อชื่อผู้ใช้งาน")
            $("#edit-tprice-" + id).addClass("is-invalid")
            $("#edit-tpriceFeedback-" + id).css('display', 'block')

        }

        if (!$("#edit-sprice-" + id).val() || $("#edit-sprice-" + id).val().length <= 0 || $("#edit-sprice-" + id).val() < 0) {
            $("#edit-sprice-" + id).addClass("is-invalid")
            $("#edit-spriceFeedback-" + id).css('display', 'block')
        }

        if ($("#edit-name-" + id).val() && $("#edit-name-" + id).val().length > 0 && $("#edit-tprice-" + id).val() && $("#edit-tprice-" + id).val().length > 0 && $("#edit-sprice-" + id).val() && $("#edit-sprice-" + id).val().length > 0 && $("#edit-sprice-" + id).val() >= 0 && $("#edit-tprice-" + id).val() >= 0)

            axios.post("/products/update", {
                product_id: id,
                name: $("#edit-name-" + id).val(),
                tprice: $("#edit-tprice-" + id).val(),
                sprice: $("#edit-sprice-" + id).val(),
            }).then((response) => {
                if (response.data.result === "ชื่อประเภทชุดนี้มีอยู่ในระบบแล้ว") {
                    $("#edit-nameFeedback-" + id).html(response.data.result)
                    $("#edit-name-" + id).addClass("is-invalid")
                    $("#edit-nameFeedback-" + id).css('display', 'block')
                }
                else {
                    Swal.fire({
                        icon: response.data.status,
                        text: response.data.result,
                    }).then((e) => {
                        window.location.reload();
                    })
                }
            }).catch((err) => {
                Toast.fire({
                    icon: 'error',
                    title: 'ไม่สามารถดำเนินการได้'
                })
            })

    })

})