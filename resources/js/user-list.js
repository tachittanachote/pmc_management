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

    const bankname = $("#bankname")
    const bankno = $("#bankno")
    const accountName = $("#accountName")

    const banknameFeedback = $("#banknameFeedback")
    const banknoFeedback = $("#banknoFeedback")
    const accountNameFeedback = $("#accountNameFeedback")

    $(".update-bank").on("click", function (e) {


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
                id: $(this).attr("data-id"),
                bankname: bankname.val(),
                bankno: bankno.val(),
                accountName: accountName.val(),
            }).then((resp) => {
                Toast.fire({
                    icon: resp.data.status,
                    title: resp.data.result
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


    $(".remove").on("click", function (e) {
        e.preventDefault();

        axios.post("/users/remove", {
            user_id: $(this).attr("data-id"),
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


    $(".update-account").on("click", function (e) {

        e.preventDefault();
        const id = $(this).attr("data-id")

        if (!$("#edit-name-" + id).val() || $("#edit-name-" + id).val().length <= 0) {
            $("#edit-name-" + id).addClass("is-invalid")
            $("#edit-nameFeedback-" + id).css('display', 'block')
        }

        if (!$("#edit-role-" + id).val() || $("#edit-role-" + id).val().length <= 0) {
            $("#edit-role-" + id).addClass("is-invalid")
            $("#edit-roleFeedback-" + id).css('display', 'block')
        }

        if (!$("#edit-username-" + id).val() || $("#edit-username-" + id).val().length <= 0) {
            $("#edit-usernameFeedback-" + id).html("โปรดระบุชื่อชื่อผู้ใช้งาน")
            $("#edit-username-" + id).addClass("is-invalid")
            $("#edit-usernameFeedback-" + id).css('display', 'block')
            
        }

        if (!$("#edit-password-" + id).val() || $("#edit-password-" + id).val().length <= 0) {
            $("#edit-password-" + id).addClass("is-invalid")
            $("#edit-passwordFeedback-" + id).css('display', 'block')
        }

        if ($("#edit-name-" + id).val() && $("#edit-name-" + id).val().length > 0 && $("#edit-role-" + id).val() && $("#edit-role-" + id).val().length > 0 && $("#edit-username-" + id).val() && $("#edit-username-" + id).val().length > 0 && $("#edit-password-" + id).val() && $("#edit-password-" + id).val().length > 0)
        
        axios.post("/users/update", {
            user_id: id,
            name: $("#edit-name-" + id).val(),
            role: $("#edit-role-" + id).val(),
            username: $("#edit-username-" + id).val(),
            password: $("#edit-password-" + id).val(),
        }).then((response) => {
            if (response.data.result === "ชื่อผู้ใช้งานนี้มีอยู่ในระบบแล้ว") {
                $("#edit-usernameFeedback-" + id).html(response.data.result)
                $("#edit-username-" + id).addClass("is-invalid")
                $("#edit-usernameFeedback-" + id).css('display', 'block')
            }
            else if (response.data.result === "รหัสผ่านต้องมากกว่า 4 ตัวอักษรขึ้นไป") {
                $("#edit-passwordFeedback-" + id).html(response.data.result)
                $("#edit-password-" + id).addClass("is-invalid")
                $("#edit-passwordFeedback-" + id).css('display', 'block')
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