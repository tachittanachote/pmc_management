

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#2e2e2e">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#2e2e2e">
        <title>Phamai Intrend - Pay Slip</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@300;400;500;700;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
        <style>
            html, body {
                font-family: 'Zen Kaku Gothic New', sans-serif;
            }

            .text-align-top {
                vertical-align:top;
                border: 0;
                flex-direction: column;
            }

            .item {
                padding: 10px;
                font-size: 14px;
                padding-bottom: 0px;
                display: flex;
                justify-content: space-between;
            }

            .signature_line {
                border-bottom: 1px solid black;
                width: 200px;
            }

            .item-bottom {
                padding: 10px;
                font-size: 14px;
                font-weight: bold;
                display: flex;
                justify-content: space-between;
            }

            th {
                border: 1px solid;
            }

            .td-border {
                border: 1px solid;
                border-bottom: 0px;
            }
            .td-border-no-top {
                border: 1px solid;
                border-top: 0px;
            }

            #frame {
                padding: 15px;
                margin: 10px;
                border: 1px black solid;
                position: relative;
            }

            .watermark {
                background: url(/images/bg.png);
                background-size: 260px 260px;
                position: absolute;
                width: 100%;
                height: 100%;
                opacity: 0.1;
            }

        </style>
    </head>
    <body>

            @php
                $deducts = \App\Deduct::where('user_id', $employee->id)->whereBetween('date', [\Carbon\Carbon::parse($startAt)->format('Y-m-d')." 00:00:00", \Carbon\Carbon::parse($endAt)->format('Y-m-d')." 23:59:59"])->get();
                $deductTotal = \App\Deduct::where('user_id', $employee->id)->whereBetween('date', [\Carbon\Carbon::parse($startAt)->format('Y-m-d')." 00:00:00", \Carbon\Carbon::parse($endAt)->format('Y-m-d')." 23:59:59"])->sum('amount');
            @endphp

            <div class="container">
                <div id="frame">
                <div class="watermark"></div>
                <table width="100%" style="margin-top:20px;">
                    <tr>
                        <td><h5>ร้านผ้าไหมอินเทรนด์</h5></td>
                        <td><h4 class="text-center">ใบแจ้งเงินเดือน/ค่าจ้าง</h4></td>
                        
                    </tr>
                    <tr>
                        <td>เลขที่ 221 หมู่2 ตำบลห้วยแก อำเภอชนบท 40180</td>
                        <td><h4 class="text-center">Pay Slip</h4></td>
                    </tr>
                    <tr>
                        <td>โทร 088-821-5969</td>
                        <td></td>
                    </tr>
                </table>
                <table width="100%" style="margin-top:50px; table-layout: fixed;">
                    <tr>
                        <td width="60%"><h5>ชื่อพนักงาน/ลูกจ้าง</h5></td>
                        <td>แผนก/ตำแหน่ง: {{$employee->getRole()}}</td>
                    </tr>
                    <tr>
                        <td>ชื่อ: {{$employee->name}}</td>
                        <td>วันที่: {{$startAt}} ถึง {{$endAt}}</td>
                    </tr>
                </table>
                <table width="100%" style="margin-top:20px; table-layout: fixed;">
                    <tbody style="border: 1px solid; border-bottom: 0px;">
                    <tr class="text-center">
                        <th style="padding: 5px;">รายการรับ</th>
                        <th style="padding: 5px;">รายการหัก</th>
                        <th style="padding: 5px;">รวม</th>
                    </tr>
                    <tr >
                        <td class="text-align-top td-border">
                            @if(count($workList) > 0)
								@php
                                $productList = array();
								@endphp
								@foreach($workList as $work)
									@if(!in_array($work->product_name, $productList))
										@php 
											array_push($productList, $work->product_name); 
										@endphp
									@endif
								@endforeach
								
								
								@foreach($productList as $proudct)
									@php
										$productCount[$loop->index] = 0;
										$productPrice[$loop->index] = 0;
									@endphp
								@endforeach
								
								@foreach($workList as $work)
									@if(in_array($work->product_name, $productList))
										@php
											$productIndex = array_search($work->product_name, $productList);
											$productCount[$productIndex] = $productCount[$productIndex] + $work->product_quantity;
											$productPrice[$productIndex] = $work->product_price;
										@endphp
									@endif
                                @endforeach
								
								@foreach($productList as $product)
								@php
									$productIndex = array_search($product, $productList);
								@endphp
                                <div class="item">
                                    <div>{{$product}}</div>
                                    <div>{{$productCount[$productIndex]}} x {{$productPrice[$productIndex]}}</div>
                                </div>
                                @endforeach
								
                            @endif
                        </td>
                        <td class="text-align-top td-border">
                            @if(count($deducts) > 0)
                                @foreach($deducts as $deduct)
                                    <div class="item">
                                        <div>{{$deduct->detail}}</div>
                                        <div>{{number_format($deduct->amount, 2, '.', ',')}} บาท</div>
                                    </div>
                                @endforeach
                            @endif
                        </td>
                        <td class="td-border">
                            <div class="item">
                                <div>รวมเงินที่ได้</div>
                                <div>{{$totalIncome}} บาท</div>
                            </div>
                            <div class="item">
                                <div>รวมเงินที่หัก</div>
                                <div>{{number_format($deductTotal, 2, '.', ',')}} บาท</div>
                            </div>
                            <div class="item">
                                <div>เงินได้สุทธิ (Net Income)</div>
                                <div>{{number_format($totalIncome - $deductTotal, 2, '.', ',')}} บาท</div>
                            </div>
                            <hr style="padding: 10px; width: 90%;">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="100%" style="table-layout: fixed; border: solid 1px; border-top: 0px;">
                    <tr >
                        <td style="vertical-align:bottom" class="td-border-no-top">
                            @if(count($workList) > 0)
                                @php
                                    $totalEarn = 0;
                                @endphp
                                @foreach($workList as $work)
                                    @php
                                        $totalEarn = $totalEarn + ($work->product_quantity * $work->product_price);
                                    @endphp
                                @endforeach
                                <div class="item-bottom">
                                    <div>รวม</div>
                                    <div>{{number_format($totalEarn, 2, '.', ',')}} บาท</div>
                                </div>
                                
                            @else
                            <div class="item-bottom">
                                <div>รวม</div>
                                <div>0.00 บาท</div>
                            </div>
                            @endif
                        </td>
                        <td style="vertical-align:bottom" class="td-border-no-top">
                            <div class="item-bottom">
                                <div>รวม</div>
                                <div>{{number_format($deductTotal, 2, '.', ',')}} บาท</div>
                            </div>
                        </td>
                        <td style="vertical-align:top" class="td-border-no-top">
                            <div class="item" style="margin-bottom: 20px;">
                                <div>ลงชื่อผู้รับเงิน/Signature</div>
                                <div class="signature_line"></div>
                            </div>
                            <div class="item" style="margin-bottom: 10px;">
                                <div>วันที่/Date</div>
                                <div class="signature_line"></div>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="row mt-3">
                    <div class="col-12">
                        <p><strong>หมายเหตุ:</strong> เอกสารใบจ่ายเงินเดือน/ค่าจ้าง (Pay Slip) ฉบับนี้จัดทำขึ้นโดยระบบอัตโนมัติ<p>
                        @php
                            $bankAccount = \App\BankAccount::where('user_id', $employee->id)->first();
                        @endphp
                        <p><strong>บัญชีผู้รับ:</strong> ธนาคาร: {{$bankAccount->bank_name}} หมายเลขบัญชี: {{$bankAccount->bank_no}} ชื่อบัญชีธนาคาร: {{$bankAccount->account_name}}<p>
                    </div>
                </div>

            </div>
                      <!--      <div class="row mt-3 m-2">
                    <div class="col-12 d-flex flex-row-reverse">
                        <button type="button" class="btn btn-success w-25" id="print"><i class="fas fa-print"></i> พิมพ์</button>
                    </div>
                </div>!-->
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js" integrity="sha512-UcDEnmFoMh0dYHu0wGsf5SKB7z7i5j3GuXHCnb3i4s44hfctoLihr896bxM0zL7jGkcHQXXrJsFIL62ehtd6yQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <script>


        $("#print").on('click', function() {
        })
    </script>
</html>
