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

    const message = $("#message")
    const messageFeedback = $('#messageFeedback');

    $("#save-announce").on('click', function (e) {
        e.preventDefault();

        if (!message.val() || message.val().length <= 0) {
            message.addClass("is-invalid")
            messageFeedback.css('display', 'block')
        }

        if (message.val() && message.val().length > 0) {


            const formData = new FormData();
            const file = document.querySelector('#upload');

            formData.append("file", file.files[0]);
            formData.append("message", message.val());

            axios({
                method: 'post',
                url: '/announce/create',
                data: formData,
                header: {
                    'Content-Type': 'multipart/form-data',
                },
            }).then((resp) => {
                Swal.fire({
                    icon: resp.data.status,
                    text: resp.data.result,
                }).then((e) => {
                    window.location.reload();
                })
            }).catch((err) => {
                Toast.fire({
                    icon: 'error',
                    title: 'ไม่สามารถดำเนินการได้'
                })
            })
        }

    })

    $(message).on('input', function (e) {
        if (message.val().length > 0) {
            message.removeClass("is-invalid")
            messageFeedback.css('display', 'none')
        }
    })

    $("#status").on('change', function (e) {
        axios.post('/announce/toggle', {
            id: $("#status").attr("data-id"),
            status: $("#status").val(),
        }).then((resp) => {
            Toast.fire({
                icon: resp.data.status,
                title: resp.data.result,
            })
        }).catch((err) => {
            Toast.fire({
                icon: 'error',
                title: 'ไม่สามารถดำเนินการได้'
            })
        })
    })

    $(".remove").on('click', function (e) {
        axios.post('/announce/remove', {
            id: $(this).attr("data-id"),
        }).then((resp) => {
            Swal.fire({
                icon: resp.data.status,
                text: resp.data.result,
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

    const announceText = $("#announce-text")

    const announceTextFeedback = $('#announce-textFeedback');

    $(announceText).on('input', function (e) {
        if (announceText.val().length > 0) {
            announceText.removeClass("is-invalid")
            announceTextFeedback.css('display', 'none')
        }
    })

    $("#update-text").on('click', function (e) {


        e.preventDefault();

        if (!announceText.val() || announceText.val().length <= 0) {
            announceText.addClass("is-invalid")
            announceTextFeedback.css('display', 'block')
        }


        if (announceText.val() && announceText.val().length > 0) {
        

            const formData = new FormData();
            const file = document.querySelector('#upload-update');

            formData.append("file", file.files[0]);
            formData.append("id", $(this).attr("data-id"));
            formData.append("text", announceText.val());

            axios({
                method: 'post',
                url: '/announce/update',
                data: formData,
                header: {
                    'Content-Type': 'multipart/form-data',
                },
            }).then((resp) => {
                Swal.fire({
                    icon: resp.data.status,
                    text: resp.data.result,
                }).then((e) => {
                    window.location.reload();
                })
            }).catch((err) => {
                Toast.fire({
                    icon: 'error',
                    title: 'ไม่สามารถดำเนินการได้'
                })
            })
        
        }
    })

    $('input[class=custom-file-input]').on("change", function (e) {
        const filename = e.target.files[0].name
        
        if (e.target.id === "upload-update") {
            $("#upload-update-label").html(filename)
        }
        if (e.target.id === "upload") {
            $("#upload-new-label").html(filename)
        }
    });

})