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



    $(".add-deduct").on("click", function (e) {

        const user_id = $(this).attr('data-id')

        const deductDetail = $("#deduct-detail-" + user_id)
        const deductAmount = $("#deduct-amount-" + user_id)
        const deductDate = $("#deduct-date-" + user_id)

        const deductDetailFeedback = $("#deduct-detail-Feedback-" + user_id)
        const deductAmountFeedback = $("#deduct-amount-Feedback-" + user_id)
        const deductDateFeedback = $("#deduct-date-Feedback-" + user_id)

        

        if (!deductDetail.val() || deductDetail.val().length <= 0) {
            deductDetail.addClass("is-invalid")
            deductDetailFeedback.css('display', 'block')
        }

        if (!deductAmount.val() || deductAmount.val().length <= 0 || deductAmount.val() < 0) {
            deductAmount.addClass("is-invalid")
            deductAmountFeedback.css('display', 'block')
        }

        if (!deductDate.val() || deductDate.val().length <= 0) {
            deductDate.addClass("is-invalid")
            deductDateFeedback.css('display', 'block')
        }

        if (deductDetail.val() && deductDetail.val().length > 0 && deductAmount.val() && deductAmount.val().length > 0 && deductAmount.val() > 0 && deductDate.val() && deductDate.val().length > 0) {
            axios.post('/deduct/add', {
                user_id: user_id,
                detail: deductDetail.val(),
                amount: deductAmount.val(),
                date: deductDate.val(),
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

    $(".remove").on("click", function (e) {

        const deductId = $(this).attr('data-id')

            axios.post('/deduct/remove', {
                id: deductId,
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


    $(".clear").on("click", function (e) {

        const userId = $(this).attr('data-id')

        axios.post('/deduct/clear', {
            user_id: userId,
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
})