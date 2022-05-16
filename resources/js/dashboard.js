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

    $(".remove").on("click", function(e) {
        e.preventDefault();

        axios.post("/work/remove", {
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

    $('input[class=custom-file-input]').on("change", function (e) {
        const filename = e.target.files[0].name
        const id = e.target.id.split("-")[1]

        $("#upload-filename-" + id).html(filename)

    });


    $(".update-work").on("click", function(e) {
        const id = $(this).attr('data-id');

        if($("#tailor-" + id).length)
        {
            const name = $("#name-" + id)
            const code = $("#code-" + id)
            const product = $("#product-" + id)
            const tailor = $("#tailor-" + id)
            const detail = $("#detail-" + id)

            const nameFeedback = $("#nameFeedback-" + id)
            const codeFeedback = $("#codeFeedback-" + id)
            const productFeedback = $("#productFeedback-" + id)
            const tailorFeedback = $("#tailorFeedback-" + id)
            const detailFeedback = $("#detailFeedback-" + id)

            if (!name.val() || name.val().length <= 0) {
                name.addClass("is-invalid")
                nameFeedback.css('display', 'block')
            }

            if (!code.val() || code.val().length <= 0) {
                code.addClass("is-invalid")
                codeFeedback.css('display', 'block')
            }

            if (!product.val() || product.val().length <= 0) {
                product.addClass("is-invalid")
                productFeedback.css('display', 'block')
            }

            if (!tailor.val() || tailor.val().length <= 0) {
                tailor.addClass("is-invalid")
                tailorFeedback.css('display', 'block')
            }

            if (!detail.val() || detail.val().length <= 0) {
                detail.addClass("is-invalid")
                detailFeedback.css('display', 'block')
            }

            if (name.val() && name.val().length > 0 && code.val() && code.val().length > 0 && product.val() && product.val().length > 0 && tailor.val() && tailor.val().length > 0 && detail.val() && detail.val().length > 0) {

                const formData = new FormData();
                const file = document.querySelector('#upload-' + id);

                formData.append("file", file.files[0]);
                formData.append("work_id", id);
                formData.append("name", name.val());
                formData.append("code", code.val());
                formData.append("product", product.val());
                formData.append("tailor", tailor.val());
                formData.append("detail", detail.val());

                axios({
                    method: 'post',
                    url: '/work/update',
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
        }
        else {
            const name = $("#name-" + id)
            const code = $("#code-" + id)
            const product = $("#product-" + id)
            const detail = $("#detail-" + id)

            const nameFeedback = $("#nameFeedback-" + id)
            const codeFeedback = $("#codeFeedback-" + id)
            const productFeedback = $("#productFeedback-" + id)
            const detailFeedback = $("#detailFeedback-" + id)

            if (!name.val() || name.val().length <= 0) {
                name.addClass("is-invalid")
                nameFeedback.css('display', 'block')
            }

            if (!code.val() || code.val().length <= 0) {
                code.addClass("is-invalid")
                codeFeedback.css('display', 'block')
            }

            if (!product.val() || product.val().length <= 0) {
                product.addClass("is-invalid")
                productFeedback.css('display', 'block')
            }

            if (!detail.val() || detail.val().length <= 0) {
                detail.addClass("is-invalid")
                detailFeedback.css('display', 'block')
            }

            if (name.val() && name.val().length > 0 && code.val() && code.val().length > 0 && product.val() && product.val().length > 0 && detail.val() && detail.val().length > 0) {

                const formData = new FormData();
                const file = document.querySelector('#upload-' + id);

                formData.append("file", file.files[0]);
                formData.append("work_id", id);
                formData.append("name", name.val());
                formData.append("code", code.val());
                formData.append("product", product.val());
                formData.append("detail", detail.val());

                axios({
                    method: 'post',
                    url: '/work/update',
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
        }
    })
})