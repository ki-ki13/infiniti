@extends('dist.layout')

@section('title')
    {{ env('APP_NAME') }} | Inbound
@endsection


@section('content')
    <div class="pagetitle">
        <h1>Inbound</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Inbound</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Inbound</h5>

                        <div class="my-4 d-flex gap-3" id="scanInput">
                            <div class="form-floating form-floating-outline my-auto flex-fill">
                                <input type="text" class="form-control" name="barcode" id="barcodeInput">
                                <label for="barcode">Barcode</label>
                            </div>
                            <button type="button" class="btn btn-primary my-auto" onclick="scan()">Query</button>
                        </div>

                        <table class="table my-4" id="itemDataTable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Barcode</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">SKU</th>
                                    <th scope="col">Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                        <button type="button" class="btn btn-primary" onclick="inbound()">Call Inbound API</button>
                    </div>
                </div>

            </div>
        </div>

    </section>
@endsection

@section('java_script')
    <script>
        const apiUrl = '{{ env('API_URL') }}';
        const username = '{{ env('AUTH_USERNAME') }}';
        const password = '{{ env('AUTH_PASSWORD_UNHASHED') }}';
        let barcodeItem = ''

        function scan() {
            console.log(username, password)
            const barcode = document.getElementById('barcodeInput').value;
            axios.post(apiUrl + '/proxy/getDetail', {
                    barcode: barcode,
                    username: username,
                    password: password
                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    const data = response.data;
                    console.log(data)
                    updateTable(data)
                    barcodeItem = barcode

                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function updateTable(itemData) {
            const tableBody = document.querySelector('.table tbody');
            tableBody.innerHTML = '';


            const row = document.createElement('tr');
            row.innerHTML = `
                    <td>${1}</td>
                    <td>${itemData.barcode}</td>
                    <td>${itemData.itemName}</td>
                    <td>${itemData.SKU}</td>
                    <td>${itemData.qty}</td>
                `;
            tableBody.appendChild(row);

            const dataTable = new simpleDatatables.DataTable('#itemDataTable');
            document.getElementById('barcodeInput').value = '';
        }

        function inbound() {
            axios.post(apiUrl + '/proxy/sendInbound', {
                    barcode: barcodeItem,
                    username: username,
                    password: password
                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    const data = response.data;
                    console.log(data)
                    const combinedData = collectTableData();
                   
                    combinedData[0].storage_location = data.storageLocation;
                    console.log(combinedData[0])
                    insertDB(combinedData[0]);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function collectTableData() {
            const tableBody = document.querySelector('.table tbody');
            const rows = tableBody.querySelectorAll('tr');
            const tableData = [];

            rows.forEach(row => {
                const rowData = {
                    // no: row.cells[0].innerText,
                    barcode: row.cells[1].innerText,
                    item_name: row.cells[2].innerText,
                    sku: row.cells[3].innerText,
                    qty: row.cells[4].innerText,
                    status: "inbound"
                };
                tableData.push(rowData);
            });

            return tableData;
        }

        function insertDB(data) {
            console.log(data)
            axios.post(apiUrl + `/stock/create`,
                    data, 
                    {
                        auth: {
                            username: username,
                            password: password
                        }
                    }
                )
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
@endsection
