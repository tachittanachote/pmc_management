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

    // const domainName = window.location.hostname
    // if (domainName === "branch1.phamaiintrend.co" || domainName === "branch2.phamaiintrend.co") {
    //     liff
    //         .init({
    //             liffId: domainName === "branch1.phamaiintrend.co" ? "1656967252-zgxeV68j" : "1656967252-2eYgQrmD", // Use own liffId
    //         })
    //         .then(() => {
    //             if (!liff.isLoggedIn()) {
    //                 liff.login({ redirectUri: window.location.href });
    //             }
    //             const accessToken = liff.getAccessToken();
    //             console.log(accessToken)

    //             liff.getProfile().then((profile) => {
    //                 const userId = profile.userId;
    //                 console.log(userId)

    //                 axios.post('/users/lineid/update', {
    //                     line_id: userId,
    //                 })

    //             }).catch((err) => {
    //                 console.log("error", err);
    //             });
    //         })
    //         .catch((err) => {
    //             console.log(err.code, err.message);
    //         });
    // }

    console.log("Ready!")

    const usernameFeedback = $('#username-feedback');
    const passwordFeedback = $('#password-feedback');

    const username = $('#username')
    const password = $('#password')

    $("#login").on('click', function (e) {
        e.preventDefault();

        if (!username.val() || username.val().length <= 0) {
            username.addClass("is-invalid")
            usernameFeedback.css('display', 'block')
        }

        if (!password.val() || password.val().length <= 0) {
            password.addClass("is-invalid")
            passwordFeedback.css('display', 'block')
        }

        if (username.val() && username.val().length > 0 && password.val() && password.val().length > 0) {
            axios.post('/login', {
                username: username.val(),
                password: password.val(),
                remember_me: $('#remember_me').is(":checked")
            }).then((resp) => {
                Toast.fire({
                    icon: resp.data.status,
                    title: resp.data.result
                })
                //alert(JSON.stringify(resp.data))
                if (resp.data.status === "success") {
                    if (!resp.data.redirect === 'line-auth') {
                        window.location.href = "/dashboard"
                    } else {
                        window.location.href = "/line-auth"
                    }
                }

            }).catch((err) => {
                Toast.fire({
                    icon: 'error',
                    title: 'ไม่สามารถดำเนินการได้'
                })
            })
        }

    })

    $(username).on('input', function (e) {
        if (username.val().length > 0) {
            username.removeClass("is-invalid")
            usernameFeedback.css('display', 'none')
        }
    })

    $(password).on('input', function (e) {
        if (password.val().length > 0) {
            password.removeClass("is-invalid")
            passwordFeedback.css('display', 'none')
        }
    })


    $("#close-popup").on('click', function (e) {
        e.preventDefault();

        if ($('#understand').is(":checked")) {
            localStorage.setItem("understand", "1")
            var d = new Date();
            var unixtimeAdd60 = Math.floor(d.getTime() / 1000)
            localStorage.setItem("time", unixtimeAdd60)
        }

    })
})