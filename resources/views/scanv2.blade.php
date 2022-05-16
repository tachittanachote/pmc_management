<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Phamaiintrend Scanner</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
      .editlist {
        display: none;
      }

      html, body {
        background: #c7c7c7;
        overflow-y: hidden; /* Hide vertical scrollbar */
        overflow-x: hidden; /* Hide horizontal scrollbar */
        height: 100vh;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .add-work-form {
        display: none;
      }

      .video {
            height: 100%;
          max-width: 100%;
      }
    </style>
  </head>
<body>
            <video id="qr-video" class="video"></video>
            <input id="role" value="{{Auth::user()->role}}" hidden/>
            <input id="user_id" value="{{Auth::user()->id}}" hidden/>
            <input id="name" value="{{Auth::user()->name}}" hidden/>
    <div class="modal fade" id="order" tabindex="-1" aria-labelledby="orderDetail" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orderDetail">รายละเอียดงาน</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>ลูกค้า: <span id="customer_fb_name"></span> (<span id="customer_name"></span>)</div>
        <div>หมายเลขสินค้า: <span id="product_code"></span></div>
        <div>รายละเอียด: <span id="detail"></span></div>

        <div class="editlist mt-2">
          <div class="font-weight-bold" id="list_note" style="display: none">รายการสั่งการแก้ไขสินค้า</div>
          <div class="edit-detail"></div>
        </div>

        <div class="add-work-form mt-3">
          <div class="card mb-3 mb-md-4">

                <div class="card-body">


                    <div class="mb-3 mb-md-4 d-flex justify-content-between">
                        <div class="h3 mb-0">เพิ่มข้อมูลงานลงระบบ</div>
                    </div>

                    <div>
                            <div class="form-row" style="display: none;">
                                <div class="form-group col-12">
                                    <label for="productCode">รหัสสินค้า</label>
                                    <input type="text" class="form-control" id="productCode" name="productCode" placeholder="รหัสสินค้า" autocomplete="off" hidden>
                                    <div id="productCodeFeedback" class="invalid-feedback">
                                        โปรดระบุข้อมูลให้ครบถ้วน
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" style="display: none;">
                                <div class="form-group col-12">
                                    <label for="productName">ชื่อสินค้า</label>
                                    <input type="text" class="form-control" id="productName" name="productName" placeholder="ชื่อสินค้า" autocomplete="off" hidden>
                                    <div id="productNameFeedback" class="invalid-feedback">
                                        โปรดระบุข้อมูลให้ครบถ้วน
                                    </div>
                                </div>
                            </div>

                    </div>
                        <div>
                            <div class="form-row">
                                    <label for="bankname">เลือกประเภทชุด</label>
                                    <select class="form-control mb-2" id="product">
                                        <option value="" disabled selected hidden>เลือกประเภทชุด</option>
                                        @foreach(\App\Product::get() as $product)
                                            <option value="{{$product->id}}" data-fix="{{$product->is_fix}}" data-tprice="{{$product->price_tailor}}">{{$product->product_name}}</option>
                                        @endforeach
                                    </select>
                                    <div id="productFeedback" class="invalid-feedback">
                                        โปรดเลือกประเภทชุด
                                    </div>
                                </div>
                        </div>
                        <div id="tailor-selection" style="display: none;">
                            @if(Auth::user()->role != "tailor")
                                <div class="form-row">
                                  <div class="form-group col-12">
                                      <label for="tailor">ช่างตัด</label>
                                      <input type="text" class="form-control" id="tailor" name="tailor" value="" autocomplete="off" readonly hidden>
                                      <input type="text" class="form-control" id="tailor-label" value="" autocomplete="off" readonly>
                                  </div>
                                </div>
                              @else
                                <input type="text" class="form-control" id="tailor" name="tailor" value="{{Auth::user()->id}}" autocomplete="off" readonly hidden>
                              @endif
                        </div>
                        <div>
                            <div class="form-row" style="display: none;">
                                <div class="form-group col-12">
                                    <label for="detail-form">ไซส์และชื่อลูกค้า</label>
                                    <input type="text" class="form-control" id="detail-form" name="detail-form" placeholder="ไซส์และชื่อลูกค้า" autocomplete="off">
                                    <div id="detailFeedback" class="invalid-feedback">
                                        โปรดระบุข้อมูลให้ครบถ้วน
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-12 mb-3">
                                  <div class="custom-file">
                                      <input type="file" class="custom-file-input" id="upload" aria-describedby="upload">
                                      <label class="custom-file-label" for="upload">เพิ่มรูปภาพงาน</label>
                                  </div>
                              </div>
                            </div>
                    </div>
                    <!-- End Form -->
                </div>
            </div>
        </div>

        <button type="button" class="btn rounded w-100 mt-2 " id="confirm"></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>
</body>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.4/dist/sweetalert2.all.min.js" integrity="sha256-COxwIctJg+4YcOK90L6sFf84Z18G3tTmqfK98vtnz2Q=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/qr-scanner/1.4.1/qr-scanner-worker.min.js" integrity="sha512-U6MqJWVLYAju7u3JtHVasPpguvjKzKt44x4t4txuRLaJTVuNdYNCQFrevlxKCkQm1eEdHa3gZBoOZwau4MGPZQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ mix('js/scan.js') }}" defer></script>   
    
    <script type="module">

      import QrScanner from "https://cdnjs.cloudflare.com/ajax/libs/qr-scanner/1.4.1/qr-scanner.min.js";
            $('#upload').on('change',function(e){
                var fileName = e.target.files[0].name;
                $('.custom-file-label').html(fileName);
            })

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

