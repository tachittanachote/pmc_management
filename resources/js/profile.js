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

    const name = $("#name")
    const old_password = $("#old_password")
    const password = $("#password")
    const password_confirm = $("#password_confirm")

    const nameFeedback = $("#nameFeedback")
    const old_passwordFeedback = $("#old_passwordFeedback")
    const passwordFeedback = $("#passwordFeedback")
    const password_confirmFeedback = $("#password_confirmFeedback")

    $("#update-name").on("click", function (e) {


        if (!name.val() || name.val().length <= 0) {
            name.addClass("is-invalid")
            nameFeedback.css('display', 'block')
        }

        if (name.val() && name.val().length > 0 ) {
            axios.post('/profile/save', {
                option: 'name',
                name: name.val(),
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
                }).then(() => {
                    window.location.reload();
                })
            })
        }


    })

    $("#update-password").on("click", function (e) {

        if (!old_password.val() || old_password.val().length <= 0) {
            old_password.addClass("is-invalid")
            old_passwordFeedback.css('display', 'block')
        }

        if (!password.val() || password.val().length <= 3 ) {
            password.addClass("is-invalid")
            passwordFeedback.css('display', 'block')
        }

        if (!password_confirm.val() || password_confirm.val().length <= 3 || password.val() !== password_confirm.val()  ) {
            password_confirm.addClass("is-invalid")
            password_confirmFeedback.css('display', 'block')
        }

        if (old_password.val() && old_password.val().length > 3 && password.val() && password.val().length > 3 && password_confirm.val() && password_confirm.val().length > 3 && password.val() === password_confirm.val()) {
            axios.post('/profile/save', {
                option: 'password',
                old_password: old_password.val(),
                password: password.val(),
                password_confirm: password_confirm.val(),
            }).then((resp) => {
                Toast.fire({
                    icon: resp.data.status,
                    title: resp.data.result
                }).then(() => {
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

    $(name).on('input', function (e) {
        if (name.val().length > 0) {
            name.removeClass("is-invalid")
            nameFeedback.css('display', 'none')
        }
    })

    $(old_password).on('input', function (e) {
        if (old_password.val().length > 0) {
            old_password.removeClass("is-invalid")
            old_passwordFeedback.css('display', 'none')
        }
    })

    $(password).on('input', function (e) {
        if (password.val().length > 0) {
            password.removeClass("is-invalid")
            passwordFeedback.css('display', 'none')
        }
    })

    $(password_confirm).on('input', function (e) {
        if (password_confirm.val().length > 0) {
            password_confirm.removeClass("is-invalid")
            password_confirmFeedback.css('display', 'none')
        }
    })




    const bankname = $("#bankname")
    const bankno = $("#bankno")
    const accountName = $("#accountName")

    const banknameFeedback = $("#banknameFeedback")
    const banknoFeedback = $("#banknoFeedback")
    const accountNameFeedback = $("#accountNameFeedback")

    $("#update-bank").on("click", function (e) {


        if (!bankname.val() || bankname.val().length <= 0) {
            bankname.addClass("is-invalid")
            banknameFeedback.css('display', 'block')
        }

        if (!bankno.val() || bankno.val().length <= 0) {
            bankno.addClass("is-invalid")
            banknoFeedback.css('display', 'block')
        }

        if (!accountName.val() || accountName.val().length <= 0) {
            accountName.addClass("is-invalid")
            accountNameFeedback.css('display', 'block')
        }

        if (bankname.val() && bankname.val().length > 0 && bankno.val() && bankno.val().length > 0 && accountName.val() && accountName.val().length > 0 ) {
            axios.post('/profile/save', {
                option: 'bank',
                bankname: bankname.val(),
                bankno: bankno.val(),
                accountName: accountName.val(),
            }).then((resp) => {
                Toast.fire({
                    icon: resp.data.status,
                    title: resp.data.result
                }).then(() => {
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

    $(bankname).on('input', function (e) {
        if (bankname.val().length > 0) {
            bankname.removeClass("is-invalid")
            banknameFeedback.css('display', 'none')
        }
    })

    $(bankno).on('input', function (e) {
        if (bankno.val().length > 0) {
            bankno.removeClass("is-invalid")
            banknoFeedback.css('display', 'none')
        }
    })

    $(accountName).on('input', function (e) {
        if (accountName.val().length > 0) {
            accountName.removeClass("is-invalid")
            accountNameFeedback.css('display', 'none')
        }
    })





})