@extends('dist.layout')

@section('title')
    {{ env('APP_NAME') }} | Dashboard
@endsection


@section('content')
    <div class="pagetitle">
        <h1>Outbound</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Outbound</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Outbound</h5>

                        <table class="table" id="itemDataTable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Barcode</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">SKU</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Storage Location</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <!-- Outbound Confirmation Modal -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Outbound item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Anda yakin akan melakukan outbound <span id="itemName"></span>?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="outboundItem()">Outbound</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('java_script')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            getData()
        })
        const apiUrl = '{{ env('API_URL') }}';
        const username = '{{ env('AUTH_USERNAME') }}';
        const password = '{{ env('AUTH_PASSWORD_UNHASHED') }}';

        function getData() {
            axios.get(apiUrl + `/stock`, {
                    auth: {
                        username: username,
                        password: password
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log(data)
                        updateTable(data.data)
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function updateTable(itemData) {
            const tableBody = document.querySelector('.table tbody');
            tableBody.innerHTML = '';

            itemData.forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${item.barcode}</td>
                    <td>${item.item_name}</td>
                    <td>${item.sku}</td>
                    <td>${item.qty}</td>
                    <td>${item.storage_location}</td>
                    <td>
                        <button class="btn btn-primary btn-sm mb-2" onclick="outboundConfirmation('${item.item_name}','${item.id}', '${item.storage_location}')">Outbound</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
            const dataTable = new simpleDatatables.DataTable('#itemDataTable');
        }

        let storage_location = ''
        let itemId = ''

        function outboundConfirmation(item, id, storageLocation) {
            document.getElementById('itemName').innerText = item;
            itemId = id
            storage_location = storageLocation
            const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            confirmationModal.show();
        }

        function outboundItem() {
            console.log(username, password)
            const id = itemId;
            axios.post(apiUrl + '/proxy/sendOutbound', {
                    username: username,
                    password: password,
                    storage_location: storage_location
                })
                .then(response => {
                    const data = response.data;
                    if (data.status == 'OK') {
                        console.log(data)
                        updateDB(data.itemDetail, id)
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function updateDB(data, id) {
            axios.post(apiUrl + `/stock/update?_method=PUT`, {
                    data: {
                        id: id,
                        barcode: data.barcode,
                        item_name: data.itemName,
                        sku: data.SKU,
                        qty: data.qty,
                        storage_location: storage_location,
                        status: 'outbound'
                    },
                    auth: {
                        username: username,
                        password: password
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log(data)
                        getData()
                        var myModalEl = document.getElementById('confirmationModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
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
