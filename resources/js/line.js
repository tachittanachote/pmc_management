import liff from '@line/liff'
import $ from 'jquery'
import axios from 'axios'
import Swal from 'sweetalert2'

document.addEventListener("DOMContentLoaded", function () {
    liff
        .init({ liffId: '1656967252-zgxeV68j' })
        .then(() => {
            console.log("Loaded.")
            if(!liff.isLoggedIn()) {
                return liff.login();
            }
        })
        .catch((error) => {
            console.log(error)
        })
});

$("#auth").on("click", function (e) {
    liff
    .getProfile()
    .then((profile) => {
      const lineId = profile.userId;
      console.log(lineId)
      axios.post("/users/lineid/update", {
            line_id: lineId,
        }).then((response) => {
            Swal.fire({
                icon: response.data.status,
                text: response.data.result,
            }).then((e) => {
                window.location.reload();
            })
        }).catch((err) => {
            Swal.fire({
                icon: 'error',
                text: 'ไม่สามารถดำเนินการได้',
            })
        })
    })
    .catch((err) => {
      console.log("error", err);
    });
}) 