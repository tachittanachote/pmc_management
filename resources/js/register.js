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
    console.log("Ready!")

    const bankname = $("#bankname")
    const bankno = $("#bankno")
    const accountName = $("#accountName")
    const name = $("#name")
    const role = $("#role")

    const banknameFeedback = $("#banknameFeedback")
    const banknoFeedback = $("#banknoFeedback")
    const accountNameFeedback = $("#accountNameFeedback")
    const nameFeedback = $("#nameFeedback")
    const roleFeedback = $("#roleFeedback")

    const usernameFeedback = $('#username-feedback');
    const passwordFeedback = $('#password-feedback');
    const confirmPasswordFeedback = $('#confirmpassword-feedback');

    const username = $('#username')
    const password = $('#password')
    const confirmpassword = $('#confirmpassword')

    $("#register").on('click', function(e) {
        e.preventDefault();

        if (!name.val() || name.val().length <= 2) {
            name.addClass("is-invalid")
            nameFeedback.css('display', 'block')
        }

        if (!role.val() || role.val().length <= 0) {
            role.addClass("is-invalid")
            roleFeedback.css('display', 'block')
        }

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

        if (!username.val() || username.val().length <= 3) {
            username.addClass("is-invalid")
            usernameFeedback.css('display', 'block')
        }

        if (!password.val() || password.val().length <= 3) {
            password.addClass("is-invalid")
            passwordFeedback.css('display', 'block')
        }

        if (!confirmpassword.val() || confirmpassword.val().length <= 3) {
            confirmpassword.addClass("is-invalid")
            confirmPasswordFeedback.css('display', 'block')
        }

        if (confirmpassword.val() !== password.val()) {
            confirmpassword.addClass("is-invalid")
            confirmPasswordFeedback.css('display', 'block')
            confirmPasswordFeedback.html("รหัสผ่านไม่ตรงกัน")
        }

        if (role.val() && role.val().length > 0 && name.val() && name.val().length > 2 && username.val() && username.val().length > 3 && password.val() && password.val().length > 3 && confirmpassword.val() === password.val() && bankname.val() && bankname.val().length > 0 && bankno.val() && bankno.val().length > 0 && accountName.val() && accountName.val().length > 0) {
            axios.post('/register', {
                username: username.val(),
                password: password.val(),
                confirmpassword: confirmpassword.val(),
                bankname: bankname.val(),
                bankno: bankno.val(),
                accountName: accountName.val(),
                name: name.val(),
                role: role.val(),
            }).then((resp) => {
                Swal.fire({
                    icon: resp.data.status,
                    title: resp.data.result,
                    html: `
                        <div>โปรดเข้าสู่ระบบด้วยชื่อผู้ใช้งาน</div>
                        <div>ชื่อผู้ใช้งาน: ${username.val()} รหัสผ่าน: ${password.val()}</div>
                    `
                }).then((e) => {
                    window.location.href = '/'
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

    $(username).on('input', function(e) {
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

    $(confirmpassword).on('input', function (e) {
        if (confirmpassword.val().length > 0) {
            confirmpassword.removeClass("is-invalid")
            confirmPasswordFeedback.css('display', 'none')
        }
        if (confirmpassword.val().length === password.val().length && confirmpassword.val() === password.val()) {
            confirmpassword.removeClass("is-invalid")
            confirmPasswordFeedback.css('display', 'none')
            confirmPasswordFeedback.html("โปรดระบุรหัสผ่านให้ครบถ้วน")
        }
        if (confirmpassword.val().length === password.val().length && confirmpassword.val() !== password.val()) {
            confirmpassword.removeClass("is-invalid")
            confirmPasswordFeedback.css('display', 'block')
            confirmPasswordFeedback.html("รหัสผ่านไม่ตรงกัน")
        }
    })

    $(role).on('change', function (e) {
        if (role.val().length > 0) {
            role.removeClass("is-invalid")
            roleFeedback.css('display', 'none')
        }
    })

    $(bankname).on('change', function (e) {
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