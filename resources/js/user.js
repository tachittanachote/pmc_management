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

    const username = $("#username")
    const password = $("#password")
    const position = $("#position")
    const name = $("#name")

    const usernameFeedback = $("#usernameFeedback");
    const passwordFeedback = $("#passwordFeedback");
    const positionFeedback = $("#positionFeedback");
    const nameFeedback = $("#nameFeedback");

    $("#add-user").on("click", function(e) {


        if (!username.val() || username.val().length <= 0) {
            username.addClass("is-invalid")
            usernameFeedback.css('display', 'block')
        }

        if (!password.val() || password.val().length <= 0) {
            password.addClass("is-invalid")
            passwordFeedback.css('display', 'block')
        }

        if (!position.val() || position.val().length <= 0) {
            position.addClass("is-invalid")
            positionFeedback.css('display', 'block')
        }

        if (!name.val() || name.val().length <= 0) {
            name.addClass("is-invalid")
            nameFeedback.css('display', 'block')
        }
        
        if (username.val() && username.val().length > 0 && password.val() && password.val().length > 0 && position.val() && position.val().length > 0 && name.val() && name.val().length > 0) {
            axios.post('/users/add', {
                username: username.val(),
                password: password.val(),
                position: position.val(),
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

    $(position).on('change', function (e) {
        if (position.val().length > 0) {
            position.removeClass("is-invalid")
            positionFeedback.css('display', 'none')
        }
    })

    $(name).on('input', function (e) {
        if (name.val().length > 0) {
            name.removeClass("is-invalid")
            nameFeedback.css('display', 'none')
        }
    })

})