const productCode = $("#productCode")
const productName = $("#productName")
const product = $("#product")
const tailor = $("#tailor")
const detail = $("#detail-form")

const productCodeFeedback = $("#productCodeFeedback");
const productNameFeedback = $("#productNameFeedback");
const productFeedback = $("#productFeedback");
const tailorFeedback = $("#tailorFeedback");
const detailFeedback = $("#detailFeedback");

const video = document.getElementById('qr-video');
const scanner = new QrScanner(video, result => setResult(result), {
    preferredCamera: 'environment',
    highlightScanRegion: true,
});

scanner.start()

$('#order').on('hidden.bs.modal', function (e) {
    scanner.start()
})


function setResult(result) {
    onScanSuccess(result.data)
    scanner.stop()
}

var is_fix = true;

function onScanSuccess(decodedText) {

    var fillForm = 0;
    var orderId = decodedText.replace(/\D/g, '');

    console.log("Order ID", orderId)

    $('.edit-detail').empty();

    axios.post('https://order.phamaiintrend.co/order/employee/check', {
        order_id: orderId
    }).then((resp) => {

        console.log(resp.data.status)
        if(resp.data.status === 'error') {
            return Swal.fire({
                icon: 'warning',
                title: '',
                text: 'ไม่พบข้อมูลสินค้า'
            }).then(() => {
                scanner.start()
            })
        }

        if (resp.data.status === "success" && resp.data.order_status !== null) {
            $("#product_code").html(resp.data.result.product_code)
            $("#detail").html(resp.data.result.detail)
            $("#customer_name").html(resp.data.result.customer_name ? resp.data.result.customer_name : "-")
            $("#customer_fb_name").html(resp.data.result.facebook_name)

            const name = resp.data.result.customer_name ? resp.data.result.customer_name : resp.data.result.facebook_name

            detail.val(name + ' (' + resp.data.result.detail + ') ')

            $("#confirm").attr('data-id', orderId);
            if (resp.data.edit_details.length > 0) {
                $('#list_note').css('display', 'block');
                $('.editlist').css('display', 'block');
                resp.data.edit_details.forEach((d, index) => {
                    $('.edit-detail').append(`<div class="text-danger">- ${d.detail}</div>`)
                    detail.val(detail.val() + ' ' + d.detail)
                })

            }
        }
        return resp
    }).then((resp) => {
        if (resp.data.status === "success" && resp.data.order_status !== null) {
            if (resp.data.order_status.status === "processing") {

                if ($("#role").val() === "seamstress" || $("#role").val() === "admin") {
                    $("#confirm").html("อยู่ระหว่างรอดำเนินการตัด");
                    $("#confirm").attr('disabled', true);
                    $('#confirm').addClass('btn-warning')
                }
                else {
                    $("#confirm").html("เริ่มงานตัด");
                    $('#confirm').addClass('btn-success')
                }

            }
            if (resp.data.order_status.status === "cutting") {
                if ($("#role").val() === "seamstress" || $("#role").val() === "admin") {
                    $("#confirm").html("อยู่ระหว่างดำเนินการตัด");
                    $("#confirm").attr('disabled', true);
                    $('#confirm').addClass('btn-warning')
                }
                else {
                    $("#confirm").html("เสร็จสิ้นงานตัด");
                    $('#confirm').addClass('btn-success')
                }
            }
            if (resp.data.order_status.status === "cut_completed") {
                if ($("#role").val() === "tailor" || $("#role").val() === "admin") {
                    $("#confirm").html("งานตัดเรียบร้อยแล้ว");
                    $("#confirm").attr('disabled', true);
                    $('#confirm').addClass('btn-warning')
                } else {
                    $("#confirm").html("เริ่มงานเย็บ");
                    $('#confirm').addClass('btn-success')
                }

            }
            if (resp.data.order_status.status === "sewing") {

                productCode.val(resp.data.result.product_code)
                productName.val(resp.data.result.product_code)

                if ($("#role").val() === "tailor" || $("#role").val() === "admin") {
                    $("#confirm").html("งานกำลังเย็บ");
                    $("#confirm").attr('disabled', true);
                    $('#confirm').addClass('btn-warning')
                } else {
                    axios.post('/tailor/check', {
                        tailor_id: resp.data.last_activity.employee_id,
                    }).then((response) => {
                        console.log(response.data)
                        tailor.val(response.data.id)
                        $('#tailor-label').val(response.data.username)
                        return response
                    }).then((response) => {
                        fillForm = 1;
                        return response
                    }).then((response) => {
                        $(".add-work-form").css('display', 'block')
                        $("#confirm").html("เสร็จสิ้นงานเย็บ");
                        $('#confirm').addClass('btn-success')
                    }).catch((err) => {
                        console.log(err)
                        $('#tailor-label').val("ไม่สามารถโหลดข้อมูลช่างตัดได้")
                        $("#confirm").attr('disabled', true);
                    })
                }

            }

            if (resp.data.order_status.status === "sew_completed") {
                if ($("#role").val() === "tailor" || $("#role").val() === "seamstress") {
                    $("#confirm").html("สินค้าตัดและเย็บเรียบร้อยแล้ว");
                    $("#confirm").attr('disabled', true);
                    $('#confirm').addClass('btn-warning')
                } else {
                    $("#confirm").html("ปรับเป็นสินค้าเตรียมจัดส่งให้ลูกค้า");
                    $('#confirm').addClass('btn-warning')
                }

            }

            if (resp.data.order_status.status === "prepare_shipping") {
                $("#confirm").html("สินค้าเตรียมจัดส่ง");
                $("#confirm").attr('disabled', true);
                $('#confirm').addClass('btn-success')
            }

            if (resp.data.order_status.status === "shipped") {
                $("#confirm").html("สินค้าจัดส่งเรียบร้อยแล้ว");
                $("#confirm").attr('disabled', true);
                $('#confirm').addClass('btn-success')
            }
        }
        return resp
    }).then((resp) => {
        if (resp.data.order_status !== null) {
            $('#order').modal('show')
        } else {
            Swal.fire({
                icon: 'warning',
                title: '',
                text: 'สินค้าอยู่ระหว่างการดำเนินการส่งงานช่าง'
            }).then(() => {
                window.location.reload()
            })
        }
    }).catch((err) => {
        console.log("Canceled")
    })

    $("#confirm").on("click", function (e) {
        e.preventDefault()

        $(this).removeAttr('disabled', true);

        if (fillForm === 1) {
            if (!productCode.val() || productCode.val().length <= 0) {
                productCode.addClass("is-invalid")
                productCodeFeedback.css('display', 'block')
            }

            if (!productName.val() || productName.val().length <= 0) {
                productName.addClass("is-invalid")
                productNameFeedback.css('display', 'block')
            }

            if (!product.val() || product.val().length <= 0) {
                product.addClass("is-invalid")
                productFeedback.css('display', 'block')
            }

            if ((product.find(':selected').attr('data-fix') === "no" && !tailor.val()) || (product.find(':selected').attr('data-fix') === "no" && tailor.val().length <= 0)) {
                tailor.addClass("is-invalid")
                tailorFeedback.css('display', 'block')
            }

            if (!detail.val() || detail.val().length <= 0) {
                detail.addClass("is-invalid")
                detailFeedback.css('display', 'block')
            }

            if (productCode.val() && productCode.val().length > 0 && productName.val() && productName.val().length > 0 && product.val() && product.val().length > 0 && detail.val().length > 0) {

                axios.post('https://order.phamaiintrend.co/order/update?order_id=' + orderId, {
                    order_process_status: getWorkState($("#confirm").text()),
                    employee: $("#user_id").val(),
                    employee_name: $("#name").val(),
                }).then((e) => {

                    if ((product.find(':selected').attr('data-fix') === "no" && !tailor.val()) || (product.find(':selected').attr('data-fix') === "no" && tailor.val().length <= 0) && parseFloat($(this).find(':selected').attr('data-tprice')) > 0.00) {
                        return false;
                    }

                    const formData = new FormData();
                    const file = document.querySelector('#upload');

                    formData.append("file", file.files[0]);
                    formData.append("product_code", $("#productCode").val());
                    formData.append("product_name", $("#productName").val());
                    formData.append("product", $("#product").val());
                    formData.append("tailor", is_fix ? $("#tailor").val() : null);
                    formData.append("quantity", 1);
                    formData.append("detail", $("#detail-form").val());

                    axios({
                        method: 'post',
                        url: '/work/upload',
                        data: formData,
                        header: {
                            'Content-Type': 'multipart/form-data',
                        },
                    })
                        .then((response) => {
                            Swal.fire({
                                icon: response.data.status,
                                text: response.data.result,
                            }).then((e) => {
                                window.location.reload();
                            })
                        })
                        .catch((response) => {
                            Toast.fire({
                                icon: 'error',
                                title: 'ไม่สามารถดำเนินการได้'
                            })
                            $(this).removeAttr('disabled', true);
                            scanner.start()
                        });
                }).catch((err) => {
                    Swal.fire({
                        icon: 'error',
                        text: 'ไม่สามารถดำเนินการได้'
                    })
                    $(this).removeAttr('disabled', true);
                    scanner.start()
                })
            }
        }
        else {
            axios.post('https://order.phamaiintrend.co/order/update?order_id=' + orderId, {
                order_process_status: getWorkState($("#confirm").text()),
                employee: $("#user_id").val(),
                employee_name: $("#name").val(),
            }).then((resp) => {
                Swal.fire({
                    icon: resp.data.status,
                    text: resp.data.result
                }).then(() => {
                    window.location.reload()
                })
            }).catch((err) => {
                Swal.fire({
                    icon: 'error',
                    text: 'ไม่สามารถดำเนินการได้'
                })
                $(this).removeAttr('disabled', true);
                scanner.start()
            })
        }
    })

}

    function getWorkState(state) {
        switch (state) {
            case "เริ่มงานตัด": {
                return "cutting";
            }
            case "เสร็จสิ้นงานตัด": {
                return "cut_completed";
            }
            case "เริ่มงานเย็บ": {
                return "sewing";
            }
            case "เสร็จสิ้นงานเย็บ": {
                return "sew_completed";
            }
            case "ปรับเป็นสินค้าเตรียมจัดส่งให้ลูกค้า": {
                return "prepare_shipping";
            }
            default: {
                return
            }
        }
    }

    $(productCode).on('input', function (e) {
        if (productCode.val().length > 0) {
            productCode.removeClass("is-invalid")
            productCodeFeedback.css('display', 'none')
        }
    })

    $(productName).on('input', function (e) {
        if (productName.val().length > 0) {
            productName.removeClass("is-invalid")
            productNameFeedback.css('display', 'none')
        }
    })

    $(product).on('change', function (e) {
        if (product.val().length > 0) {
            product.removeClass("is-invalid")
            productFeedback.css('display', 'none')
        }
        if (product.find(':selected').attr('data-fix') === "no") {
            $("#tailor-selection").css('display', 'block');
            is_fix = true
        }
        if ($(this).find(':selected').attr('data-fix') === "yes") {
            $("#tailor-selection").css('display', 'none');
            is_fix = false
        }
        if (parseFloat($(this).find(':selected').attr('data-tprice')) === 0.00) {
            $("#tailor-selection").css('display', 'none');
        }
    })

    $(tailor).on('change', function (e) {
        if (tailor.val().length > 0) {
            tailor.removeClass("is-invalid")
            tailorFeedback.css('display', 'none')
        }

    })

    $(detail).on('input', function (e) {
        if (detail.val().length > 0) {
            detail.removeClass("is-invalid")
            detailFeedback.css('display', 'none')
        }
    })
        </script>
</html>